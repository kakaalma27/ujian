@extends('layouts.admin')
@section('title', 'Upload Format Ujian')
@section('content')
<h2>Upload Excel File</h2>

<form action="{{ route('admin.excel.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <input type="text" name="name" class="form-control" value="Format Ujian">
        <input type="file" name="path" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>
@endsection