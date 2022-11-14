<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('nasabah.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nik" class="col-form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{$item->nik}}">
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{$item->nama}}">
                    </div>
                    <div class="form-group">
                        <label for="created_at" class="col-form-label">Tanggal</label>
                        <input @if($item->tanggal_lahir != $item->checkLastRecord()) @endif type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{date('Y-m-d', strtotime($item->tanggal_lahir))}}">
                    </div>
                    <div class="form-group">
                        <label for="telp" class="col-form-label">No Telpon</label>
                        <input type="number" class="form-control" id="telp" name="telp" value="{{$item->telp}}">
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10">{{$item->alamat}}</textarea>
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