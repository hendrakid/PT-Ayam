<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
<?php

$filter = "";
$isMasking = "false";

if (isset($_GET['filterChart'])) {
    if (($_GET['filterChart']) == 'last7Days') {
        $filter = " where DATE(NOW()) - INTERVAL 7 DAY ";
    } else if (($_GET['filterChart']) == 'thisMonth') {
        $filter = "where MONTH(tanggal)=" . date('m');
        $isMasking = "true";
    }
}
$query      = " SELECT harga, day(tanggal) as tanggal FROM tbl_harga " . $filter . "  group by date(tanggal) order by tanggal";
$hargaButir = mysqli_query($conn, $query);

?>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>Chart Harga Telur</h4>
            <a href="?page=harga_telur&filterChart=last7Days" class="btn btn-success">7 Hari Terakhir</a>
            <a href="?page=harga_telur&filterChart=thisMonth" class="btn btn-primary">Bulan Ini</a>
        </div>
        <div class="card-body">
            <canvas id="hargaTelurChart"></canvas>
        </div>
    </div>
</div>
<!-- JS Libraies -->
<script src="assets/bundles/chartjs/chart.min.js"></script>
<?php

if (mysqli_num_rows($hargaButir) > 0) {
    while ($b = mysqli_fetch_array($hargaButir)) {
        $hargaButirArray[] = $b['tanggal'] . "|" . $b['harga'];
    }
} else {
    $hargaButirArray[] = '0|0';
}
?>

<script>
    var totalDays = getDaysInMonth(new Date().getMonth() + 1, 2022);

    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    };

    var isMasking = <?php echo "" . $isMasking; ?>;

    var dataButir = maskingByDate(totalDays, <?php echo json_encode($hargaButirArray) ?>, isMasking);

    var days = [];
    for (let i = 1; i <= totalDays; i++) {
        days.push(i);
    }

    if (!isMasking) {
        days = [];
        <?php echo json_encode($hargaButirArray) ?>.forEach(element => {
            days.push(element.split("|")[0]);
        });
    }
    var ctx = document.getElementById("hargaTelurChart");
    if (ctx) {
        ctx.height = 150;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: "Butir",
                    borderColor: "rgba(0,0,0,.5)",
                    borderWidth: "1.5",
                    backgroundColor: "rgba(100, 255, 255, 0.3)",
                    data: dataButir
                }]
            },
            options: {
                legend: {
                    position: 'top',
                    labels: {}

                },
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: "#9aa0ac", // Font Color
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: "#9aa0ac", // Font Color
                        }
                    }]
                }

            }
        });
    }



    function masking(months, data) {
        var maskedData = [];
        var latestValue;
        var monthNow = (new Date()).getMonth();

        months.forEach((month, index) => {
            var yy = data.find(element => element.split("|")[0] == month);
            if (yy !== undefined) {
                maskedData.push(parseInt(yy.split("|")[1]));
                latestValue = parseInt(yy.split("|")[1]);
            } else {
                if (index <= monthNow && latestValue !== undefined)
                    maskedData.push(latestValue);
                else
                    maskedData.push(0);
            }

        });
        return maskedData;
    }

    function maskingByDate(totalDays, data, isMasking = true) {
        var maskedData = [];
        var latestValue;
        var dateNow = (new Date()).getDate();
        if (isMasking) {
            for (let i = 1; i <= totalDays; i++) {
                var yy = data.find(element => element.toString().split("|")[0] == i);
                if (yy !== undefined) {
                    maskedData.push(parseInt(yy.split("|")[1]));
                    latestValue = parseInt(yy.split("|")[1]);
                } else {
                    if (i <= dateNow && latestValue !== undefined)
                        maskedData.push(latestValue);
                    else
                        maskedData.push(0);
                }
            }
        } else {
            data.forEach(element => {
                maskedData.push(element.split("|")[1]);
            });
        }
        return maskedData;
    }
</script>