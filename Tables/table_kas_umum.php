<?php

include('./Queries/filter.php');

$rawQuery = "
SELECT * from (
    SELECT modal.jumlah as jumlah,
        'debit' as kategori,
        modal.tanggal as tanggal,
        modal.keterangan as keterangan
        from tbl_modal as modal
    UNION
    SELECT pengeluaran.jumlah as jumlah, 
        'kredit' as kategori, 
        pengeluaran.tanggal as tanggal, 
        concat(tbl_kategori.nama,' : ',pengeluaran.keterangan)  as keterangan
    FROM tbl_pengeluaran as pengeluaran, tbl_kategori 
    WHERE pengeluaran.pengeluaran_kategori_id = tbl_kategori.id
    union 
    SELECT 
        penjualan.jumlah*kategori.keterangan*penjualan.harga as jumlah, 
        'debit' as kategori, 
        penjualan.tanggal as tanggal, 
        CONCAT('Penjualan ',penjualan.nama_customer,' ',penjualan.jumlah,' ',kategori.nama) 
    from tbl_penjualan as penjualan, tbl_kategori as kategori 
    WHERE penjualan.satuan_kategori_id = kategori.id and penjualan.dibayar=1) as kas  
ORDER BY `kas`.`tanggal`  asc";

echo '<script>console.log("' . $rawQuery . '")</script>';
$kasUmum = mysqli_query($conn, $rawQuery);


?>
<style>
    .centerXXX {
        margin: auto;
        text-align: center;
        margin-top: 10px;
    }

    .centerTable {
        margin: auto;
        width: 100%;
    }

    .titleItem {
        font-weight: bold;
    }
</style>
<div class="col-12">
    <div class="card">
        <div class="centerXXX">
            <h6>Buku Khas Umum</h6>
            <h6>Periode <?php echo $periodeMonth . ' ' . $periodeYear; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table border=0 class="centerTable">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                    </tr>
                    <?php
                    $saldo = 0;
                    $i = 0;
                    if (mysqli_num_rows($kasUmum) > 0) {
                        while ($row = mysqli_fetch_assoc($kasUmum)) {
                    ?>
                            <tr>

                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $row['tanggal'] ?></td>
                                <td><?php echo $row['keterangan'] ?></td>
                                <td><?php if ($row['kategori'] == 'debit') {
                                        echo number_format($row['jumlah']);
                                        $saldo += $row['jumlah'];
                                    }  ?></td>
                                <td><?php if ($row['kategori'] == 'kredit') {
                                        echo number_format($row['jumlah']);
                                        $saldo -= $row['jumlah'];
                                    } ?></td>
                                <td align="right"><?php echo number_format($saldo) ?></td>
                            </tr>
                    <?php
                        }
                    }

                    ?>
                </table>
            </div>
        </div>
    </div>
</div>