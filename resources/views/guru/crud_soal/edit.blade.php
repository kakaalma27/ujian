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
            <form action="{{ route('guru.ujian.update', $data[0]->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Use the PUT method for updates --}}
                <div class="col-md-12">
                    <div class="card"
                        style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                        <div class="card-header fs-5 d-none d-sm-inline">
                            Edit Ujian Pilihan Ganda
                        </div>
                        <div class="card-body" id="edit-soal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="pelajaran_id" id="pelajaran_id" class="form-control bg-white">
                                            <option value="{{ $data[0]->pelajarans->id }}" selected>{{
                                                $data[0]->pelajarans->pelajaran
                                                }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <select name="kelas_id" id="kelas_id" class="form-control bg-white">
                                            <option value="{{ $data[0]->kelas->kelas_id }}" selected>{{
                                                $data[0]->kelas->kelas->nama_kelas }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="number" name="durasi" id="durasi" class="form-control bg-white"
                                            placeholder="jam" value="{{$data[0]->pelajarans->durasi }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="number" class="form-control bg-white" name="durasi_menit"
                                            placeholder="menit" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="card"
                        style="border: none; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                        <div class="card-header bg-dark text-light">
                            <h3>Edit Soal Ujian</h3>
                        </div>
                        <div class="card-body" id="add_soal">
                            <div class="d-flex flex-column gap-5">
                                @foreach ($data as $item)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <textarea class="form-control editor" placeholder="Leave a comment here"
                                                    name="soal[{{ $loop->index }}][isi_soal]">{{ $item->isi_soal }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="soal[{{ $loop->index }}][isi_jawaban][]"
                                                class="form-control bg-white" placeholder="Pilihan A"
                                                value="{{ $item->jawabans[0]->isi_jawaban }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="soal[{{ $loop->index }}][isi_jawaban][]"
                                                class="form-control bg-white" placeholder="Pilihan B"
                                                value="{{ $item->jawabans[1]->isi_jawaban }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="soal[{{ $loop->index }}][isi_jawaban][]"
                                                class="form-control bg-white" placeholder="Pilihan C"
                                                value="{{ $item->jawabans[2]->isi_jawaban }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="soal[{{ $loop->index }}][isi_jawaban][]"
                                                class="form-control bg-white" placeholder="Pilihan D"
                                                value="{{ $item->jawabans[3]->isi_jawaban }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="soal[{{ $loop->index }}][isi_jawaban][]"
                                                class="form-control bg-white" placeholder="Pilihan E"
                                                value="{{ $item->jawabans[4]->isi_jawaban }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        @php
                                        $jawabans = $item->jawabans->toArray();
                                        $jawaban_benar = array_search(1, array_column($jawabans, 'is_correct'));
                                        @endphp
                                        <select class="form-select bg-white"
                                            name="soal[{{ $loop->index }}][isi_jawaban_correct]"
                                            aria-label="Default select example">
                                            <option selected>Pilih Jawaban</option>
                                            <option value="0" @selected($jawaban_benar==0)>A</option>
                                            <option value="1" @selected($jawaban_benar==1)>B</option>
                                            <option value="2" @selected($jawaban_benar==2)>C</option>
                                            <option value="3" @selected($jawaban_benar==3)>D</option>
                                            <option value="4" @selected($jawaban_benar==4 )>E</option>
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update</button>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // set all .editor to ckeditor
        const editors = document.querySelectorAll('.editor');
        editors.forEach(editor => {
            ClassicEditor
                .create( editor )
                .catch( error => {
                    console.error( error );
                })
        }) 
    });
</script>