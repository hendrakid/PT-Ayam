<?php
include_once '../connection.php';
if (isset($_POST['save'])) {
	$kategori_id = $_POST['kategori_id'];
	$keterangan = $_POST['keterangan'];
	$tanggal = $_POST['tanggal'];
	$jumlah = str_replace(',', '', $_POST['jumlah']);
	$id = uniqid();

	$sql = "INSERT INTO tbl_modal (id,penambahan_modal_kategori_id,jumlah,keterangan,tanggal)
	 VALUES ('$id','$kategori_id','$jumlah','$keterangan','$tanggal')";
	echo $sql;

	if (mysqli_query($conn, $sql)) {
		// echo "New record created successfully !";
		header("location:../?page=form_penambahan_modal");
	} else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	}
	mysqli_close($conn);
}
