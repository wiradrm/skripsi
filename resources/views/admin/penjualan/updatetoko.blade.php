<div class="modal fade bd-example-modal-lg text-left" id="updateModalToko-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('penjualan.update', $item->id)}}" method="POST">
                @csrf
                @method('PUT')
                <input hidden type="number" value="1" name="type">
                <input hidden type="text" value="customer" name="customer">
                <div class="modal-body">
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Harga Telur</h4>
                        <hr>
                        @if(!Auth::user()->getGudang())
                        @foreach($harga as $key => $data)
                        <p class="mb-0">Harga Toko {{$data->getJenisTelur->jenis_telur}} : @currency($data->harga_jual_per_tray) / Tray</p>
                        @endforeach
                        @endif
                        @if(Auth::user()->getGudang())
                        @foreach($harga as $key => $data)
                        <p class="mb-0">Harga Gudang {{$data->getJenisTelur->jenis_telur}} : @currency($data->harga_gudang_per_tray) / Tray</p>
                        @endforeach
                        @endif
                      </div>
                    <div>
                    <div class="form-group">
                        <label for="created_at" class="col-form-label">Tanggal</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="date" class="form-control" id="created_at" name="created_at" value="{{date('Y-m-d', strtotime($item->created_at))}}">
                    </div>
                    <div class="form-group">
                        <label for="id_toko_tujuan" class="col-form-label">Toko Tujuan</label>
                        <select class="form-control" name="id_toko_tujuan" id="id_toko_tujuan">
                            @foreach ($tokogudang as $key => $data)
                                @if ($item->type !== 2)
                                    <option @if($item->getTelurKeluar ? $item->getTelurKeluar->id_toko_tujuan : '' == $data->id) selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenistelur as $key => $data)
                            <option @if($item->getTelurKeluar->id_jenis_telur == $data->id) selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="{{$data->id}}">{{$data->jenis_telur}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(Auth::user()->level == 2)
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko/Gudang</label>
                        <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control"  name="id_toko_gudang" id="toko">
                            @foreach($tokogudang as $key => $data)
                            <option @if($item->id_toko_gudang == $data->id) selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="check_satuan">
                        <div class="form-group">
                            <label for="satuan" class="col-form-label">Satuan</label>
                            <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control satuan_update"  name="satuan" id="satuan">
                                <option @if($item->getTelurKeluar->satuan == "Tray") selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="Tray">Tray</option>
                                <option @if($item->getTelurKeluar->satuan == "Butir") selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="Butir">Butir</option>
                            </select>
                        </div>
                        <div class="form-group update_harga">
                            <label for="harga" class="col-form-label">Harga</label>
                            <input @if($item->id != $item->checkLastRecord()) readonly @endif type="number" class="form-control" id="harga" name="harga" value="{{ $item->harga }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input @if($item->id != $item->checkLastRecord()) readonly @endif type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $item->getTelurKeluar ? $item->getTelurKeluar->getJumlah() : '' }}">
                    </div>
                    <div class="checkStatusPembayaran">
                        <div class="form-group">
                            <label for="status_pembayaran" class="col-form-label">Pembayaran</label>
                            <select @if($item->id != $item->checkLastRecord()) readonly @endif class="form-control updateStatusPembayaran"  name="status_pembayaran" id="status_pembayaran">
                                <option @if($item->status_pembayaran == 1) selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="1">Lunas</option>
                                <option @if($item->status_pembayaran == 2) selected @elseif($item->checkLastRecord() != $item->id) disabled @endif value="2">Hutang</option>
                            </select>
                        </div>
                        @php($hutang = App\Hutang::where('type_transaction', 2)->where('id_transaction', $item->id)->first())
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
                        <div class="form-group paid">
                            <label for="inputpaid" class="col-form-label">Dibayar</label>
                            <input @if($item->id != $item->checkLastRecord()) readonly @endif type="number" class="form-control" id="inputpaid" name="paid" required value="{{$item->paid}}">
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