<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('tarik.store')}}" method="POST" enctype="multipart/form-data">
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
                    {{-- <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control createDate" id="tanggal" name="tanggal" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div> --}}
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" class="form-control" id="jumlah" name="jumlah">
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


