<?php
    require_once 'ServerFunctions.php';
    $varLine = $_REQUEST['varLine'];
    $varMonth = $_REQUEST['varMonth'];
    $varYear = $_REQUEST['varYear'];
    $varMesStr = listarMeses();
    
    $dailyOEE = oeeDiarioGrafica($varLine, $varMonth);
    $monthOEE = oeeMensualGrafica($varLine);
    $oee;
    $monthlyOEE;
    $calidad;
    $monthlyCalidad;
    $organizacional;
    $monthlyOrganizacional;
    $tecnica;
    $monthlyTecnica;
    $cambios;
    $monthlyCambios;
    $desempeno;
    $monthlyDesempeno;
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) { /*OEE Percent*/
        $oee[$i] = 0;
    }
    if (count($dailyOEE) > 0) {
        for ($i = 0; $i < count($dailyOEE); $i++) {
            $oee[$dailyOEE[$i][0] - 1] = $dailyOEE[$i][1];
            $oee[$i] = str_replace('%', '', $oee[$i]);
        }
    }
    for ($i = 0; $i < 12; $i++) { /*OEE Monthly Percent*/
        $monthlyOEE[$i] = 0;
    }
    if (count($monthOEE) > 0) {
        for ($i = 0; $i < count($monthOEE); $i++) {
            $monthlyOEE[$monthOEE[$i][0] - 1] = $monthOEE[$i][1];
        }
    }
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) { /*Quality Percent*/
        $calidad[$i] = 0;
    }
    if (count($dailyOEE) > 0) {
        for ($i = 0; $i < count($dailyOEE); $i++) {
            $calidad[$dailyOEE[$i][0] - 1] = $dailyOEE[$i][2];
            $calidad[$i] = str_replace('%', '', $calidad[$i]);
        }
    }
    for ($i = 0; $i < 12; $i++) { /*Quality Monthly Percent*/
        $monthlyCalidad[$i] = 0;
    }
    if (count($monthOEE) > 0) {
        for ($i = 0; $i < count($monthOEE); $i++) {
            $monthlyCalidad[$monthOEE[$i][0] - 1] = $monthOEE[$i][2];
        }
    }
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) { /*Organizational Percent*/
        $organizacional[$i] = 0;
    }
    if (count($dailyOEE) > 0) {
        for ($i = 0; $i < count($dailyOEE); $i++) {
            $organizacional[$dailyOEE[$i][0] - 1] = $dailyOEE[$i][3];
            $organizacional[$i] = str_replace('%', '', $organizacional[$i]);
        }
    }
    for ($i = 0; $i < 12; $i++) { /*Organizational Monthly Percent*/
        $monthlyOrganizacional[$i] = 0;
    }
    if (count($monthOEE) > 0) {
        for ($i = 0; $i < count($monthOEE); $i++) {
            $monthlyOrganizacional[$monthOEE[$i][0] - 1] = $monthOEE[$i][3];
        }
    }
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) { /*Technical Percent*/
        $tecnica[$i] = 0;
    }
    if (count($dailyOEE) > 0) {
        for ($i = 0; $i < count($dailyOEE); $i++) {
            $tecnica[$dailyOEE[$i][0] - 1] = $dailyOEE[$i][4];
            $tecnica[$i] = str_replace('%', '', $tecnica[$i]);
        }
    }
    for ($i = 0; $i < 12; $i++) { /*Technical Monthly Percent*/
        $monthlyTecnica[$i] = 0;
    }
    if (count($monthOEE) > 0) {
        for ($i = 0; $i < count($monthOEE); $i++) {
            $monthlyTecnica[$monthOEE[$i][0] - 1] = $monthOEE[$i][4];
        }
    }
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) { /*Changeover Percent*/
        $cambios[$i] = 0;
    }
    if (count($dailyOEE) > 0) {
        for ($i = 0; $i < count($dailyOEE); $i++) {
            $cambios[$dailyOEE[$i][0] - 1] = $dailyOEE[$i][5];
            $cambios[$i] = str_replace('%', '', $cambios[$i]);
        }
    }
    for ($i = 0; $i < 12; $i++) { /*Changeover Monthly Percent*/
        $monthlyCambios[$i] = 0;
    }
    if (count($monthOEE) > 0) {
        for ($i = 0; $i < count($monthOEE); $i++) {
            $monthlyCambios[$monthOEE[$i][0] - 1] = $monthOEE[$i][5];
        }
    }
    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) { /*Performance Percent*/
        $desempeno[$i] = 0;
    }
    if (count($dailyOEE) > 0) {
        for ($i = 0; $i < count($dailyOEE); $i++) {
            $desempeno[$dailyOEE[$i][0] - 1] = $dailyOEE[$i][6];
            $desempeno[$i] = str_replace('%', '', $desempeno[$i]);
        }
    }
    for ($i = 0; $i < 12; $i++) { /*Performance Monthly Percent*/
        $monthlyDesempeno[$i] = 0;
    }
    if (count($monthOEE) > 0) {
        for ($i = 0; $i < count($monthOEE); $i++) {
            $monthlyDesempeno[$monthOEE[$i][0] - 1] = $monthOEE[$i][6];
        }
    }
