<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>Table Penjualan</h4>
            <div>
                <?php
                $belumBayar = mysqli_query($conn, "SELECT count(dibayar) as belumBayar from tbl_penjualan where dibayar=0 ");
                if (mysqli_num_rows($belumBayar) > 0) {
                    while ($row = mysqli_fetch_assoc($belumBayar)) {
                        if ($row['belumBayar'] == 0)
                            break;
                ?>
                        <a href="?page=table_penjualan&filterTable=sudahBayar" class="btn btn-success">Sudah Bayar</a>
                        <a href="?page=table_penjualan&filterTable=belumBayar" class="btn btn-danger"><?php echo $row['belumBayar'] ?> Belum Dibayar</a>
                        <a href="?page=table_penjualan" class="btn btn-primary">Semua</a>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="card-bodyx">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Dibayar</th>
                            <th>Satuan</th>
                            <th>Kelas</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php


                            $filter = "";
                            if (isset($_GET['filterTable'])) {
                                if (($_GET['filterTable']) == 'belumBayar') {
                                    $filter = " and penjualan.dibayar=0 ";
                                } else if (($_GET['filterTable']) == 'sudahBayar') {
                                    $filter = " and penjualan.dibayar=1 ";
                                }
                            }

                            $result = mysqli_query($conn, "
                        SELECT 
                            penjualan.id as id, 
                            date(penjualan.tanggal) as tanggal,
                            penjualan.nama_customer as customer, 
                            satuan.nama as satuan, 
                            kelas.nama as kelas, 
                            penjualan.harga as harga, 
                            penjualan.jumlah as jumlah,
                            ROUND(satuan.keterangan*penjualan.harga/30*jumlah ,0) as total, 
                            penjualan.dibayar as dibayar
                        FROM tbl_penjualan as penjualan
                        INNER join tbl_kategori as satuan
                        INNER join tbl_kategori as kelas
                        where satuan.id=penjualan.satuan_kategori_id 
                        and kelas.id=penjualan.kelas_kategori_id " . $filter);

                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <td><?php echo $row["customer"] ?></td>
                                    <td><?php echo number_format($row["total"]); ?></td>

                                    <td>
                                        <?php
                                        $dibayar = $row["dibayar"];
                                        if ($dibayar == 0) {
                                            $dataToPass = $row["id"] . '|' . $row["customer"] . '|Rp.' . number_format($row["total"]);
                                        ?>
                                            <a onclick="bayar('<?php echo $dataToPass; ?>');" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-danger">Belum bayar</a>
                                        <?php
                                        } else {
                                            echo  '<a class="btn btn-success">Sudah bayar</a>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row["satuan"] ?></td>
                                    <td><?php echo $row["kelas"] ?></td>
                                    <td><?php echo number_format($row["harga"]) ?></td>
                                    <td><?php echo $row["jumlah"] ?></td>
                                    <td><?php echo $row["tanggal"] ?></td>
                        </tr>
                <?php
                                }
                            }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var penjualanIdToPay = "";

    function bayar(data) {
        document.getElementById('proccedPaymentData').innerHTML = "Lunasi Pembelian <b>" + data.split("|")[1] + "</b> Total Bayar : " + data.split("|")[2];
        document.getElementById("proccedPaymentId").value = data.split("|")[0];
    }
</script>