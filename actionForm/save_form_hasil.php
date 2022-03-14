<?php
include_once '../connection.php';
if (isset($_POST['save'])) {
	$super = $_POST['super'];
	$standar = $_POST['standar'];
	$mk = $_POST['mk'];
	$bakso = $_POST['bakso'];
	$tanggal = $_POST['tanggal'];

	if ($super === '') $super = 0;
	if ($standar === '') $standar = 0;
	if ($mk === '') $mk = 0;
	if ($bakso === '') $bakso = 0;

	echo $tanggal . "<br/>";



	$id = uniqid();
	$sql = "INSERT INTO tbl_hasil (id,super,standar,mk,bakso,tanggal)
	 VALUES ('$id','$super','$standar','$mk','$bakso','$tanggal')";
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully !";
		header("location:../?page=hasil_telur");
	} else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	}
	mysqli_close($conn);
}
