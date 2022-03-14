<?php
$percentageQ = mysqli_query($conn, "SELECT 
    (hasil.super+ hasil.standar+ hasil.mk+ hasil.bakso)/397*100 as percentage 
    ,hasil.tanggal as tanggal
FROM tbl_hasil as hasil 
order by hasil.tanggal desc limit 1;");
$percentage = 0;
$tanggal = "";
if (mysqli_num_rows($percentageQ) > 0) {
    while ($row = mysqli_fetch_assoc($percentageQ)) {
        $percentage = $row['percentage'];
        $tanggal = $row['tanggal'];
        break;
    }
}

$periodeMonth =  date('F');
$periodeYear =  date('Y');
$percentageQMRaw = "select sum(c.hasil)/(397*count(1))*100 as percentageThisMonth 
from 
    (SELECT hasil.super+ hasil.standar+ hasil.mk+ hasil.bakso as hasil FROM tbl_hasil as hasil 
    where  MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "
    ) as c;";
$percentageQM = mysqli_query($conn, $percentageQMRaw);
$percentageThisMonth = 0;
if (mysqli_num_rows($percentageQM) > 0) {
    while ($row = mysqli_fetch_assoc($percentageQM)) {
        $percentageThisMonth = $row['percentageThisMonth'];
        break;
    }
}

// modal perhari Rp.289.460,-
?>

<div class="col-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-body">
            <h6>Persentase Ayam Bertelur <?php echo date_format(date_create($tanggal), "d F") ?> : <b <?php if ($percentage < 70) echo 'style="color: red;"' ?>><?php echo number_format($percentage, 2); ?>%</b></h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h6>Persentase Ayam Bertelur Bulan Ini <?php echo date_format(date_create($periodeMonth), "F") ?> : <b <?php if ($percentageThisMonth < 70) echo 'style="color: red;"' ?>><?php echo number_format($percentageThisMonth, 2); ?>%</b></h6>
        </div>
    </div>
</div>