<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Telur</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Harga Toko per Tray</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Harga Gudang per Tray</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }}</td>
            <td>@currency($item->harga_jual_per_tray)</td>
            <td>@currency($item->harga_gudang_per_tray)</td>
        </tr>
        @endforeach
    </tbody>
</table>