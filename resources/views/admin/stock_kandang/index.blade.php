@extends('layouts.admin')
@section('title')
Telur Kandang
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Telur Kandang</h1>
<div class="row my-4">
    <div class="col-md-6">
        <div class="d-flex justify-content-start">
            <button type="submit" data-target="#createModal" data-toggle="modal" class="btn btn-primary">Tambah Data</button>
        </div>
    </div>
</div>
<form class="form-row mb-4" action="{{ route('stock_kandang') }}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="from" class="col-form-label">Dari</label>
        <input type="date" class="form-control" id="from" name="from">
    </div>
    <div class="form-group my-0 col-md">
        <label for="to" class="col-form-label">Sampai</label>
        <input type="date" class="form-control" id="to" name="to">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{ route('stock_kandang') }}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
    </div>
</form>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Telur Kandang</h6>
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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Kandang</th>
                        <th>Jenis Telur</th>
                        <th>Jumlah</th>
                        <th>Kedaluwarsa</th>
                        <th width="12%">Action</th>
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
                    @foreach($models as $key => $item)
                    <tr>
                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                        <td>{{ $item->getJenisKandang ? $item->getJenisKandang->jenis_kandang : '' }}</td>
                        <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : ''}}</td>
                        <td>{{ $item->showJumlahDetails() }}</td>
                        <td>
                            @if($item->getKedaluwarsa() > 0)
                            {{$item->getKedaluwarsa()}} Hari Lagi
                            @else
                            <span class="text-danger">Kadaluwarsa</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-circle btn-danger" href="#" data-toggle="modal" data-target="#deleteModal-{{$item->id}}"><i class='bx bxs-trash-alt'></i></a>
                            <a class="btn btn-circle btn-info mx-1" href="#" data-toggle="modal" data-target="#updateModal-{{$item->id}}"><i class='bx bxs-edit'></i></a>
                            <div class="modal fade" id="deleteModal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Apakah anda yakin menghapus data {{ $item->getJenisKandang ? $item->getJenisKandang->jenis_kandang : '' }}</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a href="{{route('stock_kandang.destroy',$item->id)}}" class="btn btn-primary">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('admin.stock_kandang.update')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.stock_kandang.create')
@endsection
@section('script')
<script></script>
@endsection