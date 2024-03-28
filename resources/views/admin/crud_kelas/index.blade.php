@extends('layouts.admin')
@section('title', 'kelas')
@section('content')
<div class="row">
    <div class="col">
        <div class="card" style="box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px; border:none;">
            <div class="card-header fs-5 d-none d-sm-inline">
                 <span class="fs-4 fw-normal">Kelas</span>
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
        <div class="card" style="box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px; border:none;">
            <div class="card-header fs-5 d-none d-sm-inline">
                <span class="fs-4 fw-normal">Tambah Siswa</span>
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
                            {{ $totalUser }}
                        </td>
                            <td>
                                <a href="{{ route('admin.anggota.edit', $kelasItem->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.anggota.destroy', $kelasItem->id) }}" method="POST" style="display: inline;">
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
</div>

@endsection