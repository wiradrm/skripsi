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
                        <label for="nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{$item->nama}}">
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{$item->username}}">
                    </div>
                    <div class="form-group">
                        <label for="telp" class="col-form-label">No Telpon</label>
                        <input type="text" class="form-control" id="telp" name="telp" value="{{$item->telp}}">
                    </div>
                    <div class="form-group">
                        <label for="level" class="col-form-label">Level</label>
                        <select name="level" class="form-control" id="level">
                            <option @if($item->level == 1) selected @endif value="1">Bendahara</option>
                            <option @if($item->level == 2) selected @endif value="2">Ketua LPD</option>
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