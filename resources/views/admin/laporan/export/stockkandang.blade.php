<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal Masuk</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Toko/Gudang</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Kandang</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Telur</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jumlah</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">kedaluwarsa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getTokoGudang ? $item->getTokoGudang->nama : ''}}</td>
            <td>{{ $item->getJenisKandang ? $item->getJenisKandang->jenis_kandang : '' }}</td>
            <td>{{ $item->getJenisTelur ? $item->getJenisTelur->jenis_telur : ''}}</td>
            <td>{{ $item->showJumlahDetails() }}</td>
            <td>
                @if($item->getKedaluwarsa() != 0)
                {{$item->getKedaluwarsa()}} Hari Lagi
                @else
                <span class="text-danger">Kadaluwarsa</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>