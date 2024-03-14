@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mt-5" style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
            <div class="card-header text-center">
                <label class="fs-4 fw-normal">{{ __('Kode Akses') }}</label>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col">
                        <p>Selamat datang {{ Auth::user()->name }}</p>
                        <form action="{{ route('siswa.ujian') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <input type="text" name="kode_akses" class="form-control" placeholder="Masukkan Kode Ujian">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <button type="submit" class="form-control btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <img src="{{ asset('image/code.svg') }}" class="img-fluid" alt="">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
