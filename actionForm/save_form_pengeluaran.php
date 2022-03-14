<?php
include_once '../connection.php';
if (isset($_POST['save'])) {
	$kelas_id = $_POST['kelas_id'];
	$total =  str_replace(',', '', $_POST['total']);
	$keterangan = $_POST['keterangan'];
	$tanggal = $_POST['tanggal'];
	$id = uniqid();
	echo $kelas_id . '<br/>';
	echo $total . '<br/>';

	$sql = "INSERT INTO tbl_pengeluaran (id,pengeluaran_kategori_id,jumlah,keterangan,tanggal)
	 VALUES ('$id','$kelas_id','$total','$keterangan','$tanggal')";
	echo $sql;

	if (mysqli_query($conn, $sql)) {
		// echo "New record created successfully !";
		header("location:../?page=pengeluaran");
	} else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	}
	mysqli_close($conn);
}
