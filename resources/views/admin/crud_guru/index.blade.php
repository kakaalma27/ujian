@extends('layouts.admin')
@section('title', 'Pelajaran')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px; boder:none;">
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
                        <div class="container">

                            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                                <ul class="pagination" class="d-flex justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($pelajarans->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $pelajarans->previousPageUrl() }}">Previous</a>
                                        </li>
                                    @endif
                                    @for ($i = 1; $i <= $pelajarans->lastPage(); $i++)
                                    <li class="page-item {{ $pelajarans->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pelajarans->url($i) }}"> {{ $i }}</a>
                                    </li>
                                    @endfor
                                    {{-- Next Page Link --}}
                                    @if ($pelajarans->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $pelajarans->nextPageUrl() }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection