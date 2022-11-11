@extends('layouts.admin')
@section('title')
    Dashboard
@endsection
@section('content')
    @if (Auth::user()->level == 2)
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Filter Toko/Gudang</h6>
            </div>
            <form class="card-body form-row" action="{{ route('dashboard') }}" method="GET">
                <div class="form-group my-0 col-md">
                    <label for="month" class="col-form-label">Bulan</label>
                    <select class="form-control" name="month" id="month">
                        <option value="">Default</option>
                        <option value='1'>Janaury</option>
                        <option value='2'>February</option>
                        <option value='3'>March</option>
                        <option value='4'>April</option>
                        <option value='5'>May</option>
                        <option value='6'>June</option>
                        <option value='7'>July</option>
                        <option value='8'>August</option>
                        <option value='9'>September</option>
                        <option value='10'>October</option>
                        <option value='11'>November</option>
                        <option value='12'>December</option>
                    </select>
                </div>
                <div class="form-group my-0 col-md">
                    <label for="id_toko_gudang" class="col-form-label">Toko Gudang</label>
                    <select class="form-control" name="id_toko_gudang" id="id_toko_gudang">
                        <option value="">Default</option>
                        @foreach($tokogudang as $key => $item)
                        <option @if(request()->query("id_toko_gudang") == $item->id) selected @endif value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
                </div>
            </form>
        </div>
    @endif
    @if (Auth::user()->level !== 2)
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
        </div>
        <form class="card-body form-row mb-4" action="{{ route('dashboard') }}" method="GET">
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
                <a href="{{ route('dashboard') }}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
            </div>
        </form>
    </div>

    @endif
    <div class="row">
        @if (Auth::user()->level == 1)
        <div class="col-xl-4 col-md-4 mb-4">
            @if (Auth::user()->level != 2)
                <a style="text-decoration: none !important;" href="{{ route('stock_in') }}">
            @endif
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Telur Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countStockIn }}</div>
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
                @if (Auth::user()->level != 2)
                    <a style="text-decoration: none !important;" href="{{ route('stock_kandang') }}">
                @endif
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Telur Kandang</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countStockKandang }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        @endif

        <div class="col-xl-4 col-md-4 mb-4">
            @if (Auth::user()->level != 2)
                <a style="text-decoration: none !important;" href="{{ route('penjualan') }}">
            @endif
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Penjualan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($countPenjualan)</div>
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
            @if (Auth::user()->level != 2)
                <a style="text-decoration: none !important;" href="{{ route('pembelian') }}">
            @endif
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pembelian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($countPembelian)</div>
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
            @if (Auth::user()->level != 2)
                <a style="text-decoration: none !important;" href="{{ route('pengeluaran') }}">
            @endif
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($countPengeluaran)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        @if (Auth::user()->level != 2)
            <div class="col-xl-4 col-md-4 mb-4">
                <a style="text-decoration: none !important;" href="#">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Saldo</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">@if($countSaldo <= 0) Saldo Tidak Mencukupi @else @currency($countSaldo) @endif</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Stock Telur</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered rowspan-table" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Jenis Telur</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($stock->count() == 0)
                                    <tr>
                                        <td colspan="100%" align="center">
                                            No data
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($stock as $key => $item)
                                    <tr>
                                        <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }}</td>
                                        <td>{{ $item->getStock() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Fluktuasi Harga</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = [<?php if ($ChartItem != null) {
    foreach ($ChartItem[0]['data'] as $key => $item) {
        echo "'" . $key . "',";
    };
} ?>];
        const data = {
            labels: labels,
            datasets: [
                <?php if($ChartItem != null) { $data = count($ChartItem); for ($i = 0; $i < $data; $i++) {?> {
                    label: <?php echo "'Harga " . $ChartItem[$i]['jenis'] . "'"; ?>,
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: <?php echo "'" . $ChartItem[$i]['color'] . "'"; ?>,
                    pointRadius: 3,
                    pointBackgroundColor: <?php echo "'" . $ChartItem[$i]['color'] . "'"; ?>,
                    pointBorderColor: <?php echo "'" . $ChartItem[$i]['color'] . "'"; ?>,
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: <?php echo "'" . $ChartItem[$i]['color'] . "'"; ?>,
                    pointHoverBorderColor: <?php echo "'" . $ChartItem[$i]['color'] . "'"; ?>,
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [<?php foreach ($ChartItem[$i]['data'] as $key => $item) {
    echo $item . ',';
} ?>],
                },
                <?php }}?>
            ],
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                    x: {},
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    }
                },
            },
        };

        var myLineChart = new Chart(
            document.getElementById("myAreaChart"),
            config
        );
    </script>
    <script>
        const labelsPenjualan = [<?php if ($ChartPenjualan != null) {
    foreach ($ChartPenjualan[0]['data'] as $key => $item) {
        echo "'" . $key . "',";
    };
} ?>];
        const dataPenjualan = {
            labels: labelsPenjualan,
            datasets: [
                <?php if($ChartPenjualan != null) { $data = count($ChartPenjualan); for ($i = 0; $i < $data; $i++) {?> {
                    label: <?php echo "'" . $ChartPenjualan[$i]['nama'] . "'"; ?>,
                    backgroundColor: <?php echo "'" . $ChartPenjualan[$i]['color'] . "'"; ?>,
                    data: [<?php foreach ($ChartPenjualan[$i]['data'] as $key => $item) {
    echo $item . ',';
} ?>],
                },
                <?php }}?>
            ],
        };

        const configPenjualan = {
            type: 'bar',
            data: dataPenjualan,
            options: {
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                    x: {},
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Data Penjualan'
                    }
                },
            },
        };

        var myLineChart = new Chart(
            document.getElementById("myBarChart"),
            configPenjualan
        );
    </script>
@endsection
