@extends('layouts.admin')
@section('title')
    Laporan Pembelian
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Laporan Pembelian</h1>
    <form class="form-row mb-4" action="{{ route('laporan.pembelian') }}" method="GET">
        <div class="form-group my-0 col-md">
            <label for="from" class="col-form-label">Dari</label>
            <input type="date" class="form-control" id="from" name="from">
        </div>
        <div class="form-group my-0 col-md">
            <label for="to" class="col-form-label">Sampai</label>
            <input type="date" class="form-control" id="to" name="to">
        </div>
        @if (Auth::user()->level == 2)
            <div class="form-group my-0 col-md">
                <label for="id_toko_gudang" class="col-form-label">Toko Gudang</label>
                <select class="form-control" name="id_toko_gudang" id="id_toko_gudang">
                    <option value="">Default</option>
                    @foreach ($tokogudang as $key => $item)
                        <option @if (request()->query('id_toko_gudang') == $item->id) selected @endif value="{{ $item->id }}">
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
            <a href="{{ route('laporan.pembelian') }}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
            <button type="button" class="btn btn-success ml-2 btn-block" data-toggle="modal"
                data-target="#exportModalPembelian">Export</button>
        </div>
    </form>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Telur Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php($checkbutir = $countStockIn % 30)
                                @php($checktray = ($countStockIn - $checkbutir) / 30)
                                @if ($checkbutir == 0 && $checktray == 0)
                                    0
                                @elseif($checkbutir === 0)
                                    {{ $checktray }} Tray
                                @elseif($countStockIn < 30)
                                    {{ $countStockIn }} Butir
                                @else
                                    {{ $checktray }} Tray {{ $checkbutir }} Butir
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pembelian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($countPembelian)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            @if (Auth::user()->level == 2)
                                <th>Toko</th>
                            @endif
                            <th>Supplier</th>
                            <th>Jenis Telur</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Sub Total</th>
                            <th>Pembayaran</th>
                            <th>Kedaluwarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($models->count() == 0)
                            <tr>
                                <td colspan="100%" align="center">
                                    No data
                                </td>
                            </tr>
                        @endif
                        @foreach ($models as $key => $item)
                            <tr>
                                <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                @if (Auth::user()->level == 2)
                                    <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
                                @endif
                                <td>{{ $item->supplier }}</td>
                                <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->getJenisTelur->jenis_telur : ''}}</td>
                                <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->showJumlah() : ''}}</td>
                                {{-- <td>{{ $item->satuan }}</td> --}}
                                <td>@currency($item->harga_beli)</td>
                                <td>@currency($item->subtotal)</td>
                                <td>
                                    @if ($item->status_pembayaran === 1)
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($item->status_pembayaran === 2)
                                        <span class="badge badge-danger">Hutang</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->getTelurMasuk)
                                        @if($item->getTelurMasuk->getKedaluwarsa() != 0)
                                        {{$item->getTelurMasuk ? $item->getTelurMasuk->getKedaluwarsa() : ''}} Hari Lagi
                                        @else
                                        <span class="text-danger">Kadaluwarsa</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.laporan.modal.modalpembelian')
@endsection
@section('script')
@endsection
