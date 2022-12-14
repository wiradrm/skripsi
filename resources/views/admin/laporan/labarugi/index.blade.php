@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laba Rugi</h1>
<form class="form-row mb-4" action="{{route('laporan.labarugi')}}" method="GET">
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
        <a href="{{route('laporan.labarugi')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
    </div>
</form>
<div class="mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Laba/Rugi
                        </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($labaBersih)</div>
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
        <h6 class="m-0 font-weight-bold text-primary">Data Laba/Rugi per {{ $startDate ? date('d-m-Y', strtotime($startDate))  : $mytime }} {{ $startDate ? "sampai" : "" }} {{ $endDate ? date('d-m-Y', strtotime($endDate))  : "" }}</h6>
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
                        <th>Data</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pendapatan Bunga</td>
                        <td>@currency($pendapatanBunga)</td>
                    </tr>
                    <tr>
                        <td>Administrasi</td>
                        <td>@currency($pendapatanAdmin)</td>
                    </tr>
                    <tr>
                        <td>Biaya Operasional</td>
                        <td>@currency($labaOperasi)</td>
                    </tr>
                    <tr>
                        <th>Laba Bersih</th>
                        <th>@currency($labaBersih)</th>
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