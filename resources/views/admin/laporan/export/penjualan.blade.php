<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Toko</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Pelanggan</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Telur</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jumlah</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Satuan</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Harga</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Sub Total</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
            <td>{{ $item->customer }}</td>
            <td>{{ $item->getTelurKeluar ? $item->getTelurKeluar->getJenisTelur->jenis_telur : ''}}</td>
            <td>{{ $item->getTelurKeluar ? $item->getTelurKeluar->jumlah : ''}}</td>
            <td>{{ $item->getTelurKeluar ? $item->getTelurKeluar->satuan : ''}}</td>
            <td>@currency($item->harga)</td>
            <td>@currency($item->subtotal)</td>
            <td>
                @if($item->status_pembayaran === 1)
                Lunas
                @elseif($item->status_pembayaran === 2)
                Hutang
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>