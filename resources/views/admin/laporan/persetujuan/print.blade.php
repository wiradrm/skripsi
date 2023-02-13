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
				<td>Surat persetujuan pinjamanan dengan identitas sebagai berikut:</td>
			</tr>
		</table>
		<br>
		<table >
			<tr>
				<th>Nama :</th>
				<td>{{$data->nama}}</td>
				<th>No Pinjam :</th>
				<td>{{$data->no}}</td>
			</tr>
			
		</table>
		<table>
			<tr>
				<td>Persetujuan pengajuan pinjaman sebesar <b>{{$data->jumlah}}</b> dengan bunga <b>{{$data->bunga}}%</b>. 
					Persetujuan ini dibuat untuk menyetujui pinjaman dan sanksi apabila adanya keterlambatan pembayaran pinjaman.
					Demikian surat ini dibuat sebagai tanda persetujuan antara kedua belah pihak.
			</tr>
		</table>
<br>
		<table>
			<tr>
				<td>Atas perhatiannya saya ucapkan terimakasi</td>
			</tr>
		</table>
		<br>
		<br>
		
		<table style="width: 100%">
			<tr>
				<td></td>
				<td>Denpasar, {{date('d M Y', strtotime($data->tanggal))}} </td>
			</tr>
			<tr>
				<td>Bendahara LPD Benana</td>
				<td>Nasabah</td>
			</tr>
			<br><br><br>
			<tr>
				<td>Ni Made Desy Wulandari</td>
				<td>{{$data->nama}}</td>
			</tr>

		</table>

		
 
 
</body>
</html>