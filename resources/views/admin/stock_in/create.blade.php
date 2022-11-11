<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('stock.store_stock_in')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control createDate" id="createDate" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="telur_kandang" class="col-form-label">Pilih telur kandang yang akan di sortir</label>
                        <select class="form-control"  name="id_telur_kandang" id="telur_kandang">
                            @foreach($telurKandang as $key => $item)
                                @if($item->checkStock())
                                    <option value="{{$item->id}}">{{date('d/m/Y', strtotime($item->created_at))}} ( {{$item->showJumlahDetails()}})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_telur" class="col-form-label">Jenis Telur</label>
                        <select class="form-control"  name="id_jenis_telur" id="jenis_telur">
                            @foreach($jenistelur as $key => $item)
                            <option value="{{$item->id}}">{{$item->jenis_telur}}</option>
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
                        <select class="form-control" name="satuan" id="satuan_create">
                            <option value="Tray">Tray</option>
                            <option value="Butir">Butir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah">
                    </div>
                    <div class="form-group input_kadaluwarsa">
                        <label for="kadaluwarsa" class="col-form-label">Kadaluwarsa</label>
                        <input type="date" class="form-control" id="kadaluwarsa" name="kedaluwarsa" required>
                    </div>
                {{-- <div class="form-group">
                    <label for="keterangan" class="col-form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
                </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>