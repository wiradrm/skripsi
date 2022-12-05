@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Laporan Simpanan</h1>
<form class="form-row mb-4" action="{{ route('laporan.detail_simpanan') }}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="id_nasabah" class="col-form-label">Nama Nasabah</label>
            <select class="form-control selectpicker"  name="id_nasabah" id="id_nasabah" data-live-search="true">
                <option hidden></option>
                @foreach($nasabah as $key => $item)
                <option value="{{$item->id}}">{{$item->id}} | {{$item->nama}}</option>
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
    </div>
</form>

<!-- DataTales Example -->
{{-- <a href="{{route('laporan.simpanan.export')}}" class="btn btn-info mx-1"><i class='bx bxs-printer'></i> Cetak Laporan</a> <br> <br> --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Simpanan Nasabah</h6>
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

        @foreach($models as $key => $item)
        @php
        
        $nama = $item->nasabah->nama
    
        @endphp
        @endforeach

        <div class="table-responsive">
            Data simpanan nasabah <b>{{$nama}}</b> dari <b>{{$startDate}}</b> sampai <b>{{$endDate}}</b>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                @php
                    $jumlah_saldo = 0;
                    $saldo_awal = 0;
                @endphp
                @foreach($past as $key => $data)
                @php
                    $saldo_awal = $jumlah_saldo + $data->kredit - $data->debet;
                    $jumlah_saldo += $data->kredit - $data->debet;
                @endphp
                @endforeach
                <thead>
                    <th colspan="5"></th>
                    <th align="right">Saldo sebelumnya</th>
                    <th>@currency($saldo_awal)</th>
                </thead>
                <thead>
                    <tr>
                        <th>ID Nasabah</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
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
                            $jumlah=$saldo_awal;
                        @endphp
                    @foreach($models as $key => $item)
                    <tr>
                        <td>{{ $item->nasabah->id }}</td>
                        <td>{{ $item->nasabah->nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>@currency($item->debet)</td>
                        <td>@currency($item->kredit)</td>
                        
                        <td>@currency($saldo = $jumlah + $item->kredit - $item->debet)</td>
                        @php
                            $jumlah += $item->kredit - $item->debet;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" align="right"><b>Saldo akhir</b> </td>
                        <td><b>@currency($jumlah)</b> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script></script>
@endsection