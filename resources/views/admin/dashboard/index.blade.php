@extends('layouts.admin')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <a style="text-decoration: none !important;" href="">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Nasabah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countNasabah }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <a style="text-decoration: none !important;" href="">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Saldo Tabungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($countTabungan)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <a style="text-decoration: none !important;" href="">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pinjaman Diberikan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($countPinjam)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md">
            <div class="card border shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <center><img src="{{asset('logo-lpd.png')}}" alt="" height="100px" width="150px"></center><br>
                        <center>
                            <b>
                                SISTEM INFORMASI PELAYANAN <br>
                                LEMBAGA PENGKREDITAN DESA <br>
                                PAKRAMAN BENANA
                            </b>
                        </center>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>

    <br>
    @if  (Auth::user()->level != 2)

    <div class="row">
        <div class="col-md">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-l font-weight-bold mb-1">
                                Informasi Penggunaan Sistem</div>
        
                            <div class="mb-0 text-gray-800">
                                <ul style="margin: 0; margin-block-start: 0;
                                margin-block-end: 0; padding-inline-start:20px;">
                                    <li><b>Menu Data:</b></li>
                                        <ul>
                                            <li><b>User,</b> berisi informasi mengenai data user untuk login sistem</li>
                                            <li><b>Nasabah,</b> berisi informasi mengenai data-data nasabah</li>
                                        </ul>
                                    <li><b>Menu Simpan:</b></li>
                                        <ul>
                                            <li><b>Data Simpanan,</b> berisi informasi mengenai data simpanan nasabah</li>
                                            <li><b>Penarikan Simpanan,</b> berisi informasi mengenai data penarikan simpanan</li>
                                        </ul>
                                    <li><b>Menu Pinjam:</b></li>
                                        <ul>
                                            <li><b>Pinjam,</b> berisi informasi mengenai data-data pinjaman nasabah</li>
                                            <li><b>Pembayaran,</b> berisi informasi mengenai pembayaran pinjaman</li>
                                        </ul>
                                    <li><b>Menu Laporan:</b></li>
                                        <ul>
                                            <li><b>Laporan Simpanan,</b> berisi informasi mengenai data-data simpanan nasabah</li>
                                            <li><b>Pinjaman,</b> berisi informasi mengenai pembayaran pinjaman</li>
                                            <li><b>Tunggakan,</b> berfungsi untuk mencetak surat tunggakan</li>
                                        </ul>        
                                </ul>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>

    @endif

    @if  (Auth::user()->level != 1)

    <div class="row">
        <div class="col-md">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-l font-weight-bold mb-1">
                                Informasi Penggunaan Sistem</div>
        
                            <div class="mb-0 text-gray-800">
                                <ul style="margin: 0; margin-block-start: 0;
                                margin-block-end: 0; padding-inline-start:20px;">
                                    <li><b>Menu Data:</b></li>
                                        <ul>
                                            <li><b>User,</b> berisi informasi mengenai data user untuk login sistem</li>
                                            <li><b>Nasabah,</b> berisi informasi mengenai data-data nasabah</li>
                                        </ul>
                                    <li><b>Menu Laporan:</b></li>
                                        <ul>
                                            <li><b>Laporan Simpanan,</b> berisi informasi mengenai data-data simpanan nasabah</li>
                                            <li><b>Pinjaman,</b> berisi informasi mengenai pembayaran pinjaman</li>
                                            <li><b>Tunggakan,</b> berfungsi untuk mencetak surat tunggakan</li>
                                        </ul>        
                                </ul>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>

    @endif
            
@endsection
