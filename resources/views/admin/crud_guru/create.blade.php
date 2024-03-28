@extends('layouts.admin')
@section('title', 'Create Pelajaran')
@section('content')
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px; boder:none;">
                    <div class="card-header  text-dark">
                        <label class="fs-5 ms-3 d-none d-sm-inline">Create Pelajaran</label>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pelajaran.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Pilih guru</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                                    <option value="" disabled selected>Pilih guru</option>
                                    @foreach ($users as $userId => $userName)
                                        <option value="{{ $userId }}" {{ old('user_id') == $userId ? 'selected' : '' }}>
                                            {{ $userName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="pelajaran">pelajaran</label>
                                <input type="text" name="pelajaran" id="pelajaran" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="kode_akses">kode_akses</label>
                                <input type="kode_akses" name="kode_akses" id="kode_akses" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-dark mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection