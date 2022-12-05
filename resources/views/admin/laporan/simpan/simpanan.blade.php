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
        <button type="button" class="btn btn-success ml-2 btn-block" data-toggle="modal" data-target="#exportModalHarga">Export</button>
    </div>
</form>
@include('admin.laporan.simpan.modalsimpan')
@endsection
@section('script')
<script></script>
@endsection