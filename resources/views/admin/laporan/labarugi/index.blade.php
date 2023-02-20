@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laba Rugi</h1>
<form class="form-row mb-4" action="{{route('laporan.labarugi_past')}}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="from" class="col-form-label">Dari</label>
        <input type="date" class="form-control" id="from" name="from" required>
    </div>
    <div class="form-group my-0 col-md">
        <label for="to" class="col-form-label">Sampai</label>
        <input type="date" class="form-control" id="to" name="to" required>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{route('laporan.labarugi_past')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>

        
    </form>
        <form action="{{route('laporan.laba.export')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
                <input type="text" name="totalPemasukan" value="{{$totalPemasukan}}" hidden>
                <input type="text" name="totalPengeluaran" value="{{$totalPengeluaran}}" hidden>
                <input type="text" name="pendapatanBunga" value="{{$pendapatanBunga}}" hidden>
                <input type="text" name="pendapatanAdmin" value="{{$pendapatanAdmin}}" hidden>
                <input type="text" name="labaKotor" value="{{$labaKotor}}" hidden>
                <input type="text" name="labaOperasi" value="{{$labaOperasi}}" hidden>
                <input type="text" name="labaBersih" value="{{$labaBersih}}" hidden>
                
                <input type="date" id="from" name="from" value="{{$startDate}}" hidden>
                <input type="date" id="to" name="to" value="{{$endDate}}" hidden>
                <button type="submit" class="btn btn-success ml-2 btn-block">Export</button>
        </form>
    </div>
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
                        <th>Sandi</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">A. Pendapatan Operasional</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px">1. Hasil</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 40px">a. Dari Bank-Bank Lain</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">i. Giro</td>
                        <td>120</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">ii. Tabungan</td>
                        <td>121</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">iii. Simpanan Berjangka</td>
                        <td>122</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">iv. Pinjaman Yang Diberikan</td>
                        <td>123</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">v. Lainnya</td>
                        <td>124</td>
                        <td>@currency($pendapatanAdmin)</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 40px">b. Dari Pihak Ketiga Bukan Bank</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">i. Pinjaman Yang Diberikan</td>
                        <td>126</td>
                        <td>@currency($pendapatanBunga)</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">ii. Lainnya</td>
                        <td>126</td>
                        <td>@currency($totalPemasukan)</td>
                    </tr>
                    <tr>
                        <td><b>JUMLAH PENDAPATAN OPERASIONAL</b></td>
                        <td><b>100</b></td>
                        <td><b>@currency($labaKotor)</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td colspan="3">B. Biaya Operasional</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px">1. Biaya Bunga</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 40px">a. Kepada Bank-Bank Lain</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">i. Simpanan Berjangka</td>
                        <td>194</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">ii. Pinjaman Yang Diterima</td>
                        <td>195</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">iii. Lainnya</td>
                        <td>199</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 40px">b. Kepada Pihak Ketiga Bukan Bank</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">i. Simpanan Berjangka</td>
                        <td>203</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">ii. Tabungan</td>
                        <td>206</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 60px">iii. Lainnya</td>
                        <td>209</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px">2. Pemeliharaan dan Perbaikan</td>
                        <td>280</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px">3. Biaya Operasional Lainnya</td>
                        <td>301</td>
                        <td>@currency($labaOperasi)</td>
                    </tr>
                    <tr>
                        <td><b>JUMLAH BIAYA OPERASIONAL</b></td>
                        <td><b>100</b></td>
                        <td><b>@currency($labaOperasi)</b></td>
                    </tr>
                    <tr>
                        <td><b>JUMLAH LABA RUGI TAHUN BERJALAN</b></td>
                        <td><b>470</b></td>
                        <td><b>@currency($labaBersih)</b></td>
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