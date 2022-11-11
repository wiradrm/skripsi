<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('harga.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="created_at" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control" id="created_at" name="created_at" value="{{date('Y-m-d', strtotime($item->created_at))}}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenistelur as $key => $data)
                            <option @if($item->id_jenis_telur == $data->id) selected @endif value="{{$data->id}}">{{$data->jenis_telur}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual_per_tray" class="col-form-label">Harga toko per tray</label>
                        <input type="text" class="form-control" id="harga_jual_per_tray" name="harga_jual_per_tray" value="{{ $item->harga_jual_per_tray }}">
                    </div>
                    @if(Auth::user()->level !== 0)
                    <div class="form-group">
                        <label for="harga_gudang_per_tray" class="col-form-label">Harga gudang per tray</label>
                        <input type="text" class="form-control" id="harga_gudang_per_tray" name="harga_gudang_per_tray" value="{{ $item->harga_gudang_per_tray }}">
                    </div>
                    @else
                    <input hidden type="text" class="form-control" id="harga_gudang_per_tray" name="harga_gudang_per_tray" value="0">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>