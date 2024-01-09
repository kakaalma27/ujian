@extends('layouts.admin')
@section('title', 'siswa Kelas')
@section('content')
<div class="container">
    <div class="card">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="card-header">
            <label>Anggota Kelas</label>
        </div>
        <div class="card-body">
            <form action="{{route('admin.upload')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <select class="form-select" name="kelas_id" aria-label="Default select example">
                        <option selected disabled>Choose a class</option>
                        @foreach($kelas as $kelasItem)
                            <option value="{{ $kelasItem->id }}">{{ $kelasItem->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <select name="user_ids[]" id="countries" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">kirim</button>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script>
    new MultiSelectTag('countries')  // id
</script>
@endsection