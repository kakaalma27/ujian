@extends('layouts.admin')
@section('title', 'edit siswa kelas')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fs-5 d-none d-sm-inline">
                    Edit Siswa
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.anggota.update', $kelas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="kelas_id">Kelas:</label>
                            <select name="kelas_id" id="kelas_id" class="form-select">
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="user_ids">Anggota:</label>
                            <select name="user_ids[]" id="countries" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $selectedUserIds) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script>
    new MultiSelectTag('countries')  // id
</script>
@endsection