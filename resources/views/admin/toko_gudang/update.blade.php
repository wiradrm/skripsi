<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('toko_gudang.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{$item->nama}}">
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{$item->alamat}}">
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-form-label">Type</label>
                        <select name="type" class="form-control" id="type">
                            <option @if($item->type == 1) selected @endif value="1">Toko</option>
                            <option @if($item->type == 2) selected @endif value="2">Gudang</option>
                        </select>
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