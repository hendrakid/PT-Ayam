<?php
include_once '../connection.php';
if (isset($_POST['save'])) {
	$proccedPaymentId = $_POST['proccedPaymentId'];;

	$sql = "UPDATE `tbl_penjualan` SET `dibayar` = '1', `tanggal` = NOW() WHERE `tbl_penjualan`.`id` = '" . $proccedPaymentId . "'";

	if (mysqli_query($conn, $sql)) {
		// echo "New record created successfully !";
		header("location:../?page=table_penjualan");
	} else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	}
	mysqli_close($conn);
}
