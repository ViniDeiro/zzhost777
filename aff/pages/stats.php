<?php
session_start();

$user_id = $_SESSION['user_id'] ?? 0;


$invite_code = '';
$queryInvite = "SELECT invite_code FROM usuarios WHERE id = $user_id LIMIT 1";
$resInvite = mysqli_query($mysqli, $queryInvite);
if ($resInvite && mysqli_num_rows($resInvite) > 0) {
    $invite_code = mysqli_fetch_assoc($resInvite)['invite_code'];
}


$cliques = [];
$conversoes = [];
$datas = [];


$queryC = "SELECT DATE(data_cad) as dia, COUNT(*) as total 
           FROM visita_site 
           WHERE inviter = '$invite_code'
           GROUP BY dia 
           ORDER BY dia";
$resC = mysqli_query($mysqli, $queryC);
if ($resC) {
    while ($row = mysqli_fetch_assoc($resC)) {
        $dia = $row['dia'];
        $datas[$dia] = date('d/m', strtotime($dia));
        $cliques[$dia] = (int)$row['total'];
    }
}



ksort($datas);
$labels = [];
$cliquesArr = [];
$conversoesArr = [];

foreach ($datas as $dia => $label) {
    $labels[] = $label;
    $cliquesArr[] = $cliques[$dia] ?? 0;
    $conversoesArr[] = $conversoes[$dia] ?? 0;
}


$deviceCounts = ['Desktop' => 0, 'Mobile' => 0, 'Outros' => 0];
$queryDevices = "SELECT nav_os, mac_os FROM visita_site WHERE inviter = '$invite_code'";
$resDevices = mysqli_query($mysqli, $queryDevices);
if ($resDevices && mysqli_num_rows($resDevices) > 0) {
    while ($rowD = mysqli_fetch_assoc($resDevices)) {
        $cat = classifyDevice($rowD['nav_os'], $rowD['mac_os']);
        $deviceCounts[$cat]++;
    }
}


$statesCount = [];
$queryStates = "SELECT estado, COUNT(*) as cnt
                FROM visita_site
                WHERE inviter = '$invite_code'
                GROUP BY estado";
$resStates = mysqli_query($mysqli, $queryStates);
if ($resStates && mysqli_num_rows($resStates) > 0) {
    while ($rowS = mysqli_fetch_assoc($resStates)) {
        $st = $rowS['estado'] ?: 'N/D';
        $statesCount[$st] = (int)$rowS['cnt'];
    }
}


$jsCliques = json_encode(array_values($cliquesArr));
$jsConversoes = json_encode(array_values($conversoesArr));
$jsDatas = json_encode(array_values($labels));

$jsDeviceLabels = json_encode(array_keys($deviceCounts));
$jsDeviceValues = json_encode(array_values($deviceCounts));

$jsStateLabels = json_encode(array_keys($statesCount));
$jsStateValues = json_encode(array_values($statesCount));

$currentMonth = date('F Y');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Estatísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

<div class="dashboard">
    <nav class="navbar">
        <div class="navbar-left">
            <h1 class="page-title">Estatísticas</h1>
        </div>
        <div class="navbar-right">
        </div>
    </nav>

    <!-- Gráfico Principal -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Visão Geral</h3>
        </div>
        <div class="chart-container" id="mainChart"></div>
    </div>

    <!-- Estatísticas Detalhadas -->
    <div class="grid" style="grid-template-columns: repeat(2, 1fr);">
        <!-- Donut: Dispositivo -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Origem do Tráfego (Dispositivo)</h3>
            </div>
            <div id="trafficChart" style="height: 300px;"></div>
        </div>

        <!-- Barras: Estado -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Visitas por Estado</h3>
            </div>
            <div id="conversionsChart" style="height: 300px;"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cliques = <?php echo $jsCliques; ?>;
    const conversoes = <?php echo $jsConversoes; ?>;
    const datas = <?php echo $jsDatas; ?>;

    const mainChartOptions = {
        series: [{
            name: 'Cliques',
            data: cliques
        }, {
            name: 'Conversões',
            data: conversoes
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
            type: 'category',
            categories: datas
        }
    };
    const mainChart = new ApexCharts(document.querySelector("#mainChart"), mainChartOptions);
    mainChart.render();

    const deviceLabels = <?php echo $jsDeviceLabels; ?>;
    const deviceValues = <?php echo $jsDeviceValues; ?>;

    const trafficChartOptions = {
        series: deviceValues,
        chart: {
            type: 'donut',
            height: 300
        },
        labels: deviceLabels,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }]
    };
    const trafficChart = new ApexCharts(document.querySelector("#trafficChart"), trafficChartOptions);
    trafficChart.render();

    const stateLabels = <?php echo $jsStateLabels; ?>;
    const stateValues = <?php echo $jsStateValues; ?>;

    const conversionsChartOptions = {
        series: [{
            data: stateValues
        }],
        chart: {
            type: 'bar',
            height: 300
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: stateLabels
        }
    };
    const conversionsChart = new ApexCharts(document.querySelector("#conversionsChart"), conversionsChartOptions);
    conversionsChart.render();
});
</script>

</body>
</html>
