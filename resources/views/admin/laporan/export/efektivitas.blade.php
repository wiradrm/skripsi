<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal Masuk</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jenis Kandang</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jumlah Ayam</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jumlah Telur</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Persentase Bertelu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($models as $key => $item)
        <tr>
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            <td>{{ $item->getJenisKandang ? $item->getJenisKandang->jenis_kandang : '' }}</td>
            <td>{{ $item->getJenisKandang ? $item->getJenisKandang->getJumlahAyam->jumlah : '' }}</td>
            <td>{{ $item->showJumlah() }}</td>
            <td>{{ $item->getPersentaseBertelur() }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>