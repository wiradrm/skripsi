<div class="modal fade bd-example-modal-lg text-left" id="exportModalPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exportModalPengeluaran" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pengeluaran.export')}}" method="GET" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="from" class="col-form-label">Dari</label>
                        <input type="date" class="form-control" id="from" name="from" required>
                    </div>
                    <div class="form-group">
                        <label for="to" class="col-form-label">Sampai</label>
                        <input type="date" class="form-control" id="to" name="to" required>
                    </div>
                    @if(Auth::user()->level == 2)
                    @php($toko = App\TokoGudang::get())
                    <div class="form-group">
                        <label for="id_toko_gudang" class="col-form-label">Toko / Gudang</label>
                        <select class="form-control" name="id_toko_gudang" id="id_toko_gudang">
                            <option value="">Default</option>
                            @foreach($toko as $key => $item)
                            <option @if(Auth::user()->id_toko_gudang == $item->id) selected @endif value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input hidden type="number"  name="id_toko_gudang" id="id_toko_gudang" value="{{Auth::user()->id_toko_gudang}}">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>