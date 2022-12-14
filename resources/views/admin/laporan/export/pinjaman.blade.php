<table class="table table-bordered">
    @php
    $jumlah_hutang = 0;
    $hutang_sebelumnya = $pinjaman->pinjaman;
    @endphp
    @foreach($past as $key => $data)
    @php
        $jumlah_hutang = $hutang_sebelumnya - $data->pokok;
        $hutang_sebelumnya -= $data->pokok;
    @endphp
    @endforeach
    <thead>
        <tr>
            <td colspan="8">
            Data pembayaran pinjaman   {{$nama}}   dari   {{date('d/m/Y', strtotime($startDate))}}   sampai   {{ date('d/m/Y', strtotime($endDate)) }}
            </td>
        </tr>
        <tr>
        <th align="right" colspan="7">Sisa hutang sebelumnya</th>
        <th>@currency($hutang_sebelumnya)</th>
        </tr>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">No Pinjam</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Nama</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Tanggal</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Jumlah Bayar</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Biaya Administrasi</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Pokok</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Bunga</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Sisa Hutang</th>
        </tr>
    </thead>

    @php
    $sisa=$hutang_sebelumnya;
@endphp
    <tbody>
        @if($models->count() == 0)
                    <tr>
                        <td colspan="7" align="center">
                            Tidak ada data transaksi
                        </td>
                    </tr>
                    @endif

        @foreach($models as $key => $item)
                    <tr>
                        <td>{{ $item->no_pinjam }}</td>
                        <td>{{ $item->nasabah->nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td>@currency($item->jumlah)</td>
                        <td>@currency($item->administrasi)</td>
                        <td>@currency($item->pokok)</td>
                        <td>@currency($item->bunga)</td>
                        
                        <td>@currency($jumlah = $sisa - $item->pokok)</td>
                        @php
                            $sisa -= $item->pokok;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="7" align="right"><b>Sisa Hutang</b> </td>
                        <td><b>@currency($sisa)</b> </td>
                    </tr>
    </tbody>
</table>