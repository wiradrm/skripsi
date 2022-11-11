<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('stock_kandang.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" @if($item->checkStockTransfer() != null) readonly @endif class="form-control" id="created_at" name="created_at" value="{{date('Y-m-d', strtotime($item->created_at))}}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kandang" class="col-form-label">Jenis Kandang</label>
                        <select @if($item->checkStockTransfer() != null) readonly @endif class="form-control"  name="id_jenis_kandang" id="jenis_kandang">
                            @foreach($jenis_kandang as $key => $data)
                            <option @if($item->id_jenis_kandang == $data->id) selected @elseif($item->checkStockTransfer() != null) disabled @endif value="{{$data->id}}">{{$data->jenis_kandang}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select @if($item->checkStockTransfer() != null) readonly @endif class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenis_telur as $key => $data)
                            <option @if($item->id_jenis_telur == $data->id) selected @elseif($item->checkStockTransfer() != null) disabled @endif value="{{$data->id}}">{{$data->jenis_telur}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="satuan" class="col-form-label">Satuan</label>
                        <select @if($item->checkStockTransfer() != null) readonly @endif class="form-control satuan_update"  name="satuan" id="satuan">
                            <option @if($item->satuan == "Tray") selected @elseif($item->checkStockTransfer() != null) disabled @endif value="Tray">Tray</option>
                            <option @if($item->satuan == "Butir") selected @elseif($item->checkStockTransfer() != null) disabled @endif value="Butir">Butir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input @if($item->checkStockTransfer() != null) readonly @endif type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $item->getJumlah() }}">
                    </div>
                    <div class="form-group input_kadaluwarsa">
                        <label for="kadaluwarsa" class="col-form-label">Kadaluwarsa</label>
                        <input @if($item->checkStockTransfer() != null) readonly @endif type="date" class="form-control" id="kadaluwarsa" name="kedaluwarsa" value="{{date('Y-m-d', strtotime($item->kedaluwarsa))}}" required>
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