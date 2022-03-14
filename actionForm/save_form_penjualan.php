<?php
include_once '../connection.php';
if (isset($_POST['save'])) {
	$nama_pembeli = $_POST['nama_pembeli'];
	$kelas_id = $_POST['kelas_id'];
	$satuan_id = $_POST['satuan_id'];
	$jumlah = $_POST['jumlah'];
	$dibayar = $_POST['dibayar'];
	$tanggal = $_POST['tanggal'];
	$harga = str_replace(',', '', $_POST['harga']);
	$id = uniqid();
	if ($dibayar === 'on') $dibayar = 1;
	else $dibayar = 0;

	echo $nama_pembeli . '<br/>';
	echo $kelas_id . '<br/>';
	echo $satuan_id . '<br/>';
	echo $jumlah . '<br/>';
	echo $dibayar . '<br/>';
	echo $harga . '<br/>';
	echo $tanggal . '<br/>';

	$sql = "INSERT INTO tbl_penjualan (id,kelas_kategori_id,satuan_kategori_id,harga,nama_customer,jumlah,dibayar,tanggal)
	 VALUES ('$id','$kelas_id','$satuan_id','$harga','$nama_pembeli','$jumlah','$dibayar','$tanggal')";
	echo $sql;

	if (mysqli_query($conn, $sql)) {
		// echo "New record created successfully !";
		header("location:../?page=table_penjualan");
	} else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	}
	mysqli_close($conn);
}
