<?php
    $priveQuery = mysqli_query($conn, " 
    select COALESCE(sum(pengeluaran.jumlah),0) as jumlah 
    from tbl_pengeluaran as pengeluaran, tbl_kategori as kategori
    WHERE pengeluaran.pengeluaran_kategori_id=kategori.id 
    and kategori.nama='Prive';
    ");

?>