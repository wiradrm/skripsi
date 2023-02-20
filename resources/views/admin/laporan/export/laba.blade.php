<table class="table table-bordered">
    
    <thead>
        <tr>
            <td colspan="7">
            <h6 class="m-0 font-weight-bold text-primary">Data Laba/Rugi per {{ $startDate ? date('d-m-Y', strtotime($startDate))  : $mytime }} {{ $startDate ? "sampai" : "" }} {{ $endDate ? date('d-m-Y', strtotime($endDate))  : "" }}</h6>
            </td>
        </tr>
        <tr>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Data</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Sandi</th>
            <th style="vertical-align : middle; text-align:center; font-weight: bold; background : #d9d9d9;">Total</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td colspan="3">A. Pendapatan Operasional</td>
        </tr>
        <tr>
            <td style="padding-left: 20px">1. Hasil</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 40px">a. Dari Bank-Bank Lain</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">i. Giro</td>
            <td>120</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">ii. Tabungan</td>
            <td>121</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">iii. Simpanan Berjangka</td>
            <td>122</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">iv. Pinjaman Yang Diberikan</td>
            <td>123</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">v. Lainnya</td>
            <td>124</td>
            <td>@currency($pendapatanAdmin)</td>
        </tr>
        <tr>
            <td style="padding-left: 40px">b. Dari Pihak Ketiga Bukan Bank</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">i. Pinjaman Yang Diberikan</td>
            <td>126</td>
            <td>@currency($pendapatanBunga)</td>
        </tr>
        <tr>
            <td style="padding-left: 60px">ii. Lainnya</td>
            <td>126</td>
            <td>@currency($totalPemasukan)</td>
        </tr>
        <tr>
            <td><b>JUMLAH PENDAPATAN OPERASIONAL</b></td>
            <td><b>100</b></td>
            <td><b>@currency($labaKotor)</b></td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="3">B. Biaya Operasional</td>
        </tr>
        <tr>
            <td style="padding-left: 20px">1. Biaya Bunga</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 40px">a. Kepada Bank-Bank Lain</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">i. Simpanan Berjangka</td>
            <td>194</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">ii. Pinjaman Yang Diterima</td>
            <td>195</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">iii. Lainnya</td>
            <td>199</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 40px">b. Kepada Pihak Ketiga Bukan Bank</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">i. Simpanan Berjangka</td>
            <td>203</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">ii. Tabungan</td>
            <td>206</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 60px">iii. Lainnya</td>
            <td>209</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 20px">2. Pemeliharaan dan Perbaikan</td>
            <td>280</td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 20px">3. Biaya Operasional Lainnya</td>
            <td>301</td>
            <td>@currency($labaOperasi)</td>
        </tr>
        <tr>
            <td><b>JUMLAH BIAYA OPERASIONAL</b></td>
            <td><b>100</b></td>
            <td><b>@currency($labaOperasi)</b></td>
        </tr>
        <tr>
            <td><b>JUMLAH LABA RUGI TAHUN BERJALAN</b></td>
            <td><b>470</b></td>
            <td><b>@currency($labaBersih)</b></td>
        </tr>        
    </tbody>

    
</table>