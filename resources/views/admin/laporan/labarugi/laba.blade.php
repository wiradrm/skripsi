@extends('layouts.admin')
@section('title')
User
@endsection
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Laba Rugi</h1>
<button type="submit" data-target="#importModal" data-toggle="modal" class="btn btn-success"><i class='bx bxs-file-import'></i> Import Excel</button> <br><br>
         <div class="modal fade bd-example-modal-lg text-left" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="createModalLabel">Import Data</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <form action="{{route('laporan.laba_import')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="modal-body">
                        <div class="input-group mb-3">
                           <div class="custom-file">
                              <input type="file" name="file" class="custom-file-input" id="inputGroupFile02" required>
                              <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Laba/Rugi per </h6>
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
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Perkiraan</th>
                        <th>Sandi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script></script>
@endsection