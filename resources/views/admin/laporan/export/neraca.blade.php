<table class="table table-bordered">
    
    <thead>
        <tr>
            <td colspan="7">
            <h6 class="m-0 font-weight-bold text-primary">Data Neraca per {{ $startDate ? date('d-m-Y', strtotime($startDate))  : $mytime }} {{ $startDate ? "sampai" : "" }} {{ $endDate ? date('d-m-Y', strtotime($endDate))  : "" }}</h6>
            </td>
        </tr>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;" colspan="3">Aktiva</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;" colspan="3">Pasiva</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>1. Kas</td>
            <td>100</td>
            <td>@currency($labaBersih)</td>
            <td>1. Tabungan</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;&nbsp;1.1 Tabungan Wajib</td>
            <td>140</td>
            <td>@currency($tabunganWajib)</td>
        </tr>
        <tr>
            <td>2. Bank</td>
            <td></td>
            <td></td>
            <td>&nbsp;&nbsp;1.2 Tabungan Sukarela</td>
            <td>141</td>
            <td>@currency($totalHutang)</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;2.1 Tabungan</td>
            <td>101</td>
            <td>@currency($totalTabungan)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>R/L Tahun Berjalan</td>
            <td>470</td>
            <td>@currency($labaBersih)</td>
        </tr>
        <tr>
            <td>Pinjaman diberikan</td>
            <td>123</td>
            <td>@currency($totalPinjaman)</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Jumlah</td>
            <td></td>
            <td style="font-weight: bold;">@currency($totalAktiva)</td>
            <td style="font-weight: bold;">Jumlah</td>
            <td></td>
            <td style="font-weight: bold;">@currency($totalPassiva)</td>
        </tr>        
    </tbody>

    
</table>