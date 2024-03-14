@extends('layouts.admin')
@section('title', 'Pelajaran')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header fs-5 d-none d-sm-inline">
                        Pelajaran
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('pelajaran.create') }}" class="btn btn-dark">Tambah Data</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Pelajaran</th>
                                    <th scope="col">Kode Akses</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($pelajarans as $index => $pelajaran)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $pelajaran->guruMengajars->first()->user->name ?? 'N/A' }}</td>
                                    <td>{{ $pelajaran->pelajaran }}</td>
                                    <td>{{ $pelajaran->kode_akses }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('pelajaran.edit', $pelajaran->id) }}" class="btn btn-primary me-2">Edit</a>
                                        <form action="{{ route('pelajaran.destroy', $pelajaran->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger me-2">Delete</button>
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