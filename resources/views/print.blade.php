<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Membuat Laporan PDF Dengan DOMPDF Laravel</h4>
		<h6><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">www.malasngoding.com</a></h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Alamat</th>
				<th>Telepon</th>
				<th>Pekerjaan</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				@foreach($data as $key => $item)

				<td>{{$item->$nama}}</td>
				<td>{{$item->$tanggal}}</td>
				<td>{{$item->$periode}}</td>
				<td>{{$item->$jumlah}}</td>
				<td>{{$item->$lama}}</td>
				@endforeach
			</tr>
		</tbody>
	</table>
 
</body>
</html>