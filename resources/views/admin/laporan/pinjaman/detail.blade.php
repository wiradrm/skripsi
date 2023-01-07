@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Laporan Pinjaman</h1>
<form class="form-row mb-4" action="{{ route('laporan.detail_simpanan') }}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="no_pinjam" class="col-form-label">Pinjaman</label>
            <select class="form-control selectpicker"  name="no_pinjam" id="no_pinjam" data-live-search="true">
                <option hidden></option>
                @foreach($pinjam as $key => $item)
                <option value="{{$item->no_pinjam}}">{{$item->no_pinjam}} | {{$item->nasabah->nama}}</option>
                @endforeach
            </select>
    </div>
    <div class="form-group my-0 col-md">
        <label for="from" class="col-form-label">Dari</label>
        <input type="date" class="form-control" id="from" name="from" required>
    </div>
    <div class="form-group my-0 col-md">
        <label for="to" class="col-form-label">Sampai</label>
        <input type="date" class="form-control" id="to" name="to" required>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
    </form>
    <form action="{{route('laporan.pinjam.export')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="text" id="no_pinjam" name="no_pinjam" value="{{$no_pinjam}}" hidden>
            <input type="date" id="from" name="from" value="{{$startDate}}" hidden>
            <input type="date" id="to" name="to" value="{{$endDate}}" hidden>
            <button type="submit" class="btn btn-success ml-2 btn-block">Export</button>
    </form>    
    </div>

<!-- DataTales Example -->
{{-- <a href="{{route('laporan.simpanan.export')}}" class="btn btn-info mx-1"><i class='bx bxs-printer'></i> Cetak Laporan</a> <br> <br> --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pinjaman Nasabah</h6>
    </div>
    <div class="card-body">
        @if (\Session::has('info'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! \Session::get('info') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="my-0 px-4">
                @foreach ($errors->all() as $error)
                <li class="my-0">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="table-responsive">
            Data pembayaran pinjaman <b>{{$nama}}</b> dari <b>{{date('d/m/Y', strtotime($startDate))}}</b> sampai <b>{{date('d/m/Y', strtotime($endDate))}}</b>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                @php
                    $jumlah_hutang = 0;
                    $hutang_sebelumnya = $pinjaman->pinjaman;
                @endphp
                @foreach($past as $key => $data)
                @php
                    $jumlah_hutang = $hutang_sebelumnya - $data->pokok;
                    $hutang_sebelumnya -= $data->pokok;
                @endphp
                @endforeach
                <thead>
                    <th colspan="6"></th>
                    <th align="right">Sisa hutang sebelumnya</th>
                    <th>@currency($hutang_sebelumnya)</th>
                </thead>
                <thead>
                    <tr>
                        <th>No Pinjam</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jumlah Bayar</th>
                        <th>Biaya Administrasi</th>
                        <th>Pokok</th>
                        <th>Bunga</th>
                        <th>Sisa Hutang</th>
                    </tr>
                </thead>
                <tbody>
                    @if($models->count() == 0)
                    <tr>
                        <td colspan="100%" align="center">
                            No data
                        </td>
                    </tr>
                    @endif
                        
                        
                        @php
                            $sisa=$hutang_sebelumnya;
                        @endphp
                    @foreach($models as $key => $item)
                    <tr>
                        <td>{{ $item->no_pinjam }}</td>
                        <td>{{ $item->nasabah->nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td>@currency($item->jumlah)</td>
                        <td>@currency($item->administrasi)</td>
                        <td>@currency($item->pokok)</td>
                        <td>@currency($item->bunga)</td>
                        
                        <td>@currency($jumlah = $sisa - $item->pokok)</td>
                        @php
                            $sisa -= $item->pokok;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="7" align="right"><b>Sisa Hutang</b> </td>
                        <td><b>@currency($sisa)</b> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.laporan.pinjaman.modalpinjam')
@endsection
@section('script')
<script></script>
@endsection