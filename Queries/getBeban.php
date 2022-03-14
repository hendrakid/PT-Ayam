<?php
$bebanQuery = mysqli_query($conn, "SELECT sum(pengeluaran.jumlah) as jumlah, kategori.nama as kategori_pengeluaran
            FROM tbl_pengeluaran pengeluaran, tbl_kategori kategori 
            WHERE kategori.id=pengeluaran.pengeluaran_kategori_id 
                and kategori.nama!='Asset Tetap'
            " . $filter . "
            group by kategori.nama order by kategori.id;");

