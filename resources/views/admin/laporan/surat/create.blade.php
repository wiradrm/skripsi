<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="myForm" action="{{route('laporan.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama Nasabah</label>
                        <select class="selectpicker form-control"  name="nama" id="id_nasabah" data-live-search="true">
                            <option hidden></option>
                            @foreach($nasabah as $key => $item)
                            <option value="{{$item->nama}}">{{$item->id}} | {{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control createDate" id="createDate" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Periode</label>
                        <select class="form-control selectpicker"  name="periode" id="id_nasabah" data-live-search="true">
                            <option hidden></option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah Tunggakan</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" class="form-control uang" id="jumlah" name="jumlah">
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Lama Penunggakan</label>
                        <input class="form-control" name="lama" id="alamat" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-printer'></i> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>