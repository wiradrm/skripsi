<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$item->name}}">
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{$item->username}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telpon" class="col-form-label">No Telpon</label>
                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="{{$item->no_telpon}}">
                    </div>
                    <div class="form-group">
                        <label for="level" class="col-form-label">Level</label>
                        <select name="level" class="form-control" id="level">
                            <option @if($item->level == 0) selected @endif value="0">Penjaga Toko</option>
                            <option @if($item->level == 1) selected @endif value="1">Admin Gudang</option>
                            <option @if($item->level == 2) selected @endif value="2">Pemilik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko/Gudang</label>
                        <select class="form-control"  name="id_toko_gudang" id="toko">
                            <option @if($item->id_toko_gudang == null) selected @endif value="null">Bukan Penjaga Toko</option>
                            @foreach($tokogudang as $key => $data)
                            <option @if($data->id == $item->id_toko_gudang) selected @endif value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="false">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-form-label">Password Confirmation</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="false">
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