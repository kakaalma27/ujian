@extends('layouts.admin')
@section('title', 'home')
@section('content')
<section>
    <div class="container">
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
    </div>
</section>
@endsection