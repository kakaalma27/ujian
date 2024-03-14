@extends('layouts.admin')
@section('title', 'kelas')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header fs-5 d-none d-sm-inline">
            Kelas
            </div>
            <div class="card-body">
                <a href="{{ route('kelas.create') }}" class="btn btn-dark mb-2">Tambah Kelas</a>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelaz as $item)                            
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->nama_kelas }}</td>
                            <td>
                                <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header fs-5 d-none d-sm-inline">
                Siswa
            </div>
            <div class="card-body">
                <a href="{{ route('admin.anggota') }}" class="btn btn-dark mb-2">Tambah Siswa</a>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Siswa</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                <tbody>
                    @foreach ($kelas as $kelasItem)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $kelasItem->nama_kelas }}</td>
                        <td>
                            @foreach ($kelasItem->userKelas as $userKelasItem)
                                {{ $userKelasItem->user->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            <td>
                                <a href="{{ route('admin.anggota.edit', $kelasItem->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.anggota.destroy', $kelasItem->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">Delete</button>
                                </form>
                            </td>
                        </td>
                    </tr>
                @endforeach
                
                </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>

@endsection