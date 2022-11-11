<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('hutang.update', $item->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="created_at" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control" id="created_at" name="created_at" value="{{date('Y-m-d', strtotime($item->created_at))}}">
                    </div>
                    <div class="form-group">
                        <label for="subtotal" class="col-form-label">Subtotal</label>
                        <input type="number" readonly class="form-control" id="subtotal" name="subtotal" value="{{ $item->getTransaction ? $item->getTransaction->subtotal : ''}}">
                    </div>
                    <div class="form-group">
                        <label for="pembayaran_awal" class="col-form-label">Pembayaran Total</label>
                        <input type="number" class="form-control" id="pembayaran_awal" name="pembayaran_awal" value="{{$item->pembayaran_awal ?? ''}}">
                    </div>
                    <div class="form-group input_kadaluwarsa">
                        <label for="tgl_pelunasan" class="col-form-label">Tanggal Pelunasan</label>
                        <input type="date" class="form-control" id="tgl_pelunasan" name="tgl_pelunasan" value="{{date('Y-m-d', strtotime($item->tgl_pelunasan ?? ''))}}">
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