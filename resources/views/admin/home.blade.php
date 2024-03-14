@extends('layouts.admin')
@section('title', 'home')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card bg-dark text-light">
                    <div class="card-body text-center">
                        <p>{{ $guruCount }}</p>
                        <label>Total Guru</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light">
                    <div class="card-body text-center">
                        <p>{{ $userCount }}</p>
                        <label>Total Siswa</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light">
                    <div class="card-body text-center">
                        <p>{{ $kelasCount }}</p>
                        <label>Total Kelas</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light">
                    <div class="card-body text-center">
                        <p> {{$pelajaranCount}} </p>
                        <label>Total Pelajaran</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card mt-5 mb-2">
                    <div class="card-header fs-5 d-none d-sm-inline">
                        Proges Input Siswa
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 25%">Siswa 25%</div>
                              </div>
                        </div>
                        <div class="mb-2">
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                              <div class="progress-bar" style="width: 25%; height: 15px;">Guru 25%</div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
@endsection