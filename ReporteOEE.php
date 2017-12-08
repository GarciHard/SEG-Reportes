<?php
    require_once 'ServerFunctions.php';
    $varLine = $_REQUEST['varLine'];
    $varMonth = $_REQUEST['varMonth'];
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
    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*OEE Percent*/
        if ($dailyOEE[$i - 1][0] == $i) {
            $oee[$i - 1] = $dailyOEE[$i - 1][1];
            $oee[$i - 1] = str_replace('#', '', $oee[$i - 1]);
            $oee[$i - 1] = str_replace('%', '', $oee[$i - 1]);
        } else {
            $oee[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < 13; $i++) { /*OEE Monthly Percent*/
        if ($monthOEE[$i - 1][0] == $i) {
            $monthlyOEE[$i - 1] = $monthOEE[$i - 1][1];
            $monthlyOEE[$i - 1] = str_replace('#', '', $monthlyOEE[$i - 1]);
            $monthlyOEE[$i - 1] = str_replace('%', '', $monthlyOEE[$i - 1]);
        } else {
            $monthlyOEE[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Quality Percent*/
        if ($dailyOEE[$i - 1][0] == $i) {
            $calidad[$i - 1] = $dailyOEE[$i - 1][2];
            $calidad[$i - 1] = str_replace('#', '', $calidad[$i - 1]);
            $calidad[$i - 1] = str_replace('%', '', $calidad[$i - 1]);
        } else {
            $calidad[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < 13; $i++) { /*Quality Monthly Percent*/
        if ($monthOEE[$i - 1][0] == $i) {
            $monthlyCalidad[$i - 1] = $monthOEE[$i - 1][2];
            $monthlyCalidad[$i - 1] = str_replace('#', '', $monthlyCalidad[$i - 1]);
            $monthlyCalidad[$i - 1] = str_replace('%', '', $monthlyCalidad[$i - 1]);
        } else {
            $monthlyCalidad[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Organizational Percent*/
        if ($dailyOEE[$i - 1][0] == $i) {
            $organizacional[$i - 1] = $dailyOEE[$i - 1][3];
            $organizacional[$i - 1] = str_replace('#', '', $organizacional[$i - 1]);
            $organizacional[$i - 1] = str_replace('%', '', $organizacional[$i - 1]);
        } else {
            $organizacional[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < 13; $i++) { /*Organizational Monthly Percent*/
        if ($monthOEE[$i - 1][0] == $i) {
            $monthlyOrganizacional[$i - 1] = $monthOEE[$i - 1][3];
            $monthlyOrganizacional[$i - 1] = str_replace('#', '', $monthlyOrganizacional[$i - 1]);
            $monthlyOrganizacional[$i - 1] = str_replace('%', '', $monthlyOrganizacional[$i - 1]);
        } else {
            $monthlyOrganizacional[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Technical Percent*/
        if ($dailyOEE[$i - 1][0] == $i) {
            $tecnica[$i - 1] = $dailyOEE[$i - 1][4];
            $tecnica[$i - 1] = str_replace('#', '', $tecnica[$i - 1]);
            $tecnica[$i - 1] = str_replace('%', '', $tecnica[$i - 1]);
        } else {
            $tecnica[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < 13; $i++) { /*Technical Monthly Percent*/
        if ($monthOEE[$i - 1][0] == $i) {
            $monthlyTecnica[$i - 1] = $monthOEE[$i - 1][4];
            $monthlyTecnica[$i - 1] = str_replace('#', '', $monthlyTecnica[$i - 1]);
            $monthlyTecnica[$i - 1] = str_replace('%', '', $monthlyTecnica[$i - 1]);
        } else {
            $monthlyTecnica[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Changeover Percent*/
        if ($dailyOEE[$i - 1][0] == $i) {
            $cambios[$i - 1] = $dailyOEE[$i - 1][5];
            $cambios[$i - 1] = str_replace('#', '', $cambios[$i - 1]);
            $cambios[$i - 1] = str_replace('%', '', $cambios[$i - 1]);
        } else {
            $cambios[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < 13; $i++) { /*Changeover Monthly Percent*/
        if ($monthOEE[$i - 1][0] == $i) {
            $monthlyCambios[$i - 1] = $monthOEE[$i - 1][5];
            $monthlyCambios[$i - 1] = str_replace('#', '', $monthlyCambios[$i - 1]);
            $monthlyCambios[$i - 1] = str_replace('%', '', $monthlyCambios[$i - 1]);
        } else {
            $monthlyCambios[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Performance Percent*/
        if ($dailyOEE[$i - 1][0] == $i) {
            $desempeno[$i - 1] = $dailyOEE[$i - 1][6];
            $desempeno[$i - 1] = str_replace('#', '', $desempeno[$i - 1]);
            $desempeno[$i - 1] = str_replace('%', '', $desempeno[$i - 1]);
        } else {
            $desempeno[$i - 1] = 0;
        }
    }
    for ($i = 1; $i < 13; $i++) { /*Performance Monthly Percent*/
        if ($monthOEE[$i - 1][0] == $i) {
            $monthlyDesempeno[$i - 1] = $monthOEE[$i - 1][6];
            $monthlyDesempeno[$i - 1] = str_replace('#', '', $monthlyDesempeno[$i - 1]);
            $monthlyDesempeno[$i - 1] = str_replace('%', '', $monthlyDesempeno[$i - 1]);
        } else {
            $monthlyDesempeno[$i - 1] = 0;
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
        <h1 align=center id="titulos">
            Gr&aacute;fica de Seguimiento Diario a OEE
            <br>
            <?php echo "Linea: ".$varLine?>
            <br>
            <?php echo "Mes: ".$varMesStr[$varMonth - 1]?>
        </h1>

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
                                                name: 'OEE',
                                                data: [50, 3, 4, 7, 2, 3, 9, 0, 10, 1, 6, 8]
                                            }, {
                                                name: 'Calidad',
                                                data: [2, 2, 3, 2, 1]
                                            }, {
                                                name: 'Organizacionales',
                                                data: [3, 4, 4, 2, 5]
                                            }, {
                                                name: 'Tecnicas',
                                                data: [9, 8, 7, 6, 5]
                                            }, {
                                                name: 'Cambios',
                                                data: [9, 8, 7, 6, 5]
                                            }, {
                                                name: 'Desempeño',
                                                data: [9, 8, 7, 6, 5]
                                            }, {
                                                type: 'spline',
                                                name: 'Target',
                                                data: [30, 20.67, 30, 60.33, 30.33, 20.67, 30, 60.33, 30.33, 50, 40, 80],
                                                marker: {
                                                    lineWidth: 2,
                                                    lineColor: Highcharts.getOptions().colors[3],
                                                    fillColor: 'white'
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
                                            categories: [<?php
                                            for ($i = 1; $i < 8; $i++) {
                                                echo $i . ',';
                                            }
                                            ?>]
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
                                                name: 'OEE',
                                                data: [5, 3, 4, 7, 2, 8, 1]
                                            }, {
                                                name: 'Calidad',
                                                data: [2, 2, 3, 2, 1]
                                            }, {
                                                name: 'Organizacionales',
                                                data: [3, 4, 4, 2, 5]
                                            }, {
                                                name: 'Tecnicas',
                                                data: [9, 8, 7, 6, 5]
                                            }, {
                                                name: 'Cambios',
                                                data: [9, 8, 7, 6, 5]
                                            }, {
                                                name: 'Desempeño',
                                                data: [9, 8, 7, 6, 5]
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
                                            categories: [<?php
                                            for ($i = 1; $i < 32; $i++) {
                                                echo $i . ',';
                                            }
                                            ?>]
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
                                                                for ($i = 1; $i < count($desempeno) + 1; $i++) {
                                                                    echo $desempeno[$i - 1].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: 'orange',
                                                        name: 'Cambios',
                                                        data: [
                                                            <?php
                                                                for ($i = 1; $i < count($cambios) + 1; $i++) {
                                                                    echo $cambios[$i - 1].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: 'blue',
                                                        name: 'Tecnicas',
                                                        data: [
                                                            <?php
                                                                for ($i = 1; $i < count($tecnica) + 1; $i++) {
                                                                    echo $tecnica[$i - 1].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: 'green',
                                                        name: 'Organizacionales',
                                                        data: [
                                                            <?php
                                                                for ($i = 1; $i < count($organizacional) + 1; $i++) {
                                                                    echo $organizacional[$i - 1].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: 'red',
                                                        name: 'Calidad',
                                                        data: [
                                                            <?php
                                                                for ($i = 1; $i < count($calidad) + 1; $i++) {
                                                                    echo $calidad[$i - 1].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: 'gray',
                                                        name: 'OEE',
                                                        data: [
                                                            <?php
                                                                for ($i = 1; $i < count($oee) + 1; $i++) {
                                                                    echo $oee[$i - 1].',';
                                                                }
                                                            ?>
                                                        ]
                                                    }, {
                                                        color: 'green',
                                                        type: 'spline',
                                                        name: 'Target',
                                                        data: [
                                                            <?php
                                                                $target = 75;
                                                                for ($i = 1; $i < 32; $i++) {
                                                                    echo $target.',';
                                                                }
                                                            ?>
                                                        ],
                                                        marker: {
                                                            lineWidth: 2,
                                                            lineColor: Highcharts.getOptions().colors[3],
                                                            fillColor: 'white'
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
                    for ($i = 1; $i < 32; $i++) {
                        echo "<th id=" . "thOEE" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- OEE % fila -->
                    <th id="thOEE2">OEE (%)</th>
                    <?php
                    for ($i = 1; $i < count($oee) + 1; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $oee[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Calidad % fila -->
                    <th id="thOEE1">P&eacute;rdidas de Calidad (%)</th>
                    <?php
                    for ($i = 1; $i < count($calidad) + 1; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $calidad[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Organizacional % fila -->
                    <th id="thOEE2">P&eacute;rdidas Organizacionales (%)</th>
                    <?php
                    for ($i = 1; $i < count($organizacional) + 1; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $organizacional[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Tecnicas % fila -->
                    <th id="thOEE1">P&eacute;rdidas T&eacute;cnicas (%)</th>
                    <?php
                    for ($i = 1; $i < count($tecnica) + 1; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $tecnica[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Cambios % fila -->
                    <th id="thOEE2">P&eacute;rdidas de Cambio de Modelo (%)</th>
                    <?php
                    for ($i = 1; $i < count($cambios) + 1; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $cambios[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Desempeño % fila -->
                    <th id="thOEE1">P&eacute;rdidas por desempe&ntilde;o (%)</th>
                    <?php
                    for ($i = 1; $i < count($desempeno) + 1; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $desempeno[$i - 1] . "</th>";
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
                    for ($i = 1; $i < count($monthlyOEE) + 1; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $monthlyOEE[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Calidad % fila -->
                    <th id="thOEE1">P&eacute;rdidas de Calidad (%)</th>
                    <?php
                    for ($i = 1; $i < count($monthlyCalidad) + 1; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $monthlyCalidad[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Organizacional % fila -->
                    <th id="thOEE2">P&eacute;rdidas Organizacionales (%)</th>
                    <?php
                    for ($i = 1; $i < count($monthlyOrganizacional) + 1; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $monthlyOrganizacional[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Tecnicas % fila -->
                    <th id="thOEE1">P&eacute;rdidas T&eacute;cnicas (%)</th>
                    <?php
                    for ($i = 1; $i < count($monthlyTecnica) + 1; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $monthlyTecnica[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Cambios % fila -->
                    <th id="thOEE2">P&eacute;rdidas de Cambio de Modelo (%)</th>
                    <?php
                    for ($i = 1; $i < count($monthlyCambios) + 1; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $monthlyCambios[$i - 1] . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Desempeño % fila -->
                    <th id="thOEE1">P&eacute;rdidas por desempe&ntilde;o (%)</th>
                    <?php
                    for ($i = 1; $i < count($monthlyDesempeno); $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $monthlyDesempeno[$i - 1] . "</th>";
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
                    for ($i = 1; $i < 8; $i++) {
                        echo "<th id=" . "thOEE" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- OEE % fila -->
                    <th id="thOEE2">OEE (%)</th>
                    <?php
                    for ($i = 1; $i < 8; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Calidad % fila -->
                    <th id="thOEE1">P&eacute;rdidas de Calidad (%)</th>
                    <?php
                    for ($i = 1; $i < 8; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Organizacional % fila -->
                    <th id="thOEE2">P&eacute;rdidas Organizacionales (%)</th>
                    <?php
                    for ($i = 1; $i < 8; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Tecnicas % fila -->
                    <th id="thOEE1">P&eacute;rdidas T&eacute;cnicas (%)</th>
                    <?php
                    for ($i = 1; $i < 8; $i++) {
                        echo "<th id=" . "thOEE1" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Cambios % fila -->
                    <th id="thOEE2">P&eacute;rdidas de Cambio de Modelo (%)</th>
                    <?php
                    for ($i = 1; $i < 8; $i++) {
                        echo "<th id=" . "thOEE2" . ">" . $i . "</th>";
                    }
                    ?>
                </tr>
                <tr> <!-- Desempeño % fila -->
                    <th id="thOEE1">P&eacute;rdidas por desempe&ntilde;o (%)</th>
                        <?php
                        for ($i = 1; $i < 8; $i++) {
                            echo "<th id=" . "thOEE1" . ">" . $i . "</th>";
                        }
                        ?>
                </tr>
            </tbody>
        </table>

    </body>
</html>

