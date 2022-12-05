<div class="modal fade bd-example-modal-lg text-left" id="updateModal-{{$item->no_pinjam}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Bayar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('pembayaran.update', $item->no_pinjam)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="text" name="no_pinjam" value="{{$item->no_pinjam}}" hidden>
                    <input type="text" name="id_nasabah" value="{{$item->id_nasabah}}" hidden>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Pinjaman</label> <br>
                        <b>
                            <span>{{ $item->no_pinjam }} | {{$item->nasabah->nama}}</span>
                        </b>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Sisa Hutang</label> <br>
                        <b>
                            <input type="text" id="jumlahHutang" name="hutang" value="{{$item->hutang}}" hidden>
                            <input type="text" id="persenBunga" name="persen" value="{{$item->bunga}}" hidden>
                            <span>@currency($item->hutang)</span>
                        </b>
                    </div>
                    <div class="form-group">
                        <label for="updateJumlah" class="col-form-label">Jumlah Bayar</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" class="form-control" id="updateJumlah" name="jumlah">
                          </div>
                    </div>
                    {{-- <b>
                        <p for="rincian">Rincian</p>
                        <p style="color: red">Minimal membayar bunga</p>
                        <p>Bunga : <span id="bunga">0</span></p>
                        <p id="subtotalWrapper">Pokok : <span id="pokok">0</span></p>
                        <p>Sisa Hutang : <span id="sisa">0</span></p>
                    </b> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>