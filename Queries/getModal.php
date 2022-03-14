<?php
$modalQuery = mysqli_query($conn, "
SELECT SUM(jumlah) as jumlah, 'modal' as kategori from tbl_modal as modal , tbl_kategori as kategori
        WHERE modal.penambahan_modal_kategori_id=kategori.id and kategori.kategori = 'PenambahanModal'
            and kategori.nama = 'Pribadi'
            union
        select utang.utang-bayar.bayar as jumlah, 'hutang' as kategori from (
            SELECT COALESCE(SUM(modal.jumlah),0) as utang 
            from tbl_modal as modal, tbl_kategori as kategori
            WHERE modal.penambahan_modal_kategori_id=kategori.id 
            and kategori.kategori = 'PenambahanModal'
            and kategori.nama = 'Utang') as utang,
        (
            select COALESCE(sum(pengeluaran.jumlah),0) as bayar 
             from tbl_pengeluaran as pengeluaran, tbl_kategori as kategori
            WHERE pengeluaran.pengeluaran_kategori_id=kategori.id 
            and kategori.nama='Pembayaran Utang') as bayar
        
        ");

?>