<div class="modal fade bd-example-modal-lg text-left" id="exportModalHarga" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('laporan.simpanan.export')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_nasabah" class="col-form-label">Nama Nasabah</label>
                            <select class="form-control selectpicker"  name="id_nasabah" id="id_nasabah" data-live-search="true">
                                <option hidden></option>
                                @foreach($nasabah as $key => $item)
                                <option value="{{$item->id}}">{{$item->id}} | {{$item->nama}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label for="from" class="col-form-label">Dari</label>
                        <input type="date" class="form-control" id="from" name="from" required>
                    </div>
                    <div class="form-group">
                        <label for="to" class="col-form-label">Sampai</label>
                        <input type="date" class="form-control" id="to" name="to" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>