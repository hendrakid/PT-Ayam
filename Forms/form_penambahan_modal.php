<div class="col-12 col-md-6 col-lg-6">
    <form method="post" name="form_penambahan_modal" enctype="multipart/form-data" action="actionForm/save_form_penambahan_modal.php">
        <div class="card">
            <div class="card-header">
                <h4>Form Penambahan Modal</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control " required id="kategori_id" name="kategori_id">

                        <option value="">Pilih Kategori</option>
                        <?php

                        $sql = "SELECT id, nama FROM tbl_kategori where kategori='PenambahanModal'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <option value="<?php echo $row["id"] ?>"><?php echo $row["nama"] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <label>Jumlah</label>
                    <div class="input-group">
                        <input required type="text" id="jumlah" name="jumlah" class="form-control" onkeyup="customCurrency(this)">
                    </div>
                    <label>Keterangan</label>
                    <div class="input-group">
                        <input required type="text" name="keterangan" class="form-control">
                    </div>
                    <label>Date Picker</label>
                    <div class="input-group">
                        <input type="text" name="tanggal" class="form-control datepicker">
                    </div>
                </div>
                <div class=" buttons">
                    <input class="btn btn-primary" type="submit" name="save" value="Simpan">
                </div>
            </div>
        </div>
    </form>
</div>