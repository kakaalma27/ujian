@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card bg-white">
                    <div class="card-body">
                        <div class="card-header bg-dark text-light">
                            <label class="fs-4 fw-normal text-center">Informasi Account</label>
                        </div>
                        <div class="card-body">
                            <label>Selamat datang  @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            {{ Auth::user()->name }}
                            <br>
                            </label>
                            <form action="{{route('siswa.ujian')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <input type="text" name="kode_akses" class="form-control bg-white" placeholder="Masukan Kode Ujian">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <button type="submit" class="form-control">Submit</button>
                                        </div>                                 
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
