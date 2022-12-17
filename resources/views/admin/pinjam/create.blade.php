<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="myForm" action="{{route('pinjam.store')}}" method="GET" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_nasabah" class="col-form-label">Nama Nasabah</label>
                        <select class="selectpicker form-control"  name="id_nasabah" id="id_nasabah" data-live-search="true">
                            <option hidden></option>
                            @foreach($nasabah as $key => $item)
                            <option value="{{$item->id}}">{{$item->id}} | {{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_pinjam" class="col-form-label">No Pinjaman</label>
                        <input type="text" class="form-control" id="no_pinjam" name="no_pinjam">
                    </div>
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal Pinjaman</label>
                        <input type="date" class="form-control createDate" id="tanggal" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="pinjaman" class="col-form-label">Jumlah Pinjaman</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" class="form-control uang" id="uang" name="pinjaman">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bunga" class="col-form-label">Bunga Menurun</label>
                        <input type="number" step="0.01" class="form-control" id="bunga" name="bunga">
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


