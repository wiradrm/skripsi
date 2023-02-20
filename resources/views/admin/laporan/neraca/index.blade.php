@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laporan Neraca</h1>
<form class="form-row mb-4" action="{{route('laporan.neraca_past')}}" method="GET">
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
        <a href="{{route('laporan.neraca_past')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>

    </form>
        <form action="{{route('laporan.neraca.export')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
                <input type="date" id="from" name="from" value="{{$startDate}}" hidden>
                <input type="date" id="to" name="to" value="{{$endDate}}" hidden>
                <button type="submit" class="btn btn-success ml-2 btn-block">Export</button>
        </form>
    </div>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Neraca per-{{date('d M Y', strtotime($mytime))}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="3">Aktiva</th>
                        <th colspan="3">Passiva</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. Kas</td>
                        <td>100</td>
                        <td>@currency($labaBersih)</td>
                        <td>1. Tabungan</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>&nbsp;&nbsp;1.1 Tabungan Wajib</td>
                        <td>140</td>
                        <td>@currency($tabunganWajib)</td>
                    </tr>
                    <tr>
                        <td>2. Bank</td>
                        <td></td>
                        <td></td>
                        <td>&nbsp;&nbsp;1.2 Tabungan Sukarela</td>
                        <td>141</td>
                        <td>@currency($totalHutang)</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2.1 Tabungan</td>
                        <td>101</td>
                        <td>@currency($totalTabungan)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>R/L Tahun Berjalan</td>
                        <td>470</td>
                        <td>@currency($labaBersih)</td>
                    </tr>
                    <tr>
                        <td>Pinjaman diberikan</td>
                        <td>123</td>
                        <td>@currency($totalPinjaman)</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Jumlah</td>
                        <td></td>
                        <td style="font-weight: bold;">@currency($totalAktiva)</td>
                        <td style="font-weight: bold;">Jumlah</td>
                        <td></td>
                        <td style="font-weight: bold;">@currency($totalPassiva)</td>
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