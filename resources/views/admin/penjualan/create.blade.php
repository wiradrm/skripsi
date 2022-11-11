<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('penjualan.store')}}" method="POST">
                @csrf
                <input hidden type="number" value="0" name="type">
                <div class="modal-body">
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Harga Telur</h4>
                        <hr>
                        @foreach($harga as $key => $item)
                        <p class="mb-0">Harga {{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }} : @currency($item->harga_jual_per_tray) / Tray</p>
                        @endforeach
                      </div>
                    <div>
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control createDate" id="createDate" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group create_input_customer_hutang">
                        <label for="customer" class="col-form-label">Pelanggan</label>
                        <input type="text" class="form-control" id="customer" name="customer">
                    </div>
                    <div class="form-group create_customer_hutang">
                        <label for="customer" class="col-form-label">Pelanggan</label>
                        <select id="customer" class="form-control"  name="id_customer">
                            @foreach($customer as $key => $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenisTelur" class="col-form-label">Jenis Telur</label>
                        <select id="jenisTelur" class="form-control"  name="id_jenis_telur" required>
                            @foreach($jenistelur as $key => $item)
                            <option value="{{$item->id}}">{{$item->jenis_telur}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(Auth::user()->level == 2)
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko/Gudang</label>
                        <select class="form-control"  name="id_toko_gudang" id="toko" required>
                            @foreach($tokogudang as $key => $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="satuan_create" class="col-form-label">Satuan</label>
                        <select class="form-control" name="satuan" id="satuan_create" required>
                            <option value="Tray">Tray</option>
                            <option value="Butir">Butir</option>
                        </select>
                    </div>
                    <div class="form-group harga_telur">
                        <label for="setHargaGudang" class="col-form-label">Harga</label>
                        <input type="number" class="form-control" id="setHargaGudang" name="harga">
                    </div>
                    <div class="form-group">
                        <label for="createJumlah" class="col-form-label">Jumlah</label>
                        <input type="number" class="form-control" id="createJumlah" name="jumlah">
                    </div>
                    <div class="form-group">
                        <label for="createStatusPembayaran" class="col-form-label">Pembayaran</label>
                        <select class="form-control"  name="status_pembayaran" id="createStatusPembayaran">
                            <option value="1">Lunas</option>
                            <option value="2">Hutang</option>
                        </select>
                    </div>
                    <div class="hutang-wrapper p-4 border mb-3" id="hutang">
                        <div class="form-group">
                            <label for="pembayaran_awal" class="col-form-label">Pembayaran Awal</label>
                            <input type="number" class="form-control" id="pembayaran_awal" name="pembayaran_awal">
                        </div>
                        <div class="form-group input_kadaluwarsa">
                            <label for="tgl_pelunasan" class="col-form-label">Tanggal Pelunasan</label>
                            <input type="date" class="form-control" id="tgl_pelunasan" name="tgl_pelunasan">
                        </div>
                    </div>
                    <div class="form-group" id="paid">
                        <label for="createinputpaid" class="col-form-label">Dibayar</label>
                        <input type="number" class="form-control" id="createinputpaid" name="paid">
                    </div>
                    <p id="subtotalWrapper">Total Yang Harus Dibayar : <span id="subtotal">0</span></p>
                    <p>Kembalian : <span id="change">0</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>