@extends('layouts.guru')
@section('title', 'Informasi Ujian')
@section('content')
<section>
    <div class="container">
        <div class="card mt-2" style="border: none; box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;">
            <div class="card-header fs-5 d-none d-sm-inline">
                Informasi Ujian
            </div>
            <div class="card-body">
                <a href="{{ route('guru.create') }}" class="btn btn-dark">Tambah soal</a>

                <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload soal</a>

                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pelajaran</th>
                        <th scope="col">kelas</th>
                        <th scope="col">Waktu Ujian</th>
                        <th scope="col">kode akses</th>
                        <th scope="col">Status</th>
                        <th scope="col">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelajarans as $item)                            
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{$item['pelajaran']}}</td>
                          <td>X-IPS-10</td>
                          <td>{{$item['durasi']}} Menit</td>
                          <td>{{$item['kode_akses']}}</td>
                          <td>
                            @if($soalAda[$item->id])
                                True
                            @else
                                False
                            @endif
                        </td>
                                                  <td>
                            <a href="{{ route('guru.ujian.edit', $item['id']) }}" class="btn btn-warning">Edit</a>
            
                            <form action="{{ route('guru.ujian.destroy', $item['id']) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="uploadModalLabel">Upload Soal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{route('guru.uploadExcal')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card bg-white" style="border: none; box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;">
                  <div class="card-header bg-dark text-light">
                      <h3>Ujian pilihan Ganda</h3>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <select name="pelajaran_id" id="pelajaran_id" name="pelajaran_id" class="form-control bg-white">
                                    <option selected>Pilih Pelajaran</option>
                                    @foreach ($pelajarans as $pelajaran)
                                    <option value="{{ $pelajaran->id }}">{{ $pelajaran->pelajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <select name="kelas_id" id="kelas_id" class="form-control">
                                    <option selected>pilih kelas</option>
                                    @foreach ($kelas as $kelaz)
                                        <option value="{{ $kelaz->id }}">{{ $kelaz->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="number" name="durasi" id="durasi" class="form-control bg-white" placeholder="jam" >
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="number" class="form-control bg-white" name="durasi_menit" placeholder="menit">
                            </div>
                        </div>
                          <div class="mb-3 mt-2">
                            <input class="form-control bg-whte" type="file" name="xlsx_file" id="formFile">
                            <button type="submit" class="btn btn-primary mb-1 mt-2">Submit</button>
                          </div>
                      </div>
                  </div>
              </div>

              </form>
              @foreach($data as $file)
              <a href="{{ route('guru.excel.download', $file->id) }}" class="btn btn-dark">Format Ujian</a>
              @endforeach
          </div>
      </div>
  </div>
</div>

@endsection