<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>Table Pengeluaran</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $result = mysqli_query($conn, "
                        SELECT 
                            pengeluaran.id as id, 
                            date(pengeluaran.tanggal) as tanggal,
                            kategori.nama as kategori, 
                            pengeluaran.keterangan as keterangan, 
                            pengeluaran.jumlah as jumlah
                        FROM tbl_pengeluaran as pengeluaran
                        INNER join tbl_kategori as kategori
                        where kategori.id=pengeluaran.pengeluaran_kategori_id");

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row["kategori"] ?></td>
                                    <td><?php echo number_format($row["jumlah"]) ?></td>
                                    <td><?php echo $row["keterangan"] ?></td>
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