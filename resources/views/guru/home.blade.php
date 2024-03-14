@extends('layouts.guru')
@section('title', 'Dashboard')
@section('content')
<section>

        <div class="row">
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>{{ $totalSiswa }}</p>
                        <label>Total Siswa</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>{{ $siswaUjian }}</p>
                        <label>mengikuti ujian</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>{{ $siswaTidakUjian }}</p>
                        <label>tidak mengikuti ujian</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>{{ $siswaUjian }}</p>
                        <label>Dinilai</label>
                    </div>
                </div>
            </div>
        </div>

</section>

<section>
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header fs-5 d-flex justify-content-between">
                    Progres Bar 
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                
                
                <div class="card-body">
                    <div class="mb-2">
                        <label>Mengikuti Ujian</label>
                        <div class="progress" role="progressbar" aria-valuenow="{{ ($siswaUjian / $totalSiswa) * 100 }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{ ($siswaUjian / $totalSiswa) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label>Tidak Ujian/Belum</label>
                        <div class="progress" role="progressbar" aria-valuenow="{{ ($siswaTidakUjian / $totalSiswa) * 100 }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{ ($siswaTidakUjian / $totalSiswa) * 100 }}%; height: 20px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-5">
                <div class="card-header fs-5 d-none d-sm-inline">
                    Dinilai
                </div>
                <div class="card-body">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['corechart']});
                      google.charts.setOnLoadCallback(drawChart);
                
                      function drawChart() {
                
                        var data = google.visualization.arrayToDataTable([
                          ['Effort', 'Amount given'],
                          ['Mengikuti Ujian', {{$siswaUjian}}],
                          ['Tidak Ujian/Belum', {{$siswaTidakUjian}}],
                        ]);
                
                        var options = {
                          pieHole: 0.5,
                          pieSliceTextStyle: {
                            color: 'black',
                          },
                          legend: 'none'
                        };
                
                        var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
                        chart.draw(data, options);
                      }
                    </script>
                    <div id="donut_single" class="d-flex justify-content-between"></div>
                </div> 
                
            </div>
        </div>
    </div>
</section>
@endsection