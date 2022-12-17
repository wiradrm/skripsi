<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="myForm" action="{{route('simpan.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_nasabah" class="col-form-label">Nama Nasabah</label> <br>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="selectpicker form-control"  name="id_nasabah" id="id_nasabah" data-live-search="true">
                            @foreach($nasabah as $key => $data)
                            <option @if($item->id_nasabah == $data->id) selected @endif value="{{$data->id}}">{{$data->id}} | {{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input @if($item->tanggal != $item->checkLastRecord()) @endif type="date" class="form-control" id="tanggal" name="tanggal" value="{{date('Y-m-d', strtotime($item->tanggal))}}">
                    </div> --}}
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" class="form-control uang" id="uang" name="jumlah" value="{{$item->jumlah}}">
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