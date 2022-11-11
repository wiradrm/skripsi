<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Toko</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Subtotal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
            <td>@currency($item->subtotal)</td>
            <td>{{ $item->keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>