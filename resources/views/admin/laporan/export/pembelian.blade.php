<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Toko</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Supplier</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Telur</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jumlah</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Satuan</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Harga Beli</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Sub Total</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Pembayaran</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">kedaluwarsa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
            <td>{{ $item->supplier }}</td>
            <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->getJenisTelur->jenis_telur : ''}}</td>
            <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->jumlah : ''}}</td>
            <td>{{ $item->getTelurMasuk ? $item->getTelurMasuk->satuan : ''}}</td>
            <td>@currency($item->harga_beli)</td>
            <td>@currency($item->subtotal)</td>
            <td>
                @if($item->status_pembayaran === 1)
                Lunas
                @elseif($item->status_pembayaran === 2)
                Hutang
                @endif
            </td>
            <td>
                @if($item->getTelurMasuk)
                    @if($item->getTelurMasuk->getKedaluwarsa() != 0)
                    {{$item->getTelurMasuk->getKedaluwarsa()}} Hari Lagi
                    @else
                    <span class="text-danger">Kadaluwarsa</span>
                    @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>