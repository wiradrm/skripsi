@extends('layouts.admin')
@section('title')
Harga Telur
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laporan Harga Telur</h1>
<form class="form-row mb-4" action="{{route('laporan.harga')}}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="from" class="col-form-label">Dari</label>
        <input type="date" class="form-control" id="from" name="from">
    </div>
    <div class="form-group my-0 col-md">
        <label for="to" class="col-form-label">Sampai</label>
        <input type="date" class="form-control" id="to" name="to">
    </div>
    @if(Auth::user()->level !== 0)
    <div class="form-group my-0 col-md">
        <label for="id_toko_gudang" class="col-form-label">Toko Gudang</label>
        <select class="form-control" name="id_toko_gudang" id="id_toko_gudang">
            <option value="">Default</option>
            @foreach($tokogudang as $key => $item)
            <option @if(request()->query("id_toko_gudang") == $item->id) selected @endif value="{{$item->id}}">{{$item->nama}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{route('laporan.harga')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
        <button type="button" class="btn btn-success ml-2 btn-block" data-toggle="modal" data-target="#exportModalHarga">Export</button>
    </div>
</form>
@if(Auth::user()->level == 2)
<!-- Area Chart -->
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
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Harga Telur</h6>
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
                        @if(Auth::user()->level !== 0)
                        <th>Toko</th>
                        @endif
                        <th>Tanggal</th>
                        <th>Jenis Telur</th>
                        <th>Harga Toko per Tray</th>
                        <th>Harga Gudang per Tray</th>
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
                        @if(Auth::user()->level !== 0)
                        <td>{{$item->getTokoGudang ? $item->getTokoGudang->nama : ''}}</td>
                        @endif
                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                        <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }}</td>
                        <td>@currency($item->harga_jual_per_tray)</td>
                        <td>@currency($item->harga_gudang_per_tray)</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.laporan.modal.modalharga')
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = [<?php if($ChartItem != null) foreach($ChartItem[0]['data'] as $key => $item) echo "'".$key."',";?>];
const data = {
    labels: labels,
        datasets: [
        <?php if($ChartItem != null) { $data = count($ChartItem); for ($i = 0; $i < $data; $i++) {?>
        {
            label: <?php echo "'Harga ".$ChartItem[$i]['jenis']."'"; ?>,
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: <?php echo "'".$ChartItem[$i]['color']."'"; ?>,
            pointRadius: 3,
            pointBackgroundColor: <?php echo "'".$ChartItem[$i]['color']."'"; ?>,
            pointBorderColor: <?php echo "'".$ChartItem[$i]['color']."'"; ?>,
            pointHoverRadius: 3,
            pointHoverBackgroundColor: <?php echo "'".$ChartItem[$i]['color']."'"; ?>,
            pointHoverBorderColor: <?php echo "'".$ChartItem[$i]['color']."'"; ?>,
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [<?php foreach($ChartItem[$i]['data'] as $key => $item) echo $item.",";?>],
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
            beginAtZero:true,
        },
        x: {
            },
    },
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
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
@endsection