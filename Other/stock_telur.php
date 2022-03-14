<?php
$hasilTelur = mysqli_query($conn, "select hasil.total-penjualan.total as stock_telur from 
(SELECT sum(hasil.super+ hasil.standar+ hasil.mk+ hasil.bakso) as total FROM tbl_hasil as hasil) as hasil,
(SELECT sum(penjualan.jumlah*CAST(kategori.keterangan as int)) as total FROM tbl_penjualan as penjualan, tbl_kategori as kategori
where
penjualan.satuan_kategori_id = kategori.id) as penjualan");
$stok_telur = 0;
if (mysqli_num_rows($hasilTelur) > 0) {
    while ($row = mysqli_fetch_assoc($hasilTelur)) {
        $stok_telur = $row['stock_telur'];
        break;
    }
}
?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h6>Stock Telur : <?php echo $stok_telur; ?> Butir / <?php echo $stok_telur/30; ?> Papan </h6>
        </div>
    </div>
</div>