<div class="col-12 col-md-6 col-lg-6">
    <form method="post" name="form_harga" enctype="multipart/form-data" action="actionForm/save_form_harga.php">
        <div class="card">
            <div class="card-header">
                <h4>Form Harga Telur</h4>
            </div>
            <div class="card-body">

                <!-- <div class="form-group">
                    <label>Kelas</label>
                    <select class="form-control" name="kelas_id">

                        <option value="Pilih Kelas">Pilih Kelas</option>
                        <?php

                        $sql = "SELECT id, nama FROM tbl_kategori where /*kategori='Kelas' or*/ kategori='KelasKhusus'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <option value="<?php echo $row["id"] ?>"><?php echo $row["nama"] ?></option>
                        <?php
                            }
                        }

                        ?>
                    </select>
                </div> -->
                <div class="form-group">
                    <label>Harga Per Butir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                Rp.
                            </div>
                        </div>
                        <input hidden type="text" id="kelas_id" name="kelas_id" value="idKelasKhusus1">
                        <input required type="text" id="harga1" name="harga" class="form-control" onkeyup="customCurrency(this)">
                    </div>
                </div>
                <div class=" buttons">
                    <input class="btn btn-primary" type="submit" name="save" value="Simpan">
                </div>
            </div>
        </div>
    </form>
</div>