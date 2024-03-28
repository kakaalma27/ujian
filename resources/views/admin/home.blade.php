@extends('layouts.admin')
@section('title', 'home')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card bg-white text-dark" style="box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px; border:none;">
                    <div class="card-body text-center">
                        <p>{{ $guruCount }}</p>
                        <label>Total Guru</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-white text-dark" style="box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px; border:none;">
                    <div class="card-body text-center">
                        <p>{{ $userCount }}</p>
                        <label>Total Siswa</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-white text-dark" style="box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px; border:none;">
                    <div class="card-body text-center">
                        <p>{{ $kelasCount }}</p>
                        <label>Total Kelas</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-white text-dark" style="box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px; border:none;">
                    <div class="card-body text-center">
                        <p> {{$pelajaranCount}} </p>
                        <label>Total Pelajaran</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                       <label for="" class="fs-4">Progres Input</label>
                    </div>
                    <div class="card-body">
                        @php
                        $totalGuru = 30; // Anggap target total guru adalah 100%
                        $totalUser = 30; // Anggap target total user adalah 200%
                        $totalKelas = 30; // Anggap target total kelas adalah 20%
                        $totalPelajaran = 30; // Anggap target total pelajaran adalah 10%
                    @endphp
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $guruCount / $totalGuru * 100 }}%;" aria-valuenow="{{ $guruCount / $totalGuru * 100 }}" aria-valuemin="0" aria-valuemax="100">{{$guruCount}} </div>
                        </div>
                    
                        <div class="progress mt-3 mb-2" style="height: 20px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $userCount / $totalUser * 100 }}%;" aria-valuenow="{{ $userCount / $totalUser * 100 }}" aria-valuemin="0" aria-valuemax="100">{{$userCount}}</div>
                        </div>
                    
                        <div class="progress mt-3 mb-2" style="height: 20px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $kelasCount / $totalKelas * 100 }}%;" aria-valuenow="{{ $kelasCount / $totalKelas * 100 }}" aria-valuemin="0" aria-valuemax="100">{{$kelasCount}}</div>
                        </div>
                    
                        <div class="progress mt-3 mb-2" style="height: 20px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $pelajaranCount / $totalPelajaran * 100 }}%;" aria-valuenow="{{ $pelajaranCount / $totalPelajaran * 100 }}" aria-valuemin="0" aria-valuemax="100">{{$pelajaranCount}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection