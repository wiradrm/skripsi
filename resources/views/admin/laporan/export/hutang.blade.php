<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Nama</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Toko</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tipe</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Subtotal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Pembayaran Awal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Sisa</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jatuh Tempo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{$item->getCustomer ? $item->getCustomer->name : '-'}}</td>
            <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
            <td>
                @if($item->type_transaction == 1)
                    Pembelian
                @else
                    Penjualan
                @endif
            </td>
            <td>@currency($item->getTransaction->subtotal)</td>
            <td>@currency($item->pembayaran_awal)</td>
            <td>@currency($item->sisa_pembayaran)</td>
            <td>
                @if($item->getJatuhTempo() != 0)
                {{$item->getJatuhTempo()}} Hari Lagi
                @else
                <span class="text-danger">Jatuh Tempo</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>