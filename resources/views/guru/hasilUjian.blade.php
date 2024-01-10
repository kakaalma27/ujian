@extends('layouts.guru')
@section('title', 'Dashboard')
@section('content')
<div class="card mt-2" style="border: none; box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;">
    <div class="card-header bg-dark text-light">
        <h1>Hasil Ujian</h1>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">NAMA SISWA</th>
                <th scope="col">BUTIR SOAL</th>
                <th scope="col">SOAL DIJAWAB</th>
                <th scope="col">TIDAK/SALAH DIJAWAB</th>
                <th scope="col">TOTAL NILAI</th>
                <th scope="col">PELAJARAN</th>
                <th scope="col">OPSI</th>
              </tr>
            </thead>
            <tbody id="lists">
            </tbody>
          </table>
    </div>
</div>

<script>
    $(document).ready(function(){


        function initalize(){
            return $.ajax({
                url: 'http://127.0.0.1:8000/get-nilai-ujian',
                method: 'GET',
                success: function(response){
                    return response
                },
                error: function(jqXHR){
                    console.log(jqXHR)
                }
            })
        }

        $.when(initalize()).done(function(data){
            if(data.ok){
                for(let i = 0; i < data.data.length; i++){
                    $("#lists").append(
                        `
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${data.data[i].information.user_name}</td>
                            <td>${data.data[i].information.jumlah_soal}</td>
                            <td>${data.data[i].information.total_benar}</td>
                            <td>${data.data[i].information.total_salah}</td>
                            <td>${data.data[i].information.total_presentase}</td>
                            <td>${data.data[i].information.mapel}</td>
                            <td>X</td>
                        </tr>
                        `
                    )
                }
            }
        })

    })
</script>

@endsection
