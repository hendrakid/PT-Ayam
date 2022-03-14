    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Table Harga Telur</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>Kelas</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $hargaHariIni = mysqli_query($conn, "SELECT a.harga, k.nama, a.tanggal FROM tbl_harga as a, 
                            (SELECT harga, kelas_kategori_id, MAX(tanggal) as tanggal FROM tbl_harga group by kelas_kategori_id) as b,
                            tbl_kategori as k
                            where a.tanggal=b.tanggal and a.kelas_kategori_id=b.kelas_kategori_id and k.id=a.kelas_kategori_id  ");
                            // $result = mysqli_query($conn, "SELECT kelas.kelas, harga.harga, harga.tanggal FROM tbl_harga as harga INNER join tbl_kelas as kelas WHERE kelas.id=harga.kelas_id ORDER BY harga.tanggal DESC");

                            if (mysqli_num_rows($hargaHariIni) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($hargaHariIni)) {
                            ?>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td><?php echo $row["nama"] ?></td>
                                        <td class="align-right">
                                            <?php
                                            echo "Rp." . number_format($row["harga"]);
                                            ?>
                                        </td>
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