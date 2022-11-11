<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('stock.update_stock_out', $item->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="created_at" class="col-form-label">Tanggal</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="date" class="form-control" id="created_at" name="created_at" value="{{date('Y-m-d', strtotime($item->created_at))}}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenistelur as $key => $data)
                            <option @if($item->id_jenis_telur == $data->id) selected @elseif($item->id != $item->checkLastRecord()) disabled @endif value="{{$data->id}}">{{$data->jenis_telur}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(Auth::user()->level == 2)
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko/Gudang</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_toko_gudang" id="toko">
                            @foreach($tokogudang as $key => $data)
                            <option @if($item->id_toko_gudang == $data->id) selected @elseif($item->id != $item->checkLastRecord()) disabled @endif value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="satuan" class="col-form-label">Satuan</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control satuan_update"  name="satuan" id="satuan">
                            <option @if($item->satuan == "Tray") selected @elseif($item->id != $item->checkLastRecord()) disabled @endif value="Tray">Tray</option>
                            <option @if($item->satuan == "Butir") selected @elseif($item->id != $item->checkLastRecord()) disabled @endif value="Butir">Butir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="number" class="form-control" id="jumlah" name="jumlah" value="{{$item->getJumlah()}}">
                    </div>
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko Tujaun</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_toko_tujuan" id="toko">
                            @foreach($tokogudang as $key => $data)
                            @if($data->type != 2)
                            <option @if($item->id_toko_gudang == $data->id) selected @elseif($item->id != $item->checkLastRecord()) disabled @endif value="{{$data->id}}">{{$data->nama}}</option>
                            @endif
                            @endforeach
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