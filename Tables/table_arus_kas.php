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

<?php

include('./Queries/filter.php');

?>

<div class="col-12">
    <div class="card">
        <div class="centerXXX">
            <h6>Laporan Arus Kas</h6>
            <h6>Periode <?php echo $periodeMonth . ' ' . $periodeYear; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table border=0 class="centerTable">
                    <tr class="titleItem">
                        <td>Tanggal</td>
                        <td>keterangan</td>
                        <td>Tanggal</td>
                        <td>Tanggal</td>
                        <td>Tanggal</td>
                        <td>Tanggal</td>
                        <td>Tanggal</td>
                    </tr>
                    <tr>
                        <td>Penjualan Bersih</td>
                        <td align="right">Rp.<?php echo number_format($hasil_penjualan, 2, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Pendapatan</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format($total_pendapatan, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="titleItem">
                        <td>Beban</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                    $total_beban = 0;
                    if (mysqli_num_rows($pengeluaranQuery) > 0) {
                        while ($row = mysqli_fetch_assoc($pengeluaranQuery)) {
                            $total_beban += $row['total'];
                    ?>
                            <tr>
                                <td><?php echo $row['kategori_pengeluaran']; ?></td>
                                <td align="right">Rp.<?php echo number_format($row['total'], 2, ',', '.'); ?></td>
                                <td></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Beban</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format($total_beban, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Laba Sebelum Pajak</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format($total_pendapatan - $total_beban, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>Pajak</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format($pajak, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>Laba Bersih</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format(($total_pendapatan - $total_beban - $pajak), 2, ',', '.'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>