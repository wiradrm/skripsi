<div class="modal fade bd-example-modal-lg text-left" id="createModalToko" tabindex="-1" role="dialog"
    aria-labelledby="createModalToko" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalTokoLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <input hidden type="number" value="1" name="type">
                <input hidden type="text" value="customer" name="customer">
                <div class="modal-body">
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Harga Telur</h4>
                        <hr>
                        @foreach ($harga as $key => $item)
                        <p class="mb-0" id="#{{ $item->getJenisTelur->id }}_harga">Harga {{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }} :
                            @currency($item->harga_gudang_per_tray) / Tray</p>
                    @endforeach
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="createDate" class="col-form-label">Tanggal</label>
                            <input type="date" class="form-control createDate" id="createDate" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="id_toko_tujuan" class="col-form-label">Toko Tujuan</label>
                            <select class="form-control" name="id_toko_tujuan" id="id_toko_tujuan" required>
                                @foreach ($tokogudang as $key => $item)
                                    @if ($item->type !== 2)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenisTelurToko" class="col-form-label">Jenis Telur</label>
                            <select id="jenisTelurToko" class="form-control"  name="id_jenis_telur" required>
                                @foreach($jenistelur as $key => $item)
                                <option value="{{$item->id}}">{{$item->jenis_telur}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::user()->level == 2)
                            <div class="form-group">
                                <label for="toko" class="col-form-label">Toko/Gudang</label>
                                <select class="form-control" name="id_toko_gudang" id="toko" required>
                                    @foreach ($tokogudang as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="satuan_create_toko" class="col-form-label">Satuan</label>
                            <select class="form-control" name="satuan" id="satuan_create_toko" required>
                                <option value="Tray">Tray</option>
                                <option value="Butir">Butir</option>
                            </select>
                        </div>
                        <div class="form-group harga_telur">
                            <label for="setHargaToko" class="col-form-label">Harga</label>
                            <input type="number" class="form-control" id="setHargaToko" name="harga">
                        </div>
                        <div class="form-group">
                            <label for="createJumlahToko" class="col-form-label">Jumlah</label>
                            <input type="number" class="form-control" id="createJumlahToko" name="jumlah">
                        </div>
                        <div class="form-group">
                            <label for="createStatusPembayaranToko" class="col-form-label">Pembayaran</label>
                            <select class="form-control" name="status_pembayaran" id="createStatusPembayaranToko">
                                <option value="1">Lunas</option>
                                <option value="2">Hutang</option>
                            </select>
                        </div>
                        <div class="hutang-wrapper p-4 border mb-3" id="hutangToko">
                            <div class="form-group">
                                <label for="pembayaran_awal" class="col-form-label">Pembayaran Awal</label>
                                <input type="number" class="form-control" id="pembayaran_awal" name="pembayaran_awal">
                            </div>
                            <div class="form-group input_kadaluwarsa">
                                <label for="tgl_pelunasan" class="col-form-label">Tanggal Pelunasan</label>
                                <input type="date" class="form-control" id="tgl_pelunasan" name="tgl_pelunasan">
                            </div>
                        </div>
                        <div class="form-group" id="paidtoko">
                            <label for="createinputpaidtoko" class="col-form-label">Dibayar</label>
                            <input type="number" class="form-control" id="createinputpaidtoko" name="paid">
                        </div>
                        <p id="subtotalTokoWrapper">Total Yang Harus Dibayar : <span id="subtotalToko">0</span></p>
                        <p>Kembalian : <span id="changeToko">0</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
