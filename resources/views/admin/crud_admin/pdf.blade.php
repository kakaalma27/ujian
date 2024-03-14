@extends('layouts.admin')
@section('title', 'Account')
@section('content')

        <div class="row">
            @foreach ($data as $account)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nama : {{ $account['name'] }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Email :{{ $account['email'] }}</h6>
                        <p class="card-text">Password: {{ $account['password'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach

@endsection

