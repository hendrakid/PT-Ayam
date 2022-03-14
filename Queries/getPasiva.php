<?php
    
    $pasivaQuery = mysqli_query($conn, " 
    SELECT pengeluaran.jumlah, pengeluaran.keterangan from tbl_pengeluaran as pengeluaran, tbl_kategori as kategori
    where pengeluaran.pengeluaran_kategori_id=kategori.id
    and kategori.nama ='Asset Tetap'");

?>