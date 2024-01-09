@extends('layouts.admin')
@section('title', 'buat')
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
                        <label class="fs-4 fw-bold">Create nama_kelas</label>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kelas.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_kelas">nama_kelas</label>
                                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
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
