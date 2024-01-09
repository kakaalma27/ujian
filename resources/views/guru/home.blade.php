@extends('layouts.guru')
@section('title', 'Dashboard')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>0</p>
                        <label>Total Siswa</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>0</p>
                        <label>mengikuti ujian</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>0</p>
                        <label>tidak mengikuti ujian</label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-light" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                    <div class="card-body text-center">
                        <p>0</p>
                        <label>Dinilai</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection