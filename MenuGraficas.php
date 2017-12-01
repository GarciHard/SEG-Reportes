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
<!--        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css"
              integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w"
              crossorigin="anonymous">-->
        <link rel="stylesheet" href="css/style.css">

        <!--PIEZAS PRODUCIDAS-->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/pareto.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
        <!-- PERDIDAS TECNICAS -->
        
        
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
                                /* SENTENCIAS PARA GRAFICAS MINIATURA PRODUCCION */
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
                                
                                <div id="graficaGrande">
                                    <div aling = "center" id="dia" class = "contenedor2">
                                        <script>
                                                chartCPU = new Highcharts.chart('dia', {
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
                                </div>
                                
                                <button id="plain">Detalle Gr&aacute;fica</button>
                            </td>
                            <td> <!-- Gráfica de perdidas tecnicas -->
                                <?php
                                    $datTecnicasDia = pTecnicasDia($line, $year);
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
                                
                                <div aling = "center" id="tecnico" class = "arribaDiaMes">
                                    <script>
                                        chartCPU = new Highcharts.chart('tecnico', {
                                        title: {
                                            text: 'Minutos con Falla por Día'
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
                                
                                <button id="plain">Second Graph</button>
                            </td>
                        </tr>
                        <!--Second row-->
                        <tr>
                            <td>

                                <button id="plain">Third Graph</button>
                            </td>
                            <td>
                                
                                <button id="plain">Fourth Graph</button>
                            </td>
                        </tr>
                        <!--Third row-->
                        <tr>
                            <td>
                                
                                <button id="plain">Fifth Graph</button>
                            </td>
                            <td>
                                
                                <button id="plain">Sixth Graph</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>