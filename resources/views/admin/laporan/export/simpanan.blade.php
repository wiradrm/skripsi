<table class="table table-bordered">
    @php
                    $jumlah_saldo = 0;
                    $saldo_awal = 0;
                @endphp
                @foreach($past as $key => $data)
                @php
                    $saldo_awal = $jumlah_saldo + $data->kredit - $data->debet;
                    $jumlah_saldo += $data->kredit - $data->debet;
                @endphp
                @endforeach
    <thead>
        <tr>
                    <th align="right" colspan="6">Saldo sebelumnya</th>
                    <th>@currency($saldo_awal)</th>
        </tr>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">ID Nasabah</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Nama</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Keterangan</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Debet</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Kredit</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Saldo</th>
        </tr>
    </thead>

    @php
        $jumlah = $saldo_awal;
    @endphp
    <tbody>
        @foreach($models as $key => $item)
                    <tr>
                        <td>{{ $item->nasabah->id }}</td>
                        <td>{{ $item->nasabah->nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>@currency($item->debet)</td>
                        <td>@currency($item->kredit)</td>
                        
                        <td>@currency($saldo = $jumlah + $item->kredit - $item->debet)</td>
                        @php
                            $jumlah += $item->kredit - $item->debet;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" align="right"><b>Saldo akhir</b> </td>
                        <td><b>@currency($jumlah)</b> </td>
                    </tr>
    </tbody>

    
</table>