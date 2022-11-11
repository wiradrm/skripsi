@extends('layouts.admin')
@section('title')
Laporan Stock Telur
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-3 text-gray-800">Laporan Stock Telur</h1>
<form class="form-row mb-4" action="{{route('laporan.stock')}}" method="GET">
    @if(Auth::user()->level != 0)
    <div class="form-group my-0 col-md">
        <label for="id_toko_gudang" class="col-form-label">Toko Gudang</label>
        <select class="form-control" name="id_toko_gudang" id="id_toko_gudang">
            <option value="">Default</option>
            @php($toko = App\TokoGudang::get())
            @foreach($toko as $key => $item)
            <option @if(request()->query("id_toko_gudang") == $item->id) selected @endif value="{{$item->id}}">{{$item->nama}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="form-group my-0 col-md">
        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
        <select class="form-control" name="id_jenis_telur" id="jenis_telur">
            <option value="">Default</option>
            @php($telur = App\JenisTelur::get())
            @foreach($telur as $key => $item)
            <option @if(request()->query("id_jenis_telur") == $item->id) selected @endif value="{{$item->id}}">{{$item->jenis_telur}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{route('laporan.stock')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
        <button type="button" class="btn btn-success ml-2 btn-block" data-toggle="modal" data-target="#exportModalStock">Export</button>
    </div>
</form>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Stock Telur</h6>
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
            <table class="table table-bordered rowspan-table" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>Jenis Telur</th>
                        <th>Stock</th>
                        <th>Action</th>
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
                        <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }}</td>
                        <td>{{ $item->getStock() }}</td>
                        <td>
                            <a class="text-primary" href="#" data-toggle="modal" data-target="#detail-{{$item->id}}">View Detail</a>
                            <div class="modal fade bd-example-modal-lg text-left" id="detail-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailLabel">Detail Stock</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @php($details = App\TelurMasuk::where('id_toko_gudang', $item->id_toko_gudang)->where('id_jenis_telur', $item->id_jenis_telur)->get())
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal Masuk</th>
                                                            @if(Auth::user()->level == 2)
                                                            <th>Toko</th>
                                                            @endif
                                                            <th>Jenis Telur</th>
                                                            <th>Stock</th>
                                                            <th>Kedaluwarsa</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($item->showDetails()->count() == 0)
                                                        <tr>
                                                            <td colspan="100%" align="center">
                                                                No data
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @foreach($item->showDetails() as $key => $data)
                                                        <tr>
                                                            <td>{{date('d/m/Y', strtotime($data->created_at))}}</td>
                                                            @if(Auth::user()->level == 2)
                                                            <td>{{ $data->getTokoGudang ? $data->getTokoGudang->nama : ''}}</td>
                                                            @endif
                                                            <td>{{ $data->getJenisTelur->jenis_telur }}</td>
                                                            <td>
                                                                {{$data->showJumlahDetails()}}
                                                            </td>
                                                            <td>
                                                                @if($data->getKedaluwarsa() != 0)
                                                                {{$data->getKedaluwarsa()}} Hari Lagi
                                                                @else
                                                                <span class="text-danger">Kadaluwarsa</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.laporan.modal.modalstock')
@endsection
@section('script')
<script></script>
@endsection