?>
<html>
    <head>
        <!-- HOJA DE ESTILOS-->
        <link rel="stylesheet" href="css/style.css">

        <script src="https://code.highcharts.com/highcharts.js"></script>
    </head>

    <body>
        <h2 align=center id="titulos">
            Gr&aacute;fica de Seguimiento Diario a OEE
            <br>
            <?php echo "Linea: ".$varLine?>
            <br>
            <?php echo "Mes: ".$varMesStr[$varMonth - 1]?>
        </h2>

        <div id="graficaMensualSemanal">
            <table border="1"> <!-- Gráfica mensual/semanal -->
                <tbody>
                    <tr>
                        <td> <!-- Gráfica mensual -->
                            <div id="graficaOEEMensual" class="oeeMensual">
                                <script>
                                    Highcharts.chart('graficaOEEMensual', {
                                        chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            text: 'OEE con Factores de Pérdidas - Mensual'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: ['J', 'F', 'M', 'A', 'M',
                                                'J', 'J', 'A', 'S', 'O', 'N', 'D']
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: 'Porcentaje'
                                            }
                                        },
                                        tooltip: {
                                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                                            shared: true
                                        },
                                        plotOptions: {
                                            column: {
                                                stacking: 'percent'
                                            }
                                        },
                                        series: [{
                                                color: '#9E9E9E',
                                                name: 'Desempeño',
                                                data: [
                                                    <?php
                                                    for ($i = 0; $i < count($monthlyDesempeno); $i++) {
                                                        echo $monthlyDesempeno[$i] . ',';
                                                    }
                                                    ?>
                                                ]
                                            }, {
                                                color: '#3498db',
                                                name: 'Cambios',
                                                data: [
                                                    <?php
                                                    for ($i = 0; $i < count($monthlyCambios); $i++) {
                                                        echo $monthlyCambios[$i] . ',';
                                                    }
                                                    ?>
                                                ]
                                            }, {
                                                color: '#311B92',
                                                name: 'Tecnicas',
                                                data: [
                                                    <?php
                                                    for ($i = 0; $i < count($monthlyTecnica); $i++) {
                                                        echo $monthlyTecnica[$i] . ',';
                                                    }
                                                    ?>
                                                ]
                                            }, {
                                                color: '#F06292',
                                                name: 'Organizacionales',
                                                data: [
                                                    <?php
                                                    for ($i = 0; $i < count($monthlyOrganizacional); $i++) {
                                                        echo $monthlyOrganizacional[$i] . ',';
                                                    }
                                                    ?>
                                                ]
                                            }, {
                                                color: '#B71C1C',
                                                name: 'Calidad',
                                                data: [
                                                    <?php
                                                    for ($i = 0; $i < count($monthlyCalidad); $i++) {
                                                        echo $monthlyCalidad[$i] . ',';
                                                    }
                                                    ?>
                                                ]
                                            }, {
                                                color: '#2ecc71',
                                                name: 'OEE',
                                                data: [
                                                    <?php
                                                        for ($i = 0; $i < count($monthlyOEE); $i++) {
                                                            echo $monthlyOEE[$i].',';
                                                        }
                                                    ?>
                                                ]
                                            }, {
                                                color: '#2ECC71',
                                                type: 'spline',
                                                name: 'Target',
                                                data: [30, 20.67, 30, 60.33, 30.33, 20.67, 30, 60.33, 30.33, 50, 40, 80],
                                                marker: {
                                                    lineWidth: 1,
                                                    lineColor: '#2ECC71',
                                                    fillColor: '#2ECC71'
                                                }
                                            }]
                                    });
                                </script>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td> <!-- Gráfica semanal -->
                            <div id="graficaOEESemanal" class="oeeSemanal">
                                <script>
                                    Highcharts.chart('graficaOEESemanal', {
                                        chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            text: 'OEE con Factores de Pérdidas - Semanal'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: [
                                                <?php
                                                for ($i = 7; $i <= 31; $i += 6) {
                                                    $time = $varYear . "-" . $varMonth . "-" . $i;
                                                    echo date("W", strtotime($time)) . ",";
                                                }
                                                ?>
                                            ]
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: 'Porcentaje'
                                            }
                                        },
                                        tooltip: {
                                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                                            shared: true
                                        },
                                        plotOptions: {
                                            column: {
                                                stacking: 'percent'
                                            }
                                        },
                                        series: [{
                                                color: '#9E9E9E',
                                                name: 'Desempeño',
                                                data: [
                                                    <?php
                                                        $notZero = 0;
                                                        $desempenoAux = 0;
                                                        for ($i = 0; $i < 8; $i++) {
                                                            if ($desempeno[$i] > 0) {
                                                                $desempenoAux += $desempeno[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $desempenoAux = 0;
                                                        for ($i = 8; $i < 15; $i++) {
                                                            if ($desempeno[$i] > 0) {
                                                                $desempenoAux += $desempeno[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $desempenoAux = 0;
                                                        for ($i = 15; $i < 22; $i++) {
                                                            if ($desempeno[$i] > 0) {
                                                                $desempenoAux += $desempeno[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $desempenoAux = 0;
                                                        for ($i = 22; $i < 29; $i++) {
                                                            if ($desempeno[$i] > 0) {
                                                                $desempenoAux += $desempeno[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $desempenoAux = 0;
                                                        for ($i = 29; $i < count($organizacional); $i++) {
                                                            if ($desempeno[$i] > 0) {
                                                                $desempenoAux += $desempeno[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0);
                                                        ?>  
                                                ]
                                            }, {
                                                color: '#3498db',
                                                name: 'Cambios',
                                                data: [
                                                    <?php
                                                        $notZero = 0;
                                                        $cambiosAux = 0;
                                                        for ($i = 0; $i < 8; $i++) {
                                                            if ($cambios[$i] > 0) {
                                                                $cambiosAux += $cambios[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $cambiosAux = 0;
                                                        for ($i = 8; $i < 15; $i++) {
                                                            if ($cambios[$i] > 0) {
                                                                $cambiosAux += $cambios[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $cambiosAux = 0;
                                                        for ($i = 15; $i < 22; $i++) {
                                                            if ($cambios[$i] > 0) {
                                                                $cambiosAux += $cambios[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $cambiosAux = 0;
                                                        for ($i = 22; $i < 29; $i++) {
                                                            if ($cambios[$i] > 0) {
                                                                $cambiosAux += $cambios[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $cambiosAux = 0;
                                                        for ($i = 29; $i < count($organizacional); $i++) {
                                                            if ($cambios[$i] > 0) {
                                                                $cambiosAux += $cambios[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0);
                                                        ?>
                                                ]
                                            }, {
                                                color: '#311B92',
                                                name: 'Tecnicas',
                                                data: [
                                                    <?php
                                                        $notZero = 0;
                                                        $tecnicaAux = 0;
                                                        for ($i = 0; $i < 8; $i++) {
                                                            if ($tecnica[$i] > 0) {
                                                                $tecnicaAux += $tecnica[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $tecnicaAux = 0;
                                                        for ($i = 8; $i < 15; $i++) {
                                                            if ($tecnica[$i] > 0) {
                                                                $tecnicaAux += $tecnica[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $tecnicaAux = 0;
                                                        for ($i = 15; $i < 22; $i++) {
                                                            if ($tecnica[$i] > 0) {
                                                                $tecnicaAux += $tecnica[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $tecnicaAux = 0;
                                                        for ($i = 22; $i < 29; $i++) {
                                                            if ($tecnica[$i] > 0) {
                                                                $tecnicaAux += $tecnica[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $tecnicaAux = 0;
                                                        for ($i = 29; $i < count($organizacional); $i++) {
                                                            if ($tecnica[$i] > 0) {
                                                                $tecnicaAux += $tecnica[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0);
                                                        ?>
                                                ]
                                            }, {
                                                color: '#F06292',
                                                name: 'Organizacionales',
                                                data: [
                                                    <?php
                                                        $notZero = 0;
                                                        $organizacionalAux = 0;
                                                        for ($i = 0; $i < 8; $i++) {
                                                            if ($organizacional[$i] > 0) {
                                                                $organizacionalAux += $organizacional[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $organizacionalAux = 0;
                                                        for ($i = 8; $i < 15; $i++) {
                                                            if ($organizacional[$i] > 0) {
                                                                $organizacionalAux += $organizacional[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $organizacionalAux = 0;
                                                        for ($i = 15; $i < 22; $i++) {
                                                            if ($organizacional[$i] > 0) {
                                                                $organizacionalAux += $organizacional[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $organizacionalAux = 0;
                                                        for ($i = 22; $i < 29; $i++) {
                                                            if ($organizacional[$i] > 0) {
                                                                $organizacionalAux += $organizacional[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $organizacionalAux = 0;
                                                        for ($i = 29; $i < count($organizacional); $i++) {
                                                            if ($organizacional[$i] > 0) {
                                                                $organizacionalAux += $organizacional[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0);
                                                        ?>
                                                ]
                                            }, {
                                                color: '#B71C1C',
                                                name: 'Calidad',
                                                data: [
                                                    <?php
                                                        $notZero = 0;
                                                        $calidadAux = 0;
                                                        for ($i = 0; $i < 8; $i++) {
                                                            if ($calidad[$i] > 0) {
                                                                $calidadAux += $calidad[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $calidadAux = 0;
                                                        for ($i = 8; $i < 15; $i++) {
                                                            if ($calidad[$i] > 0) {
                                                                $calidadAux += $calidad[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $calidadAux = 0;
                                                        for ($i = 15; $i < 22; $i++) {
                                                            if ($calidad[$i] > 0) {
                                                                $calidadAux += $calidad[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $calidadAux = 0;
                                                        for ($i = 22; $i < 29; $i++) {
                                                            if ($calidad[$i] > 0) {
                                                                $calidadAux += $calidad[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $calidadAux = 0;
                                                        for ($i = 29; $i < count($calidad); $i++) {
                                                            if ($calidad[$i] > 0) {
                                                                $calidadAux += $calidad[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0);
                                                        ?>
                                                ]
                                            }, {
                                                color: '#2ecc71',
                                                name: 'OEE',
                                                data: [
                                                    <?php
                                                        $notZero = 0;
                                                        $oeeAux = 0;
                                                        for ($i = 0; $i < 8; $i++) {
                                                            if ($oee[$i] > 0) {
                                                                $oeeAux += $oee[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $oeeAux = 0;
                                                        for ($i = 8; $i < 15; $i++) {
                                                            if ($oee[$i] > 0) {
                                                                $oeeAux += $oee[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $oeeAux = 0;
                                                        for ($i = 15; $i < 22; $i++) {
                                                            if ($oee[$i] > 0) {
                                                                $oeeAux += $oee[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $oeeAux = 0;
                                                        for ($i = 22; $i < 29; $i++) {
                                                            if ($oee[$i] > 0) {
                                                                $oeeAux += $oee[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . ",";
                                                        $notZero = 0;
                                                        $oeeAux = 0;
                                                        for ($i = 29; $i < count($oee); $i++) {
                                                            if ($oee[$i] > 0) {
                                                                $oeeAux += $oee[$i];
                                                                $notZero++;
                                                            }
                                                        }
                                                        echo (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0);
                                                        ?>
                                                ]
                                            },{
                                                        color: '#2ECC71',
                                                        type: 'spline',
                                                        name: 'Target',
                                                        data: [
                                                            <?php
                                                            $target = 65;
                                                            for ($i = 1; $i < 6; $i++) {
                                                                echo $target . ',';
                                                            }
                                                            ?>
                                                        ],
                                                        marker: {
                                                            lineWidth: 1,
                                                            lineColor: '#2ECC71',
                                                            fillColor: '#2ECC71'
                                                        }
                                            }]
                                    });
                                </script>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td> <!-- Gráfica diaria -->
                            <div id="graficaOEEDiaria" class="oeeDiario">
                                
                                <script>                                       
                                    Highcharts.chart('graficaOEEDiaria', {
                                        chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            text: 'OEE con Factores de Pérdidas - Diaria'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: [
                                                <?php
                                                    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) {
                                                        echo ($i + 1).',';
                                                    }
                                                ?>
                                            ]
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: 'Porcentaje'
                                            }
                                        },
                                        tooltip: {
                                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                                            shared: true
                                        },
                                                plotOptions: {
                                                    column: {
                                                        stacking: 'percent'
                                                    }
                                                },
                                                series: [{
                                                        color: 'yellow',
                                                        name: 'Desempeño',
                                                        data: [
                                                            <?php
                                                                for ($i = 0; $i < count($desempeno); $i++) {
                                                                    echo $desempeno[$i].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: '#3498db',
                                                        name: 'Cambios',
                                                        data: [
                                                            <?php
                                                                for ($i = 0; $i < count($cambios); $i++) {
                                                                    echo $cambios[$i].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: '#311B92',
                                                        name: 'Tecnicas',
                                                        data: [
                                                            <?php
                                                                for ($i = 0; $i < count($tecnica); $i++) {
                                                                    echo $tecnica[$i].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: '#F06292',
                                                        name: 'Organizacionales',
                                                        data: [
                                                            <?php
                                                                for ($i = 0; $i < count($organizacional); $i++) {
                                                                    echo $organizacional[$i].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: '#B71C1C',
                                                        name: 'Calidad',
                                                        data: [
                                                            <?php
                                                                for ($i = 0; $i < count($calidad); $i++) {
                                                                    echo $calidad[$i].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: '#2ecc71',
                                                        name: 'OEE',
                                                        data: [
                                                            <?php
                                                                for ($i = 0; $i < count($oee); $i++) {
                                                                    echo $oee[$i].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: '#2ECC71',
                                                        type: 'spline',
                                                        name: 'Target',
                                                        data: [
                                                            <?php
                                                                $target = 75;
                                                                for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) {
                                                                    echo $target.',';
                                                                }
                                                            ?>
                                                        ],
                                                        marker: {
                                                            lineWidth: 1,
                                                            lineColor: '#2ECC71',
                                                            fillColor: '#2ECC71'
                                                        }
                                                    }]
                                            });
                                </script>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <table  id="tablaOEE">
            <caption>Diaria</caption>
            <tbody>
                <tr id="trOEE"> <!-- Primer fila -->
                    <th id="thOEE">DIARIO</th>
                    <?php
                    for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $varMonth, $varYear); $i++) {
                        echo "<th id=" . "thOEE" . ">" . ($i + 1) . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- OEE % fila -->
                    <th id="thOEE2">OEE (%)</th>
                    <?php
                    for ($i = 0; $i < count($oee); $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $oee[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Calidad % fila -->
                    <th id="thOEE1">P&eacute;rdidas de Calidad (%)</th>
                    <?php
                    for ($i = 0; $i < count($calidad); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $calidad[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Organizacional % fila -->
                    <th id="thOEE2">P&eacute;rdidas Organizacionales (%)</th>
                    <?php
                    for ($i = 0; $i < count($organizacional); $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $organizacional[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Tecnicas % fila -->
                    <th id="thOEE1">P&eacute;rdidas T&eacute;cnicas (%)</th>
                    <?php
                    for ($i = 0; $i < count($tecnica); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $tecnica[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Cambios % fila -->
                    <th id="thOEE2">P&eacute;rdidas de Cambio de Modelo (%)</th>
                    <?php
                    for ($i = 0; $i < count($cambios); $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $cambios[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Desempeño % fila -->
                    <th id="thOEE1">P&eacute;rdidas por desempe&ntilde;o (%)</th>
                    <?php
                    for ($i = 0; $i < count($desempeno); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $desempeno[$i] . "</th>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>

        <table  id="tablaOEE">
            <caption>Mensual</caption>
            <tbody>
                <tr id="trOEE"> <!-- Primer fila -->
                    <th id="thOEE">MENSUAL</th>
                    <?php
                    for ($i = 1; $i < 13; $i++) {
                        echo "<th id=" . "thOEE" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- OEE % fila -->
                    <th id="thOEE2">OEE (%)</th>
                    <?php
                    for ($i = 0; $i < count($monthlyOEE); $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $monthlyOEE[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Calidad % fila -->
                    <th id="thOEE1">P&eacute;rdidas de Calidad (%)</th>
                    <?php
                    for ($i = 0; $i < count($monthlyCalidad); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $monthlyCalidad[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Organizacional % fila -->
                    <th id="thOEE2">P&eacute;rdidas Organizacionales (%)</th>
                    <?php
                    for ($i = 0; $i < count($monthlyOrganizacional); $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $monthlyOrganizacional[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Tecnicas % fila -->
                    <th id="thOEE1">P&eacute;rdidas T&eacute;cnicas (%)</th>
                    <?php
                    for ($i = 0; $i < count($monthlyTecnica); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $monthlyTecnica[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Cambios % fila -->
                    <th id="thOEE2">P&eacute;rdidas de Cambio de Modelo (%)</th>
                    <?php
                    for ($i = 0; $i < count($monthlyCambios); $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $monthlyCambios[$i] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Desempeño % fila -->
                    <th id="thOEE1">P&eacute;rdidas por desempe&ntilde;o (%)</th>
                    <?php
                    for ($i = 0; $i < count($monthlyDesempeno); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $monthlyDesempeno[$i] . "</th>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>

        <table  id="tablaOEE">
            <caption>Semanal</caption>
            <tbody>
                <tr id="trOEE"> <!-- Primer fila -->
                    <th id="thOEE">SEMANAL</th>
                    <?php
                    for ($i = 7; $i <= 31; $i+= 6) {
                        $time = $varYear."-".$varMonth."-".$i;
                        echo "<th id=" . "thOEE" . ">"."CW". date("W", strtotime($time)) . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- OEE % fila -->
                    <th id="thOEE2">OEE (%)</th>
                    <?php
                    $notZero = 0;
                    $oeeAux = 0;
                    for ($i = 0; $i < 8; $i++) {
                        if ($oee[$i] > 0) {
                            $oeeAux += $oee[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $oeeAux = 0;
                    for ($i = 8; $i < 15; $i++) {
                        if ($oee[$i] > 0) {
                            $oeeAux += $oee[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $oeeAux = 0;
                    for ($i = 15; $i < 22; $i++) {
                        if ($oee[$i] > 0) {
                            $oeeAux += $oee[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $oeeAux = 0;
                    for ($i = 22; $i < 29; $i++) {
                        if ($oee[$i] > 0) {
                            $oeeAux += $oee[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $oeeAux = 0;
                    for ($i = 29; $i < count($oee); $i++) {
                        if ($oee[$i] > 0) {
                            $oeeAux += $oee[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($oeeAux/$notZero, 2) : 0) . "</th>";
                    ?>
                </tr>
                <tr> <!-- Calidad % fila -->
                    <th id="thOEE1">P&eacute;rdidas de Calidad (%)</th>
                    <?php
                    $notZero = 0;
                    $calidadAux = 0;
                    for ($i = 0; $i < 8; $i++) {
                        if ($calidad[$i] > 0) {
                            $calidadAux += $calidad[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $calidadAux = 0;
                    for ($i = 8; $i < 15; $i++) {
                        if ($calidad[$i] > 0) {
                            $calidadAux += $calidad[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $calidadAux = 0;
                    for ($i = 15; $i < 22; $i++) {
                        if ($calidad[$i] > 0) {
                            $calidadAux += $calidad[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $calidadAux = 0;
                    for ($i = 22; $i < 29; $i++) {
                        if ($calidad[$i] > 0) {
                            $calidadAux += $calidad[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $calidadAux = 0;
                    for ($i = 29; $i < count($calidad); $i++) {
                        if ($calidad[$i] > 0) {
                            $calidadAux += $calidad[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($calidadAux/$notZero, 2) : 0) . "</th>";
                    ?>
                </tr>
                <tr> <!-- Organizacional % fila -->
                    <th id="thOEE2">P&eacute;rdidas Organizacionales (%)</th>
                    <?php
                    $notZero = 0;
                    $organizacionalAux = 0;
                    for ($i = 0; $i < 8; $i++) {
                        if ($organizacional[$i] > 0) {
                            $organizacionalAux += $organizacional[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $organizacionalAux = 0;
                    for ($i = 8; $i < 15; $i++) {
                        if ($organizacional[$i] > 0) {
                            $organizacionalAux += $organizacional[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $organizacionalAux = 0;
                    for ($i = 15; $i < 22; $i++) {
                        if ($organizacional[$i] > 0) {
                            $organizacionalAux += $organizacional[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $organizacionalAux = 0;
                    for ($i = 22; $i < 29; $i++) {
                        if ($organizacional[$i] > 0) {
                            $organizacionalAux += $organizacional[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $organizacionalAux = 0;
                    for ($i = 29; $i < count($organizacional); $i++) {
                        if ($organizacional[$i] > 0) {
                            $organizacionalAux += $organizacional[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($organizacionalAux/$notZero, 2) : 0) . "</th>";
                    ?>
                </tr>
                <tr> <!-- Tecnicas % fila -->
                    <th id="thOEE1">P&eacute;rdidas T&eacute;cnicas (%)</th>
                    <?php
                    $notZero = 0;
                    $tecnicaAux = 0;
                    for ($i = 0; $i < 8; $i++) {
                        if ($tecnica[$i] > 0) {
                            $tecnicaAux += $tecnica[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $tecnicaAux = 0;
                    for ($i = 8; $i < 15; $i++) {
                        if ($tecnica[$i] > 0) {
                            $tecnicaAux += $tecnica[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $tecnicaAux = 0;
                    for ($i = 15; $i < 22; $i++) {
                        if ($tecnica[$i] > 0) {
                            $tecnicaAux += $tecnica[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $tecnicaAux = 0;
                    for ($i = 22; $i < 29; $i++) {
                        if ($tecnica[$i] > 0) {
                            $tecnicaAux += $tecnica[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $tecnicaAux = 0;
                    for ($i = 29; $i < count($organizacional); $i++) {
                        if ($tecnica[$i] > 0) {
                            $tecnicaAux += $tecnica[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($tecnicaAux/$notZero, 2) : 0) . "</th>";
                    ?>
                </tr>
                <tr> <!-- Cambios % fila -->
                    <th id="thOEE2">P&eacute;rdidas de Cambio de Modelo (%)</th>
                    <?php
                    $notZero = 0;
                    $cambiosAux = 0;
                    for ($i = 0; $i < 8; $i++) {
                        if ($cambios[$i] > 0) {
                            $cambiosAux += $cambios[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $cambiosAux = 0;
                    for ($i = 8; $i < 15; $i++) {
                        if ($cambios[$i] > 0) {
                            $cambiosAux += $cambios[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $cambiosAux = 0;
                    for ($i = 15; $i < 22; $i++) {
                        if ($cambios[$i] > 0) {
                            $cambiosAux += $cambios[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $cambiosAux = 0;
                    for ($i = 22; $i < 29; $i++) {
                        if ($cambios[$i] > 0) {
                            $cambiosAux += $cambios[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $cambiosAux = 0;
                    for ($i = 29; $i < count($organizacional); $i++) {
                        if ($cambios[$i] > 0) {
                            $cambiosAux += $cambios[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE2" . ">" . (($notZero != 0) ? round($cambiosAux/$notZero, 2) : 0) . "</th>";
                    ?>
                </tr>
                <tr> <!-- Desempeño % fila -->
                    <th id="thOEE1">P&eacute;rdidas por desempe&ntilde;o (%)</th>
                    <?php
                    $notZero = 0;
                    $desempenoAux = 0;
                    for ($i = 0; $i < 8; $i++) {
                        if ($desempeno[$i] > 0) {
                            $desempenoAux += $desempeno[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $desempenoAux = 0;
                    for ($i = 8; $i < 15; $i++) {
                        if ($desempeno[$i] > 0) {
                            $desempenoAux += $desempeno[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $desempenoAux = 0;
                    for ($i = 15; $i < 22; $i++) {
                        if ($desempeno[$i] > 0) {
                            $desempenoAux += $desempeno[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $desempenoAux = 0;
                    for ($i = 22; $i < 29; $i++) {
                        if ($desempeno[$i] > 0) {
                            $desempenoAux += $desempeno[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . "</th>";
                    $notZero = 0;
                    $desempenoAux = 0;
                    for ($i = 29; $i < count($organizacional); $i++) {
                        if ($desempeno[$i] > 0) {
                            $desempenoAux += $desempeno[$i];
                            $notZero++;
                        }
                    }
                    echo "<th id=" . "thOEE1" . ">" . (($notZero != 0) ? round($desempenoAux/$notZero, 2) : 0) . "</th>";
                    ?>                      
                </tr>
            </tbody>
        </table>

    </body>
</html>

