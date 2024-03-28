@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mt-5" style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
            <div class="card-header text-center">
                <label class="fs-4 fw-normal">{{ __('Hasil Ujian') }}</label>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Pelajaran</th>
                                <th scope="col">Nilai</th>
                              </tr>
                            </thead>
                            <tbody id="lists">
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){

        function getNilaiUjian(){
            return $.ajax({
                url: 'http://127.0.0.1:8000/get-nilai-ujian',
                method: 'GET',
                success: function(response){
                    return response;
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }

        $.when(getNilaiUjian()).done(function(data){
            if(data.ok){
                const authId = "{{ Auth::user()->name }}";
                console.log(authId);
                const filteredData = data.data.filter(item => item.information.user_name == authId);
                // Menampilkan data yang telah difilter
                filteredData.forEach((item, index) => {
                    $("#lists").append(
                        `<tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.information.mapel}</td>
                            <td>${item.information.total_presentase}</td>
                        </tr>`
                    );
                });
            }
        });

    });
</script>
