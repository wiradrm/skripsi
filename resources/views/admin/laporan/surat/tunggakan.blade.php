@extends('layouts.admin')
@section('title')
Surat
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Tunggakan</h1>
{{-- <div class="row my-4">
    <div class="col-md-6">
        <div class="d-flex justify-content-start">
            <button type="submit" data-target="#createModal" data-toggle="modal" class="btn btn-primary">Tambah Data</button>
        </div>
    </div>
</div> --}}
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Surat Tunggakan</h6>
    </div>
    <div class="card-body">

        <form id="myForm" target="__blank" action="{{route('laporan.cetak')}}" method="GET" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama" class="col-form-label">Nama Nasabah</label>
                    <select class="selectpicker form-control"  name="nama" id="id_nasabah" data-live-search="true">
                        <option hidden></option>
                        @foreach($nasabah as $key => $item)
                        <option value="{{$item->nama}}">{{$item->id}} | {{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="createDate" class="col-form-label">Tanggal</label>
                    <input type="date" class="form-control createDate" id="createDate" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label for="createDate" class="col-form-label">Periode</label>
                    <select class="form-control selectpicker"  name="periode" id="id_nasabah" data-live-search="true">
                        <option hidden></option>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
    
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah" class="col-form-label">Jumlah Tunggakan</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp.</div>
                        </div>
                        <input type="text" class="form-control uang" id="uang" name="jumlah">
                    </div> 
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Lama Penunggakan</label>
                    <input class="form-control" name="lama" id="alamat" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class='bx bx-printer'></i> Cetak</button>
            </div>
        </form>

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
            {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Lama Penunggakan</th>
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
                        <td>{{ $item->nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->tanggal_lahir)) }}</td>
                        <td>{{ $item->periode }}</td>
                        <td>@currency($item->jumlah)</td>
                        <td>{{ $item->lama }}</td>
                        <td>
                            <a class="btn btn-circle btn-danger" href="#" data-toggle="modal" data-target="#deactivateModal-{{$item->id}}"><i class='bx bx-trash' ></i></a>
                            <a class="btn btn-circle btn-info mx-1" target="_blank" href="{{route('laporan.cetak',$item->id)}}"><i class='bx bxs-printer'></i></a>
                            <div class="modal fade" id="deactivateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Yakin menghapus surat tunggakan?</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                            <a href="{{route('laporan.destroy',$item->id)}}" class="btn btn-primary">
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
            </table> --}}
        </div>
    </div>
</div>
@include('admin.laporan.surat.create')
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