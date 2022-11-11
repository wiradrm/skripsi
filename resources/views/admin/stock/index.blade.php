@extends('layouts.admin')
@section('title')
Stock Telur
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-3 text-gray-800">Stock Telur</h1>
<form class="form-row mb-4" action="{{route('stock')}}" method="GET">
    <div class="form-group my-0 col-md">
        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
        <select class="form-control" name="jenis_telur" id="jenis_telur">
            @php($jenistelur = App\JenisTelur::all())
            @foreach($jenistelur as $key => $item)
            <option @if(request()->query("jenis_telur") == $item->id) selected @endif value="{{$item->id}}">{{$item->jenis_telur}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
        <a href="{{route('stock')}}" class="btn btn-warning btn-block ml-2">Reset Filter</a>
    </div>
</form>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Stock Telur</h6>
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
                            @include('admin.stock.detail')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script></script>
@endsection