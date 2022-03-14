<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
<?php
$month = date("M");

$hasilTelur = mysqli_query($conn, "SELECT day(tanggal) as tanggal, sum(super) as super,sum(standar)as standar,sum(mk) as mk,sum(bakso) as bakso FROM tbl_hasil group by date(tanggal) order by tanggal");

?>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4>Chart Hasil Telur</h4>
        </div>
        <div class="card-body">
            <canvas id="hargaTelurChart"></canvas>
        </div>
    </div>
</div>
<!-- JS Libraies -->
<script src="assets/bundles/chartjs/chart.min.js"></script>
<?php

if (mysqli_num_rows($hasilTelur) > 0) {
    while ($b = mysqli_fetch_array($hasilTelur)) {
        $hasilSuperArray[] = $b['tanggal'] . "|" . $b['super'];
        $hasilStandarArray[] = $b['tanggal'] . "|" . $b['standar'];
        $hasilMKArray[] = $b['tanggal'] . "|" . $b['mk'];
        $hasilBaksoArray[] = $b['tanggal'] . "|" . $b['bakso'];
    }
} else {
    $hasilSuperArray[] = "0|0";
    $hasilStandarArray[] = "0|0";
    $hasilMKArray[] = "0|0";
    $hasilBaksoArray[] = "0|0";
}
?>

<script>
    var totalDays = getDaysInMonth(new Date().getMonth() + 1, 2022);

    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    };

    var days = [];
    for (let i = 1; i <= totalDays; i++) {
        days.push(i);

    }

    function masking(totalDays, data) {
        var maskedData = [];
        var latestValue;
        var monthNow = (new Date()).getMonth();

        for (let i = 1; i <= totalDays; i++) {
            var yy = data.find(element => element.split("|")[0] == i);
            if (yy !== undefined) {
                maskedData.push(parseInt(yy.split("|")[1]));
            } else {
                maskedData.push(0);
            }
        }
        return maskedData;
    }


    var dataSuper = masking(totalDays, <?php echo json_encode($hasilSuperArray) ?>);
    var dataStandar = masking(totalDays, <?php echo json_encode($hasilStandarArray) ?>);
    var dataMK = masking(totalDays, <?php echo json_encode($hasilMKArray) ?>);
    var dataBakso = masking(totalDays, <?php echo json_encode($hasilBaksoArray) ?>);

    var ctx = document.getElementById("hargaTelurChart");
    if (ctx) {
        ctx.height = 150;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: "Super",
                    borderColor: "rgba(0,0,0,.5)",
                    borderWidth: "1.5",
                    backgroundColor: "rgba(255,0,255,.3)",
                    data: dataSuper
                }, {
                    label: "Standar",
                    borderColor: "rgba(0,0,0,.5)",
                    borderWidth: "1.5",
                    backgroundColor: "rgba(0,255,0,.3)",
                    data: dataStandar
                }, {
                    label: "MK",
                    borderColor: "rgba(0,0,0,.5)",
                    borderWidth: "1.5",
                    backgroundColor: "rgba(0,0,255,.3)",
                    data: dataMK
                }, {
                    label: "Bakso",
                    borderColor: "rgba(0,0,0,.5)",
                    borderWidth: "1.5",
                    backgroundColor: "rgba(0, 255, 255, 0.3)",
                    data: dataBakso
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
</script>