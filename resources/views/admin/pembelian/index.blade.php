@extends('layouts.admin')
@section('title')
Pembelian
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pembelian</h1>
<div class="row my-4">
    <div class="col-md-6">
        <div class="d-flex justify-content-start">
            <button type="submit" data-target="#createModal" data-toggle="modal" class="btn btn-primary">Tambah Data</button>
        </div>
    </div>
</div>
<form class="form-row mb-4" action="{{route('pembelian')}}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="from" class="col-form-label">Dari</label>
        <input type="date" class="form-control" id="from" name="from">
    </div>
    <div class="form-group my-0 col-md">
        <label for="to" class="col-form-label">Sampai</label>
        <input type="date" class="form-control" id="to" name="to">
    </div>
    <div class="form-group my-0 col-md">
        <label for="status_pembayaran" class="col-form-label">Status Pembayaran</label>
        <select class="form-control" name="status_pembayaran" id="status_pembayaran">
            <option @if(request()->query("status_pembayaran") == 1) selected @endif value="1">Lunas</option>
            <option @if(request()->query("status_pembayaran") == 2) selected @endif value="2">Hutang</option>
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{route('pembelian')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
    </div>
</form>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pembelian</h6>
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
        @if (\Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! \Session::get('error') !!}
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
                        @if(Auth::user()->level == 2)
                        <th>Toko</th>
                        @endif
                        <th>Supplier</th>
                        <th>Jenis Telur</th>
                        <th>Jumlah</th>
                        {{-- <th>Satuan</th> --}}
                        <th>Harga Beli</th>
                        <th>Sub Total</th>
                        <th>Pembayaran</th>
                        <th>Kedaluwarsa</th>
                        <th>Nota</th>
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
                        @if(Auth::user()->level == 2)
                        <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
                        @endif
                        <td>{{ $item->supplier }}</td>
                        <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->getJenisTelur->jenis_telur : '' }}</td>
                        <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->showJumlah() : '' }}</td>
                        {{-- <td>{{ $item->satuan }}</td> --}}
                        <td>@currency($item->harga_beli)</td>
                        <td>@currency($item->subtotal)</td>
                        <td>
                            @if($item->status_pembayaran === 1)
                            <span class="badge badge-success">Lunas</span>
                            @elseif($item->status_pembayaran === 2)
                            <span class="badge badge-danger">Hutang</span>
                            @endif
                        </td>
                        <td>
                            @if($item->getTelurMasuk)
                                @if($item->getTelurMasuk->getKedaluwarsa() > 0)
                                {{$item->getTelurMasuk->getKedaluwarsa()}} Hari Lagi
                                @else
                                <span class="text-danger">Kadaluwarsa</span>
                                @endif
                            @endif
                        </td>
                        <td>@if($item->image) <a href="{{ $item->getImage() }}" data-toggle="lightbox" data-gallery="nota">Lihat Nota</a> @else - @endif</td>
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
                                        <div class="modal-body">Apakah anda yakin menghapus data "{{$item->getTelurMasuk ? $item->getTelurMasuk->getJenisTelur->jenis_telur : ''}}"</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a href="{{route('pembelian.destroy',$item->id)}}" class="btn btn-primary">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('admin.pembelian.update')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.pembelian.create')
@endsection
@section('script')
<script>
$(function () {
    console.log($("#createStatusPembayaran"))
    $("#hutang").hide();
    $("#createStatusPembayaran").change(function() {
        console.log("cange")
        var val = $(this).val();
        if(val == 2) {
            $("#hutang").show();
        }
        else if(val == 1) {
            $("#hutang").hide();
        }
    });
});

$(function () {
    $(".updateHutang").hide();
    $(".updateStatusPembayaran").change(function() {
        var val = $(this).val();
        if(val == 2) {
            $(".updateHutang").show();
        }
        else if(val == 1) {
            $(".updateHutang").hide();
        }
    });
});

$( document ).ready(function() {
    $.each($(".checkStatusPembayaran"), function( index, value ) {
        var val = $(value).find(".updateStatusPembayaran").val();
        if(val == 2) {
            $(value).find(".updateHutang").show();
        }
        else if(val == 1) {
            $(value).find(".updateHutang").hide();
        }
    });
});
</script>
@endsection