@extends('layouts.admin')
@section('title', 'Account')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card text-dark" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px; boder:none;">
                    <div class="card-header fs-5 d-none d-sm-inline">
                        <span class="fs-4 fw-normal">Informasi Account</span>
                    </div>
                    <div class="card-body">
                        <div class="row py-2">
                            <div class="col-md-2">
                                <a href="{{ route('account.create') }}" class="btn btn-dark">Tambah Data</a>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('account.index') }}" method="GET" class="d-flex">
                                    <select class="form-control me-2" id="listRole" name="listRole">
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="0" {{ request('listRole') == 0 ? 'selected' : '' }}>User</option>
                                        <option value="1" {{ request('listRole') == 1 ? 'selected' : '' }}>Guru</option>
                                        <option value="2" {{ request('listRole') == 2 ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                            </div>
                            <div class="col-md-6 ms-auto">
                                <form class="d-flex" method="GET">
                                    @csrf
                                    <input class="form-control me-2" type="search" placeholder="Search Account" aria-label="Search" name="search" value="{{ $searchQuery }}">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                                
                            </div>
                        </div>
                        <table class="table table-white text-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $selectedRole == 0 ? $account->name : $account->name }}</td>
                                        <td>{{ $selectedRole == 0 ? $account->email : $account->email }}</td>
                                        <td>{{ $selectedRole == 0 ? $account->role : $account->role }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('account.edit', $account->id) }}" class="btn btn-primary me-2">Edit</a>
                                            <form action="{{ route('account.destroy', $account->id) }}" method="POST">
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
                                    @if ($accounts->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $accounts->previousPageUrl() }}">Previous</a>
                                        </li>
                                    @endif
                                    @for ($i = 1; $i <= $accounts->lastPage(); $i++)
                                    <li class="page-item {{ $accounts->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $accounts->url($i) }}"> {{ $i }}</a>
                                    </li>
                                    @endfor
                                    {{-- Next Page Link --}}
                                    @if ($accounts->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $accounts->nextPageUrl() }}">Next</a>
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
