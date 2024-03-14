@extends('layouts.admin')
@section('title', 'Edit Pelajaran')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fs-5 ms-3 d-none d-sm-inline">{{ __('Edit Pelajaran') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pelajaran.update', $pelajaran->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="pelajaran" class="col-md-4 col-form-label text-md-right">{{ __('Pelajaran') }}</label>

                            <div class="col-md-6">
                                <input id="pelajaran" type="text" class="form-control @error('pelajaran') is-invalid @enderror" name="pelajaran" value="{{ $pelajaran->pelajaran }}" required autocomplete="pelajaran" autofocus>

                                @error('pelajaran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kode_akses" class="col-md-4 col-form-label text-md-right">{{ __('Kode Akses') }}</label>

                            <div class="col-md-6">
                                <input id="kode_akses" type="text" class="form-control @error('kode_akses') is-invalid @enderror" name="kode_akses" value="{{ $pelajaran->kode_akses }}" autocomplete="kode_akses">

                                @error('kode_akses')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
