@extends('layouts.guru')
@section('title', 'Dashboard')
@section('content')
<div class="card mt-2" style="border: none; box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;">
    <div class="card-header bg-dark text-light">
        <h1>Hasil Ujian</h1>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">NAMA SISWA</th>
                <th scope="col">SOAL DIJAWAB</th>
                <th scope="col">TIDAK DIJAWAB</th>
                <th scope="col">TOTAL NILAI</th>
                <th scope="col">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td >Alma</td>
                <td >10</td>
                <td >2</td>
                <td >10</td>
                <td >X</td>
              </tr>
            </tbody>
          </table>
    </div>
</div>

@endsection