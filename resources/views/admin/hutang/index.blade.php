@extends('layouts.admin')
@section('title')
Hutang
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Hutang</h1>
<form class="form-row mb-4" action="{{route('hutang')}}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="type_transaction" class="col-form-label">Tipe Transaksi</label>
        <select class="form-control" name="type_transaction" id="type_transaction">
            <option @if(request()->query("type_transaction") == 1) selected @endif value="1">Pembelian</option>
            <option @if(request()->query("type_transaction") == 2) selected @endif value="2">Penjualan</option>
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{route('hutang')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
    </div>
</form>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Hutang</h6>
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
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Subtotal</th>
                        <th>Pembayaran Awal</th>
                        <th>Sisa</th>
                        <th>Jatuh Tempo</th>
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
                        <td>{{$item->getCustomer ? $item->getCustomer->name : '-'}}</td>
                        <td>
                            @if($item->type_transaction == 1)
                                Pembelian
                            @else
                                Penjualan
                            @endif
                        </td>
                        <td>@currency($item->getTransaction->subtotal)</td>
                        <td>@currency($item->pembayaran_awal)</td>
                        <td>@currency($item->sisa_pembayaran)</td>
                        <td>
                            @if($item->getJatuhTempo() > 0)
                            {{$item->getJatuhTempo()}} Hari Lagi
                            @else
                            <span class="text-danger">Jatuh Tempo</span>
                            @endif
                        </td>
                        <td>
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
                                        <div class="modal-body">Apakah anda yakin menghapus data hutang tanggal "{{date('d/m/Y', strtotime($item->created_at))}}"</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a href="{{route('pembelian.destroy',$item->id)}}" class="btn btn-primary">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('admin.hutang.update')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
</script>
@endsection