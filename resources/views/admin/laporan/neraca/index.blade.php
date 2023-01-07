@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laporan Neraca</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Neraca per {{$mytime}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="2">Aktiva</th>
                        <th colspan="2">Passiva</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. Kas</td>
                        <td>@currency($labaBersih)</td>
                        <td>1. Tabungan</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>&nbsp;&nbsp;1.1 Tabungan Wajib</td>
                        <td>@currency($tabunganWajib)</td>
                    </tr>
                    <tr>
                        <td>2. Bank</td>
                        <td></td>
                        <td>&nbsp;&nbsp;1.2 Tabungan Sukarela</td>
                        <td>@currency($totalHutang)</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;2.1 Tabungan</td>
                        <td>@currency($totalTabungan)</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>R/L Tahun Berjalan</td>
                        <td>@currency($labaBersih)</td>
                    </tr>
                    <tr>
                        <td>Pinjaman diberikan</td>
                        <td>@currency($totalPinjaman)</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <b><td>Jumlah</td>
                        <td>@currency($totalAktiva)</td>
                        <td>Jumlah</td>
                        <td>@currency($totalPassiva)</td></b>
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