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


$tanggalMulai = "2022-03-01";

include('./Queries/filter.php');
include('./Queries/getPenjualan.php');
include('./Queries/getpersediaan.php');
include('./Queries/getModal.php');
include('./Queries/getPasiva.php');
include("./Queries/getBeban.php");
include("./Queries/getPrive.php");

/////////////////        PENJUALAN       ///////////////////
{
    $piutang = 0;
    $penjualanDibayar = 0;
    if (mysqli_num_rows($penjualanQuery) > 0) {
        while ($row = mysqli_fetch_assoc($penjualanQuery)) {
            if ($row['status'] == "0") {
                $piutang = $row['jumlah'];
            } else {
                $penjualanDibayar = $row['jumlah'];
            }
        }
    }
    /////////////////        PENJUALAN       /////////////////////////
}
/////////////////        PERSEDIAAN      ////////////////////
{
    $persediaan = 0;
    // if (mysqli_num_rows($persediaanQuery) > 0) {
    //     while ($row = mysqli_fetch_assoc($persediaanQuery)) {
    //         $persediaan = $row['persediaan'];
    //     }
    // }

    /////////////////        PERSEDIAAN       /////////////////////////
}

/////////////////        BEBAN           ////////////////////
{
    $beban = 0;
    if (mysqli_num_rows($bebanQuery) > 0) {
        while ($row = mysqli_fetch_assoc($bebanQuery)) {
            $beban += $row['jumlah'];
            // echo "" . $row['jumlah'];
            // echo "<br/>";
        }
    }
}

/////////////////        MODAL           ////////////////////
{

    $modalDisetor = 0;
    $utangUsaha = 0;
    if (mysqli_num_rows($modalQuery) > 0) {
        while ($row = mysqli_fetch_assoc($modalQuery)) {
            if ($row['kategori'] == 'modal') {
                $modalDisetor = $row['jumlah'];
            } else {
                $utangUsaha = $row['jumlah'];
            }
        }
    }
}

/////////////////        PERALATAN       ////////////////////
{
    $totalAktivaTetap = 0;

    if (mysqli_num_rows($pasivaQuery) > 0) {
        while ($row = mysqli_fetch_assoc($pasivaQuery)) {
            $totalAktivaTetap += $row['jumlah'];
        }
    }
}

/////////////////        AKTIVA TETAP    ////////////////////
{

    $penyusutanKandang = 0;
    $penyusutanAyam = 0;
    $penyusutanPeralatan = 0;
}
/////////////////        PRIVE          ////////////////////
{

    $prive = 0;
    if (mysqli_num_rows($priveQuery) > 0) {
        while ($row = mysqli_fetch_assoc($priveQuery)) {
            $prive = $row['jumlah'];
        }
    }
}

$rugi = 0;
$kas = 0;
$kas += $modalDisetor + $utangUsaha + $penjualanDibayar - $totalAktivaTetap - $prive;
if ($kas < 0) {
    $utangUsaha -= $kas;
    $kas = 0;
}
/////////////////        EKUITAS         ////////////////////
{
    $labaDitahan = $penjualanDibayar - $beban - $prive;
    if ($labaDitahan < 0) {
        $rugi = $labaDitahan * -1;
        // $labaDitahan = 0;
    }
    $totalEkuitas = 0;
    $totalEkuitas += $utangUsaha;
    $totalEkuitas += $modalDisetor;
    $totalEkuitas += $labaDitahan;
    $totalEkuitas += $rugi;
}

/////////////////        AKTIVA LANCAR       ////////////////
{

    $totalActivaLancar = 0;
    $totalActivaLancar += $kas;
    $totalActivaLancar += $piutang;
    $totalActivaLancar += $persediaan;
}


?>

<div class="col-12">
    <div class="card">
        <div class="centerXXX">
            <h6>Laporan Neraca</h6>
            <h6>Periode <?php echo $periodeMonth . ' ' . $periodeYear; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table border=0 class="centerTable">
                    <tr>
                        <td>
                            <table border=0 class="centerTable">
                                <tr>
                                    <td class="titleItem">Activa</td>
                                <tr>
                                    <td class="titleItem">Activa Lancar</td>
                                </tr>
                                <tr>
                                    <td>Kas</td>
                                    <td align="right">Rp.<?php echo number_format($kas, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Piutang</td>
                                    <td align="right">Rp.<?php echo number_format($piutang, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Persediaan</td>
                                    <td align="right">Rp.<?php echo number_format($persediaan, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Jumlah Activa Lancar</td>
                                    <td class="titleItem" align="right">Rp.<?php echo number_format($totalActivaLancar, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Activa Tetap</td>
                                </tr>

                                <?php

                                $pasivaQuery = mysqli_query($conn, " 
                                    SELECT pengeluaran.jumlah, pengeluaran.keterangan from tbl_pengeluaran as pengeluaran, tbl_kategori as kategori
                                    where pengeluaran.pengeluaran_kategori_id=kategori.id
                                    and kategori.nama ='Asset Tetap'");
                                $jumlahAssetTetap = 0;
                                if (mysqli_num_rows($pasivaQuery) > 0) {
                                    while ($row = mysqli_fetch_assoc($pasivaQuery)) {
                                        $jumlahAssetTetap++;
                                ?>
                                        <tr>
                                            <td><?php echo $row['keterangan'] ?></td>
                                            <td align="right">Rp.<?php echo number_format($row['jumlah'], 2, ',', '.'); ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <td>Akumulasi Penyusutan Kandang</td>
                                    <td align="right">(Rp.<?php echo number_format($penyusutanKandang, 2, ',', '.'); ?>)</td>
                                </tr>
                                <tr>
                                    <td>Penyusutan Peralatan</td>
                                    <td align="right">(Rp.<?php echo number_format($penyusutanPeralatan, 2, ',', '.'); ?>)</td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Jumlah Activa Tetap</td>
                                    <td class="titleItem" align="right">Rp.<?php echo number_format($totalAktivaTetap, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Jumlah Activa</td>
                                    <td class="titleItem" align="right">Rp.<?php echo number_format($totalActivaLancar + $totalAktivaTetap, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td valign="top">
                            <table border=0 class="centerTable">
                                <tr>
                                    <td class="titleItem">Kewajiban</td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Kewajiban Lancar</td>
                                </tr>
                                <tr>
                                    <td>Utang Usaha</td>
                                    <td align="right">Rp.<?php echo number_format($utangUsaha, 2, ',', '.'); ?></td>
                                </tr>
                                <?php
                                if ($rugi > 0) {
                                ?>
                                    <tr>
                                        <td>Rugi</td>
                                        <td align="right">Rp.<?php echo number_format($rugi, 2, ',', '.'); ?></td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Ekuitas</td>
                                </tr>
                                <tr>
                                    <td>Modal Disetor</td>
                                    <td align="right">Rp.<?php echo number_format($modalDisetor, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Laba Ditahan</td>
                                    <td align="right">Rp.<?php echo number_format($labaDitahan, 2, ',', '.'); ?></td>
                                </tr>
                                <?php
                                for ($i = 0; $i < $jumlahAssetTetap; $i++) {
                                    echo "<tr>
                                    <td>&nbsp;</td>
                                </tr>";
                                }
                                ?>

                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="titleItem">Jumlah Ekuitas</td>
                                    <td class="titleItem" align="right">Rp.<?php echo number_format($totalEkuitas, 2, ',', '.'); ?></td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>