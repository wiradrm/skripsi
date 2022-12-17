@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Pinjaman</h1>
<div class="row my-4">
    <div class="col-md-6">
        <div class="d-flex justify-content-start">
            <button type="submit" data-target="#createModal" data-toggle="modal" class="btn btn-primary">Tambah Data</button>
        </div>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pinjaman</h6>
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
                        <th>No Pinjam</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                        <th>Besar Pinjaman</th>
                        <th>Bunga Menurun</th>
                        <th width="12%">Action</th>
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
                        <td>{{ $item->no_pinjam }}</td>
                        <td>{{ $item->nasabah->nama }}</td>
                        <td>{{ $item->nasabah->alamat }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>@currency($item->pinjaman)</td>
                        <td>{{ $item->bunga }}%</td>
                        <td>
                            <a class="btn btn-circle btn-danger" href="#" data-toggle="modal" data-target="#deactivateModal-{{$item->id}}"><i class='bx bx-trash' ></i></a>
                            <div class="modal fade" id="deactivateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Hapus Data pinjaman dengan no pinjam: <b>{{$item->no_pinjam}}</b> <br>
                                                                oleh <b>{{$item->nasabah->nama}}</b> sebesar <b>@currency($item->pinjaman)</b> <br>
                                                                <b>Semua data terkait pinjaman akan terhapus <br> termasuk history pembayaran!</b>                        
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a href="{{route('pinjam.destroy',$item->id)}}" class="btn btn-primary">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.pinjam.create')
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
<script type="text/javascript">
	$("#myForm").ready(function(){
	    // Format mata uang.
	    $( "#uang" ).mask('0.000.000.000', {reverse: true, autoUnmask: true});

        
	})

    $("#myForm").submit(function() {
            $("#uang").unmask();
        });
</script>
<script></script>
@endsection