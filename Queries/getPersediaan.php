<?php

$persediaanQuery = mysqli_query($conn, "
SELECT 
-- pengeluaran.jumlah, pengeluaran.tanggal, 
-- datediff(current_date(), " . $tanggalMulai . ") as selisih ,
-- pengeluaran.jumlah/pengeluaran.keterangan as 1karung,
-- pengeluaran.jumlah/pengeluaran.keterangan/50 as 1kg,
-- pengeluaran.jumlah/pengeluaran.keterangan/50*42 as 1hari,
-- pengeluaran.jumlah/pengeluaran.keterangan/50*42*datediff(current_date(), pengeluaran.tanggal) as xselisih,

COALESCE(pengeluaran.jumlah - pengeluaran.jumlah/pengeluaran.keterangan/50*42* datediff(current_date(), '" . $tanggalMulai . "'),0) as persediaan
FROM tbl_pengeluaran as pengeluaran, tbl_kategori as kategori
WHERE pengeluaran.pengeluaran_kategori_id=kategori.id and kategori.nama='Makan Ayam'");

?>