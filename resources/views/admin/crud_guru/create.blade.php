@extends('layouts.admin')
@section('title', 'Create Pelajaran')
@section('content')
<section>
    <div class="container">
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
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <label class="fs-4 fw-bold">Create Pelajaran</label>
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
    </div>
</section>
@endsection