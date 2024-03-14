@extends('layouts.app')
@section('title', 'Ujian')
@section('content')

<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card mt-5" style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
            <div class="card-header text-center">
              <label class="fs-4 fw-normal text-dark">Informasi Ujian</label>
               </div>
                <div class="card-body">
                <div class="mb-3">
                    <label id="kelas">Kelas : </label>
                </div>
                
                <div class="mb-3">
                    <label id="pelajaran">pelajaran :  </label>
                </div>
                <div class="mb-3">
                    <label id="jumlah-soal">Jumlah Soal : </label>
                </div>
                
                    <div class="mb-3">
                        <label id="waktu-ujian">Waktu Ujian : </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
          <div class="card mt-5" style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
            <div class="card-header text-center">
              <label>Tabel Ujian</label>
                </div>
                <div class="card-body" id="total-soal">

                </div>
            </div>
        </div>
        
        
        <div class="col-md-12 mt-2">
        <form action="{{route('siswa.ujian')}}" method="POST">
            @csrf
                <div class="card bg-white border-0" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                  <div class="card-header text-center">
                    <label class="fs-4 fw-nromal text-dark" id="soal-no">Soal No: </label>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="card-text fs-5 fw-bold" id="isi-soal" data-id="-1"></p>

                                <div class="form-check" id="list-jawaban">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="d-flex justify-content-center mt-2">
                            <a href="#" class="btn btn-primary me-2" data-id="-1" id="prev-soal">Prev</a>
                            <a href="#" class="btn btn-primary me-2" data-id="0" id="next-soal">Next</a>
                        </div>
                      </div>
                      <div class="col">
                        
                        <a href="#" class="btn btn-danger me-2" id="selesai">Selesai</a>
                      </div>
                    </div>
                      
                </div>
                
        </form>
        </div>
    </div>

</div>


<script>
  $(document).ready(function() {
    function initialize() {
      let result;
      $.ajax({
        url: 'http://127.0.0.1:8000/get-ujian-details',
        method: "GET",
        async: false,
        success: (response) => {
          result = response;
        }
      });
      return result;
    };

    let result = initialize();
    loadForm(0);

    function loadTotalSoal() {
      let totalSoal = result['data']['form'].length;
      let totalSoalHTML = '';
      for (let i = 0; i < totalSoal; i++) {
        let soalIndex = i + 1;
        let buttonClass = isJawabanSelected(i) ? 'btn btn-primary btn-soal' : 'btn btn-danger btn-soal';
        totalSoalHTML += `<button type="button" class="${buttonClass}" data-soal-index="${i}">${soalIndex}</button>`;
      }
      $("#total-soal").html(totalSoalHTML);
    };

    $("#selesai").click(function(e){
        e.preventDefault()
        let done = confirm("Anda yakin akan selesai")
        if(done){
          $.ajax({
            url: "http://127.0.0.1:8000/selesai-ujian",
            method: "GET",
            success: (response) => {
              window.location.href = "/home"
            }
          })
        }
      })

    function isJawabanSelected(index) {
      let jawabanId = result['data']['form'][index]['jawaban_id'];
      return jawabanId !== null;
    };

    function loadForm(resultIndex){
      if (resultIndex >= result['data']['form'].length || resultIndex < 0) {
        return;
      }
      console.log(result['data']['form'])
      let soalNo = resultIndex + 1; // Nomor soal (index + 1)
      $("#soal-no").text(`Soal No: ${soalNo}`);
      $("#isi-soal").text(result['data']['form'][resultIndex]['isi_soal']);
      $("#isi-soal").attr("data-id", result['data']['form'][resultIndex]['user_jawaban_id']);
      $("#list-jawaban").html("");
      $(`input[type='radio']`).prop("checked", false);
      for (let i = 0; i < result['data']['form'][resultIndex]['jawaban'].length; i++) {
        $("#list-jawaban").append(`
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault${i}" value="${result['data']['form'][resultIndex]['jawaban'][i]['jawaban_id']}">
          <label class="form-check-label fs-5" for="flexRadioDefault${i}">${result['data']['form'][resultIndex]['jawaban'][i]['isi_jawaban']}</label>
          <br>
        `);
      }
      if (result['data']['form'][resultIndex]['jawaban_id'] != null) {
        $(`input[type='radio'][value='${result['data']['form'][resultIndex]['jawaban_id']}']`).prop("checked", true);
      }

      // Mengubah warna tombol soal berdasarkan kondisi klik radio
      let button = $(`.btn-soal[data-soal-index="${resultIndex}"]`);
      if ($(`input[name="flexRadioDefault"]:checked`).length > 0) {
        button.removeClass('btn-danger').addClass('btn-primary');
      } else {
        button.removeClass('btn-primary').addClass('btn-danger');
      }
    };

    function startTimer(duration, display) {
      var timer = duration, minutes, seconds;
      let timeInterval = setInterval(function () {
          minutes = parseInt(timer / 60, 10);
          seconds = parseInt(timer % 60, 10);

          minutes = minutes < 10 ? "0" + minutes : minutes;
          seconds = seconds < 10 ? "0" + seconds : seconds;

          display.textContent = "Waktu Ujian : "+ minutes + ":" + seconds;

          if (--timer < 0) {
              display.textContent = "Waktu Ujian : 00:00";
              clearInterval(timeInterval)
          }
      }, 1000);
  }

    startTimer((result['data']['information']['end_timestamp'] - (new Date().getTime() / 1000)), document.getElementById("waktu-ujian"))
    $("#pelajaran").text("Pelajaran : "+result['data']['information']['mapel'])
    $("#kelas").text("Kelas : "+result['data']['information']['kelas'])

    $("#jumlah-soal").text("Jumlah Soal : "+result['data']['information']['jumlah_soal'])


    $(document).on("change", "input[type='radio']", function() {
      $.ajax({
        url: 'http://127.0.0.1:8000/update-ujian-details',
        method: "POST",
        async: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          user_jawaban_id: parseInt($("#isi-soal").attr("data-id")),
          jawaban_id: parseInt($(this).val())
        },
        success: (response) => {
          if(!response.ok){
            alert(response.message)
          }
      result = initialize();
      let currentSoalIndex = parseInt($("#soal-no").text().replace("Soal No: ", "")) - 1;
      let currentButton = $(`.btn-soal[data-soal-index="${currentSoalIndex}"]`);
      if (isJawabanSelected(currentSoalIndex)) {
        currentButton.removeClass('btn-danger').addClass('btn-primary');
      } else {
        currentButton.removeClass('btn-primary').addClass('btn-danger');
      }
    }
      });
    });

    $(document).on("click", ".btn-soal", function() {
      let soalIndex = $(this).index();
      loadForm(soalIndex);
    });

    $("#prev-soal").click(function(e) {
      e.preventDefault();
      if (parseInt($(this).attr("data-id")) < 0) {
        return;
      }
      let value = parseInt($(this).attr("data-id"));
      $(this).attr("data-id", value - 1);
      $("#next-soal").attr("data-id", value);
      if (value > 0) {
        loadForm(value - 1);
        console.log("back");
      } else {
        loadForm(value);
      }

    });

    $("#next-soal").click(function(e) {
      e.preventDefault();
      if (parseInt($(this).attr("data-id")) >= result['data']['form'].length) {
        return;
      }
      let value = parseInt($(this).attr("data-id"));
      $(this).attr("data-id", value + 1);
      $("#prev-soal").attr("data-id", value);
      loadForm(value + 1);
      console.log("next");
    });

    loadTotalSoal();

  });

</script>

@endsection
