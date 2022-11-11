@extends('layouts.admin')
@section('title')
    Laporan Telur Masuk
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Laporan Telur Masuk</h1>
    <form class="form-row mb-4" action="{{ route('laporan.stock_in') }}" method="GET">
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
            <a href="{{ route('laporan.stock_in') }}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
            <button type="button" class="btn btn-success ml-2 btn-block" data-toggle="modal"
                data-target="#exportModalStockIn">Export</button>
        </div>
    </form>
    <div class="mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Telur Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @php($checkbutir = $count % 30)
                            @php($checktray = ($count - $checkbutir) / 30)
                            @if ($checkbutir == 0 && $checktray == 0)
                                0
                            @elseif($checkbutir === 0)
                                {{ $checktray }} Tray
                            @elseif($count < 30)
                                {{ $count }} Butir
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Telur Masuk</h6>
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
                            <th>Tanggal Masuk</th>
                            <th>Jenis Telur</th>
                            <th>Jumlah</th>
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
                                <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }}</td>
                                <td>{{ $item->showJumlah() }}</td>
                                <td>
                                    @if($item->getKedaluwarsa() != 0)
                                    {{$item->getKedaluwarsa()}} Hari Lagi
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
    </div>
    @include('admin.laporan.modal.modalstockin')
@endsection
@section('script')
    <script>
    </script>
@endsection
