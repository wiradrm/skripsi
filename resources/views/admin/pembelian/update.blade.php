<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pembelian.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="created_at" class="col-form-label">Tanggal</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="date" class="form-control" id="created_at" name="created_at" value="{{date('Y-m-d', strtotime($item->created_at))}}">
                    </div>
                    <div class="form-group">
                        <label for="supplier" class="col-form-label">Supplier</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="text" class="form-control" id="supplier" name="supplier" value="{{$item->supplier}}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenistelur as $key => $data)
                            <option @if($item->getTelurMasuk->id_jenis_telur == $data->id) selected @elseif($item->checkLastRecord() !== $item->id) disabled @endif value="{{$data->id}}">{{$data->jenis_telur}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(Auth::user()->level == 2)
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko/Gudang</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_toko_gudang" id="toko">
                            @foreach($tokogudang as $key => $data)
                            <option @if($item->id_toko_gudang == $data->id) selected @elseif($item->checkLastRecord() !== $item->id) disabled @endif value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="satuan" class="col-form-label">Satuan</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control satuan_update"  name="satuan" id="satuan">
                            <option @if($item->getTelurMasuk->satuan == "Tray") selected @elseif($item->checkLastRecord() !== $item->id) disabled @endif value="Tray">Tray</option>
                            <option @if($item->getTelurMasuk->satuan == "Butir") selected @elseif($item->checkLastRecord() !== $item->id) disabled @endif value="Butir">Butir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $item->getTelurMasuk->getJumlah() }}">
                    </div>
                    <div class="form-group">
                        <label for="harga_beli" class="col-form-label">Harga Beli</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ $item->harga_beli }}">
                    </div>
                    <div class="checkStatusPembayaran">
                        <div class="form-group">
                            <label for="status_pembayaran" class="col-form-label">Pembayaran</label>
                            <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control updateStatusPembayaran" name="status_pembayaran" id="status_pembayaran">
                                <option @if($item->status_pembayaran === 1) selected @elseif($item->checkLastRecord() !== $item->id) disabled @endif value="1">Lunas</option>
                                <option @if($item->status_pembayaran === 2) selected @elseif($item->checkLastRecord() !== $item->id) disabled @endif value="2">Hutang</option>
                            </select>
                        </div>
                        @php($hutang = App\Hutang::where('type_transaction', 1)->where('id_transaction', $item->id)->first())
                        <div class="hutang-wrapper p-4 border mb-3 updateHutang">
                            <div class="form-group">
                                <label for="pembayaran_awal" class="col-form-label">Pembayaran Awal</label>
                                <input type="number" class="form-control" id="pembayaran_awal" name="pembayaran_awal" value="{{$hutang->pembayaran_awal ?? ''}}">
                            </div>
                            <div class="form-group input_kadaluwarsa">
                                <label for="tgl_pelunasan" class="col-form-label">Tanggal Pelunasan</label>
                                <input type="date" class="form-control" id="tgl_pelunasan" name="tgl_pelunasan" value="{{date('Y-m-d', strtotime($hutang->tgl_pelunasan ?? ''))}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kadaluwarsa" class="col-form-label">Kadaluwarsa</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="date" class="form-control" id="kedaluwarsa" name="kedaluwarsa" value="{{date('Y-m-d', strtotime($item->getTelurMasuk->kedaluwarsa))}}">
                    </div>
                    <div class="form-group">
                        <label for="upload_image" class="col-form-label">Upload Nota</label>
                        <div class="form-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" accept="image/*" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                          </div>
                        </div>
                        @if($item->image)
                        <div class="form-group">
                            <img src="{{$item->getImage()}}" width="500" alt="{{$item->supplier}}">
                         </Div>
                        @endif
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