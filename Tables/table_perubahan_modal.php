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


$periodeMonth =  date('F');
$periodeYear =  date('Y');
$filter = " and MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "";

if (isset($_GET['periode'])) {
    if (($_GET['periode']) == "AllTheTime") {
    }
    if (($_GET['periode']) == "ThisYear") {
        $filter = " and YEAR(tanggal)=" . $periodeYear . "";
    }
    if (($_GET['periode']) == "ThisMonth") {
        $filter = " and MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "";
    } else {
        $periodeMonth = explode("_", ($_GET['periode']))[0];
        $periodeYear = explode("_", ($_GET['periode']))[1];
        $filter = " and MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "";
    }
}
$modalAwal = 100000000;
$labaBersih = 0;
$prive = 0;

$penjualanQuery = mysqli_query($conn, "SELECT SUM(penjualan.harga*kategori.keterangan/10) as hasil_penjualan 
            FROM tbl_penjualan penjualan, tbl_kategori as kategori 
            WHERE kategori.id=penjualan.satuan_kategori_id 
            " . $filter . "");

if (mysqli_num_rows($penjualanQuery) > 0) {
    while ($row = mysqli_fetch_assoc($penjualanQuery)) {
        $labaBersih += $row['hasil_penjualan'];
    }
}

$bebanQuery = mysqli_query($conn, "SELECT sum(pengeluaran.jumlah) as total
            FROM tbl_pengeluaran pengeluaran WHERE pengeluaran.id=pengeluaran.id 
            " . $filter . "");

if (mysqli_num_rows($bebanQuery) > 0) {
    while ($row = mysqli_fetch_assoc($bebanQuery)) {
        $labaBersih -= $row['total'];
    }
}

$priveQuery = mysqli_query($conn, "SELECT sum(pengeluaran.jumlah) as total
            FROM tbl_pengeluaran pengeluaran, tbl_kategori kategori WHERE kategori.id=pengeluaran.pengeluaran_kategori_id 
            and kategori.nama='Prive'
            " . $filter . "");

if (mysqli_num_rows($priveQuery) > 0) {
    while ($row = mysqli_fetch_assoc($priveQuery)) {
        $prive += $row['total'];
    }
}


?>

<div class="col-12">
    <div class="card">
        <div class="centerXXX">
            <h6>Laporan Perubahan Modal</h6>
            <h6>Periode <?php echo $periodeMonth . ' ' . $periodeYear; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table border=0 class="centerTable">
                    <tr>
                        <td class="titleItem">Modal Awal</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format($modalAwal, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>Laba Bersih</td>
                        <td align="right">Rp.<?php echo number_format($labaBersih, 2, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Prive</td>
                        <td align="right">Rp.<?php echo number_format($prive, 2, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Penambahan Modal</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format(0000, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>Modal Akhir Period</td>
                        <td></td>
                        <td align="right">Rp.<?php echo number_format(($modalAwal + $labaBersih) - $prive, 2, ',', '.'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>