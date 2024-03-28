@extends('layouts.admin')
@section('title', 'edit')
@section('content')
<div class="card">
    <div class="card-header fs-5 d-none d-sm-inline">
        Edit Kelas
    </div>
    <div class="card-body">
        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{ $kelas->nama_kelas }}">

            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection