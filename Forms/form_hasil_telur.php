<div class="col-12 col-md-6 col-lg-6">
    <form method="post" name="form_hasil" enctype="multipart/form-data" action="actionForm/save_form_hasil.php">
        <div class="card">
            <div class="card-header">
                <h4>Form Hasil Telur</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Super</label>
                    <div class="input-group">
                        <input required type="number" name="super" class="form-control">
                    </div>
                    <label>Standar</label>
                    <div class="input-group">
                        <input required type="number" name="standar" class="form-control">
                    </div>
                    <label>MK</label>
                    <div class="input-group">
                        <input required type="number" name="mk" class="form-control">
                    </div>
                    <label>Bakso</label>
                    <div class="input-group">
                        <input required type="number" name="bakso" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date Picker</label>
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