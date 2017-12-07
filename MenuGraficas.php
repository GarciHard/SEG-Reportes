<?php
    require_once 'ServerFunctions.php';
    
    $lineasArrObj = listarLineas();
    $lineaArr;
    for ($i = 0; $i < count($lineasArrObj); $i++) {
        $lineaArr[$i] = $lineasArrObj[$i][0];
    }
    $mesesArrObj = listarMeses();
    $anioArrObj = listarAnio();
    
    $line = "";
    $month = "";
    $year = "";
    
?>
<html>
    <head>
        <!-- HOJA DE ESTILOS-->
        <link rel="stylesheet" href="css/style.css">

        <!--SCRIPTS P/MINIATURAS DE LAS GRAFICAS-->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/pareto.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    
    <body>
        <table>
            
            <form action="MenuGraficas.php" method="POST">
                <caption>
                    Men&uacute;
                    <br>
                    <label>Linea: </label>
                    <select id="lineaCombo" name="cmbLinea" >
                        <?php
                        for ($i = 0; $i < count($lineasArrObj); $i++) {
                            echo "<option>" . $lineaArr[$i] . "</option>";
                        }
                        ?>
                    </select>
                    <label>Mes: </label>
                    <select id="mesCombo" name="cmbMes">
                        <?php
                        for ($i = 0; $i < count($mesesArrObj); $i++) {
                            echo "<option value=".($i+1).">" . $mesesArrObj[$i] . "</option>";
                        }
                        ?>
                    </select>
                    <label>A&ntilde;o:  </label>
                    <select id="anioCombo" name="cmbAnio" >
                        <?php
                        for ($i = 0; $i < count($anioArrObj); $i++) {
                            echo "<option>" . $anioArrObj[$i] . "</option>";
                        }
                        ?>
                    </select>
                    <button>Calcular Gr&aacute;ficas</button>
                    <br><br>
                </caption>
            </form>
            
            <?php
            $line = isset($_POST['cmbLinea']) ? $_POST['cmbLinea'] : '';
            
            $month = isset($_POST['cmbMes']) ? $_POST['cmbMes'] : '';
            
            $year = isset($_POST['cmbAnio']) ? $_POST['cmbAnio'] : '';
            
            ?>
        </table>

        <div id="table-wrapper-main-graph">
            <div id="table-scroll-main-graph">
                <table>
                    <tbody>
                        <!--First row-->
                        <tr>
                            <td> <!-- Gráfica de producción miniatura -->
                                <?php
                                $datProdDiaMes = pzasProdDiaMes($line, $month);
                                $datProdMes = pzasProdMes($line, $year);
                                $datProdAnio = pzasProdAnual();

                                $varProdDia;
                                $varProdMes;
                                $varProdAnio;
                                $prodDiaMes;
                                $prodMes;
                                $prodAnio;

                                for ($i = 0; $i < count($datProdAnio); $i++) {
                                    $varProdAnio[$i] = $datProdAnio[$i][0];
                                    $prodAnio[$i] = $datProdAnio[$i][1];
                                }

                                for ($i = 0; $i < count($datProdDiaMes); $i++) {
                                    $varProdDia[$i] = $datProdDiaMes[$i][0];
                                    $prodDiaMes[$i] = $datProdDiaMes[$i][1];
                                }

                                for ($i = 0; $i < count($datProdMes); $i++) {
                                    $varProdMes[$i] = $datProdMes[$i][0];
                                    $prodMes[$i] = $datProdMes[$i][1];
                                }
                                ?>
                                
                                <form action="ReporteOEE.php" method="POST">
                                    <div aling = "center" id="produccion" class = "produccionGraph">
                                        <script>
                                                chartCPU = new Highcharts.chart('produccion', {
                                                chart: {
                                                  type: 'scatter'  
                                                },
                                                title: {
                                                    text: 'Piezas Producidas'
                                                },
                                                xAxis: {
                                                    gridLineWidth: 1,
                                                    categories: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 0 ;$i<count($datProdDiaMes);$i++){
                                                            ?>
                                                            data.push([<?php echo $varProdDia[$i];?>]);
                                                            <?php } ?>
                                                            return data;
                                                        })()
                                                },
                                                yAxis: [{
                                                    //stroke-width: 2px;
                                                    //stroke: #d8d8d8;
                                                }],
                                                series: [{ //LINEA CHUNDA
                                                    type: 'spline',
                                                    name: 'Meta',
                                                    yAxis: 0,
                                                    zIndex: 0,
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 0 ;$i<count($datProdDiaMes);$i++){
                                                            ?>
                                                            data.push([<?php echo $prodDiaMes[$i];?>]);
                                                            <?php } ?>
                                                            return data;
                                                        })()
                                                }, { //BARRAS CHUNDAS
                                                    name: 'Indicadores',
                                                    type: 'column',
                                                    zIndex: 1,
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 0 ;$i<count($datProdDiaMes);$i++){
                                                            ?>
                                                            data.push([<?php echo $prodDiaMes[$i];?>]);

                                                            <?php } ?>
                                                            return data;

                                                        })()

                                                }],
                                                credits: {
                                                        enabled: false
                                                },
                                                responsive: {
                                                    rules: [{
                                                        condition: {
                                                            maxWidth: 500
                                                        },
                                                        chartOptions: {
                                                            legend: {
                                                                layout: 'horizontal',
                                                                align: 'center',
                                                                verticalAlign: 'bottom'
                                                            }
                                                        }
                                                    }]
                                                }
                                            });
                                        </script>
                                    </div>
                                    <button id="plain">Detalle Producci&oacute;n</button>
                                </form>
                            </td>
                            <td> <!-- Gráfica de perdidas tecnicas -->
                                <?php
                                    $datTecnicasDia = pTecnicasDia($line, $month);
                                    $varTecDia;
                                    $varTecDuracionDia;

                                    for ($i = 1; $i < 32; $i++) {
                                        $varTecDia[$i] = $i;
                                        $varTecDuracionDia[$i] = 0;
                                    }

                                    for ($i = 0; $i < count($datTecnicasDia); $i++) {
                                        $d = (int) $datTecnicasDia[$i][0];
                                        $varTecDia[$i] = $datTecnicasDia[$i][0];
                                        $varTecDuracionDia[$d] = $datTecnicasDia[$i][1];
                                    }
                                ?>
                                <div aling = "center" id="tecnicas" class = "perdidaTecnica">
                                    <script>
                                        chartCPU = new Highcharts.chart('tecnicas', {
                                        title: {
                                            text: 'Perdidas Técnicas'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1; $i < 32; $i++){
                                                    ?>
                                                    data.push([<?php echo $i;?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        },
                                        yAxis: [{
                                        }],
                                        series: [{ //LINEA CHUNDA
                                            color: '#2ECC71', // color para la meta 
                                        }, { //BARRAS CHUNDAS
                                            color: '#1A06AF',
                                            name: 'Indicadores',
                                            type: 'spline',
                                           // type: 'spline',
                                            zIndex: 1,
                                            //data: [5, 5, 5, 7, 5]
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i < 32; $i++){
                                                    ?>
                                                    data.push([<?php echo $varTecDuracionDia[$i];?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        }],
                                        credits: {
                                                enabled: false
                                        },
                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        }
                                    });
                                    </script> 
                                </div>
                                <button id="plain">Detalle T&eacute;cnicas</button>
                            </td>
                        </tr>
                        <!--Second row-->
                        <tr>
                            <td><!-- Gráfica de perdidas organizacionales -->
                                <?php
                                $datOrgDia = pOrganizacionalesDia($line, $month);
                                $varOrgdia;
                                $varOrgDuracionDia;

                                for ($i = 1; $i < 32; $i++) {
                                    $varOrgdia[$i] = $i;
                                    $varOrgDuracionDia[$i] = 0;
                                }

                                for ($i = 0; $i < count($datOrgDia); $i++) {
                                    $d = (int) $datOrgDia[$i][0];
                                    $varOrgdia[$i] = $datOrgDia[$i][0];
                                    $varOrgDuracionDia[$d] = $datOrgDia[$i][1];
                                }
                                ?>
                                <div aling = "center" id="organizacional" class = "perdidaOrganizacional">
                                    <script>
                                        chartCPU = new Highcharts.chart('organizacional', {
                                        title: {
                                            text: 'Perdidas Organizacionales'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1; $i < 32; $i++){
                                                    ?>
                                                    data.push([<?php echo $i;?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        },
                                        yAxis: [{
                                        }],
                                        series: [{ //LINEA CHUNDA

                                        }, { //BARRAS CHUNDAS
                                            lineColor: '#1A06AF',
                                            name: 'Indicadores',
                                            type: 'spline',
                                           // type: 'spline',
                                            zIndex: 1,
                                            //data: [5, 5, 5, 7, 5]
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1; $i < 32; $i++){
                                                    ?>
                                                    data.push([<?php echo $varOrgDuracionDia[$i];?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        }],
                                        credits: {
                                                enabled: false
                                        },
                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        }
                                    });
                                    </script> 
                                </div>
                                <button id="plain">Detalle Organizacionales</button>
                            </td>
                            <td><!-- Gráfica de perdidas por paros planeados -->
                                <?php
                                $datPlaneadoDia = pPlaneadoDia($line, $month);
                                $varPlanDia;
                                $varPlanDuracionDia;

                                for ($i = 1; $i < 32; $i++) {
                                    $varPlanDia[$i] = $i;
                                    $varPlanDuracionDia[$i] = 0;
                                }
                                for ($i = 0; $i < count($datPlaneadoDia); $i++) {
                                    $d = (int) $datPlaneadoDia[$i][0];
                                    $varPlanDia[$i] = $datPlaneadoDia[$i][0];
                                    $varPlanDuracionDia[$d] = $datPlaneadoDia[$i][1];
                                }
                                ?>
                                <div aling = "center" id="parosPlaneados" class = "perdidaParosPlaneados">
                                    <script>
                                        chartCPU = new Highcharts.chart('parosPlaneados', {
                                        title: {
                                            text: 'Perdidas Por Paros Planeados'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $i;?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        },
                                        yAxis: [{
                                        }],
                                        series: [{ //LINEA CHUNDA

                                        }, { //BARRAS CHUNDAS
                                            lineColor: '#1A06AF',
                                            name: 'Indicadores',
                                            type: 'spline',
                                           // type: 'spline',
                                            zIndex: 1,
                                            //data: [5, 5, 5, 7, 5]
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $varPlanDuracionDia[$i];?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        }],
                                        credits: {
                                                enabled: false
                                        },
                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        }
                                    });
                                    </script> 
                                </div>
                                <button id="plain">Detalle Paros Planeados</button>
                            </td>
                        </tr>
                        <!--Third row-->
                        <tr>
                            <td><!-- Gráfica de perdidas por cambios de modelo -->
                                <?php
                                $datCModDia = pCambioModDia($line, $month);
                                $varCambioDia;
                                $varCambioDuracionDia;

                                for ($i = 1; $i < 32; $i++) {
                                    $varCambioDia[$i] = $i;
                                    $varCambioDuracionDia[$i] = 0;
                                }

                                for ($i = 0; $i < count($datCModDia); $i++) {
                                    $d = (int) $datCModDia[$i][0];
                                    $varCambioDia[$i] = $datCModDia[$i][0];
                                    $varCambioDuracionDia[$d] = $datCModDia[$i][1];
                                }
                                ?>
                                <div aling = "center" id="cambios" class = "perdidaCambioModelo">
                                    <script>
                                        chartCPU = new Highcharts.chart('cambios', {
                                        title: {
                                            text: 'Perdidas Por Cambio De Modelo'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $i;?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        },
                                        yAxis: [{
                                        }],
                                        series: [{ //LINEA CHUNDA
                                            color: '#2ECC71',
                                        }, { //BARRAS CHUNDAS
                                            color: '#08088A',
                                            name: 'Indicadores',
                                            type: 'spline',
                                            zIndex: 1,
                                            //data: [5, 5, 5, 7, 5]
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $varCambioDuracionDia[$i];?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        }],
                                        credits: {
                                                enabled: false
                                        },
                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        }
                                    });
                                    </script> 
                                </div>
                                <button id="plain">Detalle Cambios de Modelo</button>
                            </td>
                            <td><!-- Grafica de perdidas de calidad-->
                                <?php
                                $datCalidadDia = pCalidadDia($line, $month);
                                $varCalidadDia;
                                $varCalidadDuracionDia;

                                for ($i = 1; $i < 32; $i++) {
                                    $varCalidadDia[$i] = $i;
                                    $varCalidadDuracionDia[$i] = 0;
                                }

                                for ($i = 0; $i < count($datCalidadDia); $i++) {
                                    $d = (int) $datCalidadDia[$i][0];
                                    $varCalidadDia[$i] = $datCalidadDia[$i][0];
                                    $varCalidadDuracionDia[$d] = $datCalidadDia[$i][1];
                                }
                                ?>
                                <div aling = "center" id="calidad" class = "perdidaCalidad">
                                    <script>
                                        chartCPU = new Highcharts.chart('calidad', {
                                        title: {
                                            text: 'Perdidas de Calidad'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            categories: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $i;?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        },
                                        yAxis: [{
                                        }],
                                        series: [{ //LINEA CHUNDA

                                        }, { //BARRAS CHUNDAS
                                            lineColor: '#1A06AF',
                                            name: 'Indicadores',
                                            type: 'spline',
                                           // type: 'spline',
                                            zIndex: 1,
                                            //data: [5, 5, 5, 7, 5]
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $varCalidadDuracionDia[$i];?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        }],
                                        credits: {
                                                enabled: false
                                        },
                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        }
                                    });
                                    </script> 
                                </div>
                                <button id="plain">Detalle Calidad</button>
                            </td>
                        </tr>
                        <!--Fourth row-->
                        <tr>
                            <td><!-- Grafica de OEE-->
                                <?php
                                    $dailyOEE = oeeDiarioGrafica($line, $month);
                                    $oee;
                                    $calidad;
                                    $organizacional;
                                    $tecnica;
                                    $cambios;
                                    $desempeno;
                                    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*OEE Percent*/
                                        if ($dailyOEE[$i - 1][0] == $i) {
                                            $oee[$i - 1] = $dailyOEE[$i - 1][1];
                                            $oee[$i - 1] = str_replace('#', '', $oee[$i - 1]);
                                            $oee[$i - 1] = str_replace('%', '', $oee[$i - 1]);
                                        } else {
                                            $oee[$i - 1] = 0;
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
                                    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Organizational Percent*/
                                        if ($dailyOEE[$i - 1][0] == $i) {
                                            $organizacional[$i - 1] = $dailyOEE[$i - 1][3];
                                            $organizacional[$i - 1] = str_replace('#', '', $organizacional[$i - 1]);
                                            $organizacional[$i - 1] = str_replace('%', '', $organizacional[$i - 1]);
                                        } else {
                                            $organizacional[$i - 1] = 0;
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
                                    for ($i = 1; $i < count($dailyOEE) + 1; $i++) { /*Changeover Percent*/
                                        if ($dailyOEE[$i - 1][0] == $i) {
                                            $cambios[$i - 1] = $dailyOEE[$i - 1][5];
                                            $cambios[$i - 1] = str_replace('#', '', $cambios[$i - 1]);
                                            $cambios[$i - 1] = str_replace('%', '', $cambios[$i - 1]);
                                        } else {
                                            $cambios[$i - 1] = 0;
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
                                ?>
                                <form action="ReporteOEE.php" method="POST">
                                    <div id="graficaOEEDiaria" class="oeeDiario">
                                        <script>                                       
                                            Highcharts.chart('graficaOEEDiaria', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                title: {
                                                    text: 'OEE con Factores de Pérdidas'
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
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                    ?>
                                    <button id="plain">Detalle OEE</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>