<div class="modal fade bd-example-modal-lg text-left" id="detail-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailLabel">Detail Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($item->showDetails()->count() == 0)
                            <tr>
                                <td colspan="100%" align="center">
                                    No data
                                </td>
                            </tr>
                            @endif
                            @foreach($item->showDetails() as $key => $data)
                            <tr>
                                <td>{{ $item->id_nasabah }}</td>
                                <td>{{ $item->nasabah->nama }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ $item->debet ? $item->debet : '-' }}</td>
                                <td>{{ $item->kredit ? $item->kredit : '-' }}</td>
                                <td>{{ $saldo = $saldo - $item->debit + $item->kredit}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>