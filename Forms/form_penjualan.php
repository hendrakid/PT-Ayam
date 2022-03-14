<div class="col-12 col-md-6 col-lg-6">
    <form method="post" name="form_penjualan" enctype="multipart/form-data" action="actionForm/save_form_penjualan.php">
        <div class="card">
            <div class="card-header">
                <h4>Form Penjualan</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <div class="input-group">
                        <input required type="text" name="nama_pembeli" class="form-control">
                    </div>
                    <label>Kelas</label>
                    <select required class="form-control" id="kelas_id" name="kelas_id">

                        <option value="">Pilih Kelas</option>
                        <?php

                        $sql = "SELECT id, nama FROM tbl_kategori where kategori='Kelas'";
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
                    <label class="form-label">Satuan </label>
                    <div class="selectgroup w-100">
                        <?php
                        $sql = "SELECT id, nama, keterangan FROM tbl_kategori where kategori='Satuan' order by id asc";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $satuanArray[]  = $row['id'] . "|" . $row['keterangan'];
                        ?>
                                <label class="selectgroup-item">
                                    <input onchange="getTotal()" type="radio" id="satuan_id" name="satuan_id" value="<?php echo $row['id'] ?>" class="selectgroup-input-radio" <?php if ($row['nama'] == 'Ikat') echo "checked" ?>>
                                    <span class="selectgroup-button"><?php echo $row['nama'] ?></span>
                                </label>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <label>Jumlah</label>
                    <div class="input-group">
                        <input required type="number" id="jumlah" name="jumlah" class="form-control" onkeyup="getTotal()">
                    </div>

                    <label>Harga Jual(Papan)</label>
                    <div class="input-group">
                        <input required type="text" id="harga" name="harga" class="form-control" onkeyup="getTotal()">
                    </div>
                    <label>Total Penjualan</label>
                    <div class="input-group">
                        <input disabled type="text" id="total" class="form-control">
                    </div>
                    <label>Date Picker</label>
                    <div class="input-group">
                        <input type="text" name="tanggal" class="form-control datepicker">
                    </div>

                    <div class="input-group">
                        <label class="custom-switch mt-3">
                            <input type="checkbox" name="dibayar" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Sudah dibayar</span>
                        </label>
                    </div>
                </div>
                <div class=" buttons">
                    <input class="btn btn-primary" type="submit" name="save" value="Simpan">
                </div>
            </div>
        </div>
    </form>
</div>

<?php
// $hargaHariIni = mysqli_query($conn, "SELECT a.id, a.harga, a.kelas_kategori_id FROM tbl_harga as a, (SELECT harga, kelas_kategori_id, MAX(tanggal) as tanggal FROM tbl_harga group by kelas_kategori_id) as b where a.tanggal=b.tanggal and a.kelas_kategori_id=b.kelas_kategori_id");

// while ($b = mysqli_fetch_array($hargaHariIni)) {
//     $hargaArray[] = $b['kelas_kategori_id'] . "|" . $b['harga'] . "|" . $b['id'];
// }
?>

<script type="text/javascript">
    function getTotal() {
        document.getElementById("harga").value = document.getElementById("harga").value.replaceAll(",", "").toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var harga = document.getElementById("harga").value.replaceAll(",", "");
        var jumlah = document.getElementById("jumlah").value;
        var satuanArray = <?php echo json_encode($satuanArray); ?>;
        var butir = satuanArray.find(p => p.toString().split("|")[0] == document.querySelector('input[name="satuan_id"]:checked').value).split("|")[1];
        var total = 0;
        total = parseInt(harga * parseFloat(butir) * jumlah / 30);
        document.getElementById("total").value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return;
    }
</script>