<!DOCTYPE html>
<html>
<head>
	<title>Surat Tunggakan</title>
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
				<font size="4">SURAT TUNGGAKAN</font>
			</center>
		</table> <br><br>
		<table width="350">
			<tr>
				<td>Surat tunggakan pinjamanan dengan identitas sebagai berikut:</td>
			</tr>
		</table>
		<br>
		<table >
			<tr>
				<th>Nama :</th>
				<td>{{$data->nama}}</td>
			</tr>
			
		</table>
		<table>
			<tr>
				<td>Dimohon untuk melakukan pelunasan penunggakan pinjaman periode <b>{{$data->periode}}</b>
					tanggal <b>{{$data->tanggal}}</b> dengan jumlah tunggakan sebesar <b>@currency($data->jumlah)</b>
					 tunggakan sebanyak {{$data->lama}}</td>
			</tr>
		</table>
<br>
		<table>
			<tr>
				<td>Atas perhatiannya saya ucapkan terimakasi</td>
			</tr>
		</table>
		<br><br><br><br>
		
		<table>
			<tr>
				<td>Bendahara LPD Benana</td>
			</tr>

		</table>

		
 
 
</body>
</html>