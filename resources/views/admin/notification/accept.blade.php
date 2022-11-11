<div class="modal fade" id="notifModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprrove Telur Masuk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table border">
                    <tbody>
                        <tr>
                            <th scope="row">Jenis Telur</th>
                            <th>Jumlah</th>
                            <th>Kedaluwarsa</th>
                            <th>Harga Beli/Tray</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>{{$item->getTransaction ? $item->getTransaction->getJenisTelur->jenis_telur : ''}}</td>
                            <td>{{$item->getTransaction ? $item->getTransaction->showJumlah() : ''}}</td>
                            <td>
                                @php($getTelurKeluarId = App\Notification::where('id', $item->id)->pluck('id_transaction')->first())
                                @php($telurKeluar = App\TelurKeluar::where('id', $getTelurKeluarId)->first())

                                @php($getTelurMasukId = App\TransferStock::where('id_telur_keluar', $getTelurKeluarId ? $getTelurKeluarId : '')->pluck('id_telur_masuk')->first())
                                @php($getTelurKandangId = App\TransferStockKandang::where('id_penjualan', $telurKeluar ? $telurKeluar->id_penjualan : '')->pluck('id_telur_kandang')->first())

                                @if(!$getTelurMasukId)
                                    @php($TelurMasuk = App\TelurKandang::where('id', $getTelurKandangId)->first())
                                @else
                                    @php($TelurMasuk = App\TelurMasuk::where('id', $getTelurMasukId)->first())
                                @endif

                                @if($TelurMasuk ? $TelurMasuk->getKedaluwarsa() : '' != 0)
                                    {{$TelurMasuk ? $TelurMasuk->getKedaluwarsa() : ''}} Hari Lagi
                                @else
                                    <span class="text-danger">Kadaluwarsa</span>
                                @endif
                            </td>
                            @php($penjualan = App\Penjualan::where('id_telur_keluar', $getTelurKeluarId)->first())
                            <td>@if($penjualan) @currency($penjualan->harga) @endif</td>
                            <td>@if($penjualan) @currency($penjualan->subtotal) @endif</td>
                            <td>                <a href="{{ route('notification.telur_masuk', $item->id) }}" class="btn btn-primary">
                                Terima
                            </a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> --}}
        </div>
    </div>
</div>
