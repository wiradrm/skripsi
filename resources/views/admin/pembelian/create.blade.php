<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pembelian.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control createDate" id="createDate" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="supplier" class="col-form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenistelur as $key => $item)
                            @if($item->jenis_telur != "Telur Campur")
                            <option value="{{$item->id}}">{{$item->jenis_telur}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @if(Auth::user()->level == 2)
                    <div class="form-group">
                        <label for="toko" class="col-form-label">Toko/Gudang</label>
                        <select class="form-control"  name="id_toko_gudang" id="toko">
                            @foreach($tokogudang as $key => $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="satuan_create" class="col-form-label">Satuan</label>
                        <select class="form-control" name="satuan">
                            <option value="Tray">Tray</option>
                            <option value="Butir">Butir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah">
                    </div>
                    <div class="form-group">
                        <label for="harga_beli" class="col-form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli">
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
                    <div class="form-group input_kadaluwarsa">
                        <label for="kadaluwarsa" class="col-form-label">Kadaluwarsa</label>
                        <input type="date" class="form-control" id="kadaluwarsa" name="kedaluwarsa" required>
                    </div>
                    <div class="form-group">
                        <label for="upload_image" class="col-form-label">Upload Nota</label>
                        <div class="form-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" accept="image/*" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                          </div>
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