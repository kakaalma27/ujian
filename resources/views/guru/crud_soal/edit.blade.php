@extends('layouts.guru')
@section('title', 'Edit Ujian Pilihan Ganda')
@section('content')
<section>
    <div class="container">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row">
            <form action="{{ route('guru.ujian.update', $userSoal[0]->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Use the PUT method for updates --}}
                <div class="col-md-12">
                    <div class="card" style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                        <div class="card-header fs-5 d-none d-sm-inline">
                            Edit Ujian Pilihan Ganda
                        </div>
                        <div class="card-body" id="edit-soal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="pelajaran_id" id="pelajaran_id" class="form-control bg-white">
                                            <option value="{{ $userSoal[0]->pelajaran_id }}" selected>{{ $userSoal[0]->pelajaran }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="kelas_id" id="kelas_id" class="form-control bg-white">
                                            <option value="{{ $userSoal[0]->kelas_id }}" selected>{{ $userSoal[0]->nama_kelas }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="number" name="durasi" id="durasi" class="form-control bg-white" placeholder="jam" value="{{$userSoal[0]->durasi }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="number" class="form-control bg-white" name="durasi_menit" placeholder="menit" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="card" style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                        <div class="card-header bg-dark text-light">
                            <h3>Edit Soal Ujian</h3>
                        </div>
                        <div class="card-body" id="add_soal">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" name="data[soal][0][isi_soal][]" id="editor"></textarea>
                                        </div>      
                                    </div>                                
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="data[soal][0][isi_jawaban][]" class="form-control bg-white" placeholder="Pilihan A" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="data[soal][0][isi_jawaban][]" class="form-control bg-white" placeholder="Pilihan B">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="data[soal][0][isi_jawaban][]" class="form-control bg-white" placeholder="Pilihan C">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="data[soal][0][isi_jawaban][]" class="form-control bg-white" placeholder="Pilihan D">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="data[soal][0][isi_jawaban][]" class="form-control bg-white" placeholder="Pilihan E">
                                    </div>
                                </div>
                            </div>
                            <select class="form-select bg-white" name="data[soal][0][isi_jawaban_correct]" aria-label="Default select example">
                                <option selected>Pilih Jawaban</option>
                                <option value="0">A</option>
                                <option value="1">B</option>
                                <option value="2">C</option>
                                <option value="3">D</option>
                                <option value="4">E</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>
</section>
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

</script>

