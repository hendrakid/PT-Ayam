<?php



$kasSisaQuery = mysqli_query($conn, "
SELECT sum(kas.jumlah) as sisa from (
    SELECT modal.jumlah as jumlah,
        'debit' as kategori,
        modal.tanggal as tanggal,
        modal.keterangan as keterangan
        from tbl_modal as modal
    UNION
    SELECT pengeluaran.jumlah*-1 as jumlah, 
        'kredit' as kategori, 
        pengeluaran.tanggal as tanggal, 
        concat(tbl_kategori.nama,' : ',pengeluaran.keterangan)  as keterangan
    FROM tbl_pengeluaran as pengeluaran, tbl_kategori 
    WHERE pengeluaran.pengeluaran_kategori_id = tbl_kategori.id
    union 
    SELECT 
        penjualan.jumlah*kategori.keterangan*penjualan.harga as jumlah, 
        'debit' as kategori, 
        penjualan.tanggal as tanggal, 
        CONCAT('Penjualan ',penjualan.nama_customer,' ',penjualan.jumlah,' ',kategori.nama) 
    from tbl_penjualan as penjualan, tbl_kategori as kategori 
    WHERE penjualan.satuan_kategori_id = kategori.id and penjualan.dibayar=1) as kas  ");

$disabled = "";
$kasSisa = 0;
if (mysqli_num_rows($kasSisaQuery) > 0) {
    while ($row = mysqli_fetch_assoc($kasSisaQuery)) {
        if ($row['sisa'] <= 0) {
            $disabled = "disabled";
        } else {
            $kasSisa = $row['sisa'];
        }
    }
}
?>
<style>
    .white-text {
        color: white;
    }
</style>

<div class="col-12 col-md-6 col-lg-6">
    <form method="post" onsubmit="return validateForm()" name="form_pengeluaran" enctype="multipart/form-data" action="actionForm/save_form_pengeluaran.php">
        <div class="card">
            <div class="card-header">
                <h4>Form Pengeluaran</h4>
                <?php if ($disabled != "") {
                    echo "<b class='btn btn-danger white-text'>Kas Kosong!!! </b>";
                } ?>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kategori</label>
                    <select <?php echo $disabled; ?> required class="form-control" name="kelas_id">

                        <option value="">Pilih Kategori</option>
                        <?php

                        $sql = "SELECT id, nama FROM tbl_kategori where kategori='Pengeluaran'";
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

                    <label>Total</label>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            Rp.
                        </div>
                        <input <?php echo $disabled; ?> required type="text" id="total" name="total" class="form-control" onkeyup="customCurrency(this)">
                    </div>
                    <div id="keterangan">
                        <label>Keterangan</label>
                        <input <?php echo $disabled; ?> required type="text" name="keterangan" class="form-control">
                    </div>
                    <label>Date Picker</label>
                    <div class="input-group">
                        <input type="text" name="tanggal" class="form-control datepicker">
                    </div>
                </div>
                <div class=" buttons">
                    <input <?php echo $disabled; ?> class="btn btn-primary" type="submit" name="save" value="Simpan">
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function validateForm() {
        var kasSisa = <?php echo $kasSisa; ?>;
        let x = document.forms["form_pengeluaran"]["total"].value.replace(',', '');
        if (x > kasSisa) {
            alert("Kas Kurang");
            return false;
        }
    }
</script>