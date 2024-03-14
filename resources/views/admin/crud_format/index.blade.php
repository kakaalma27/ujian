@extends('layouts.admin')
@section('title', 'Upload Format Ujian')
@section('content')
<h2>Excel Files</h2>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.excel.create') }}" class="btn btn-primary">Upload Excel File</a>

<ul>
    @foreach($data as $file)
    <li>
        {{ $file->name }}
        <a href="{{ route('admin.excel.download', $file->id) }}">Download</a>
        <form action="{{ route('admin.excel.destroy', $file->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-link">Delete</button>
        </form>
    </li>
@endforeach

</ul>
@endsection
