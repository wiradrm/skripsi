@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Persetujuan Pinjaman</h1>
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
        <h6 class="m-0 font-weight-bold text-primary">Persetujuan Pinjaman</h6>
    </div>
    <div class="card-body">

        <form id="myForm" target="__blank" action="{{route('laporan.print')}}" method="GET" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama" class="col-form-label">Nasabah</label>
                    <select class="selectpicker form-control"  name="nama" id="id_nasabah" data-live-search="true">
                        <option hidden></option>
                        @foreach($nasabah as $key => $item)
                        <option value="{{$item->nama}}">{{$item->id}} | {{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-form-label">No Pinjam</label>
                    <input class="form-control" name="no"></textarea>
                </div>
                <div class="form-group">
                    <label for="jumlah" class="col-form-label">Jumlah Pinjaman</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp.</div>
                        </div>
                        <input type="text" class="form-control uang" id="uang" name="jumlah">
                    </div> 
                </div>
                <div class="form-group">
                    <label for="alamat" class="col-form-label">Bunga</label>
                    <input type="number" class="form-control" name="bunga"></textarea>
                </div>
                <div class="form-group">
                    <label for="createDate" class="col-form-label">Tanggal</label>
                    <input type="date" class="form-control createDate" id="createDate" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
                
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class='bx bx-printer'></i> Cetak</button>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>

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