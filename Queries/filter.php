<?php
$periodeMonth =  date('F');
$periodeYear =  date('Y');
$filter = " and MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "";

if (isset($_GET['periode'])) {
    if (($_GET['periode']) == "AllTheTime") {
        $filter="";
    }
    if (($_GET['periode']) == "ThisYear") {
        $filter = " and YEAR(tanggal)=" . $periodeYear . "";
    }
    if (($_GET['periode']) == "ThisMonth") {
        $filter = " and MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "";
    } else {
        $periodeMonth = explode("_", ($_GET['periode']))[0];
        $periodeYear = explode("_", ($_GET['periode']))[1];
        $filter = " and MONTHNAME(tanggal)='" . $periodeMonth . "' and YEAR(tanggal)=" . $periodeYear . "";
    }
}

?> 