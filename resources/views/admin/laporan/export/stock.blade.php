<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Toko/Gudang</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Telur</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Stock</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Satuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : '' }}</td>
            <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : '' }}</td>
            <td>{{ $item->getStock() }}</td>
            <td>{{ $item->satuan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>