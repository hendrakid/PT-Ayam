    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Table Hasil Telur</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Tanggal
                                </th>
                                <th>Total</th>
                                <th>Super</th>
                                <th>Standar</th>
                                <th>MK</th>
                                <th>Bakso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $result = mysqli_query($conn, "SELECT date(tanggal) as tanggal, sum(super) as super,sum(standar)as standar,sum(mk) as mk,sum(bakso) as bakso FROM tbl_hasil group by date(tanggal)
                           ORDER BY tanggal DESC");

                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row["tanggal"] ?></td>
                                        <td><?php echo $row["super"] + $row["standar"] + $row["mk"] + $row["bakso"] ?></td>
                                        <td><?php echo $row["super"] ?></td>
                                        <td><?php echo $row["standar"] ?></td>
                                        <td><?php echo $row["mk"] ?></td>
                                        <td><?php echo $row["bakso"] ?></td>
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