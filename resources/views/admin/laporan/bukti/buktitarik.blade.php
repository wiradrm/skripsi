<!DOCTYPE html>
<html>
<head>
	<title>Bukti Tarik</title>
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
				<font size="4">BUKTI TARIK</font>
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
				<th>Nama :</th>
				<td>{{$data->nama}}</td>
				<th>Jumlah Penarikan :</th>
				<td>{{$data->no}}</td>
                <th>Sisa Tabungan :</th>
				<td>{{$data->no}}</td>
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