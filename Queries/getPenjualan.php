<?php

    $penjualanQuery = mysqli_query($conn, " 
        SELECT SUM(penjualan.harga/30*kategori.keterangan*penjualan.jumlah) as jumlah , penjualan.dibayar as status 
        FROM tbl_penjualan penjualan, tbl_kategori as kategori 
        WHERE kategori.id=penjualan.satuan_kategori_id 
                " . $filter . " 
        GROUP BY penjualan.dibayar");

?>