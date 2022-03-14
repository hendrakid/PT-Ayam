<?php
include_once '../connection.php';
if(isset($_POST['save']))
{	 
	 $kelas_kategori_id = $_POST['kelas_id'];
	 $harga = str_replace(',', '', $_POST['harga']);
     $id= uniqid();
	 $sql = "INSERT INTO tbl_harga (id,kelas_kategori_id,harga)
	 VALUES ('$id','$kelas_kategori_id','$harga')";
	 if (mysqli_query($conn, $sql)) {
		echo "New record created successfully !";
        header("location:../?page=harga_telur");
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}
