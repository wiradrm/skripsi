<div class="modal fade bd-example-modal-lg text-left" id="createModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pengeluaran.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createDate" class="col-form-label">Tanggal</label>
                        <input type="date" class="form-control createDate" id="createDate" name="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="subtotal" class="col-form-label">Subtotal</label>
                        <input type="text" class="form-control" id="subtotal" name="subtotal">
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" cols="30" rows="10"></textarea>
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