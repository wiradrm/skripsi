<!DOCTYPE html>
<html>
<head>
	<title>Bukti Bayar</title>
</head>
<body>
	<style type="text/css">
		/* @page{
			size:8in 7.5in;

		} */

		#judul {
			text-align: center;

		}

		#halaman{
			width: auto;
			height: auto;
			position: absolute;
			border: 1px solid;
			padding-top: 30px;
			padding-left: 30px;
			padding-right: 30px;
			padding-bottom: 80px;
		}

	</style>
		<table width="100%">
			<center>
				<font size="4">LPD Desa Pakraman Benana</font><br>
				<font size="4">BUKTI BAYAR</font><br>
				<font size="4">{{date('d M Y, H:i', strtotime($data->tanggal))}}</font>

			</center>
		</table> <br><br>
		<table width="350">
			<tr>
				<td>Bukti pembayaran</td>
			</tr>
		</table>
		<br>
		<table >
			<tr>
                <td><b>Jumlah Bayar</b> </td>
                <td>:</td>
				<td>@currency($data->jumlah)</td>
                
                
			</tr>
            <tr>
                <td><b>Biaya Admin</b></td>
                <td>:</td>
				<td>@currency($data->administrasi)</td>
            </tr>
            <tr>
                <td><b>Pokok</b></td>
                <td>:</td>
				<td>@currency($data->pokok)</td>
            </tr>
			<tr>
                
                <td><b>Bunga</b></td>
                <td>:</td>
				<td>@currency($data->bunga)</td>
            </tr>
		</table>
		<table>
			<tr>
				<td>Mohon untuk disimpan bukti bayar ini, terimakasi.</td>
			</tr>
		</table>
<br>

		
 
 
</body>
</html>