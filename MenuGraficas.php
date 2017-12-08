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
        <h1 align=center id="titulos">
            SEG Automotive Systems
        </h1>
        <table>
            
            <form action="MenuGraficas.php" method="POST">
                <caption>
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
                                $datProdMes = pzasProdMes($line, $year);
                                $datProdAnio = pzasProdAnual($line, $month);
                                $datProdNoP = pzasProdNoParte($line, $month, $year);
                                $datProdNoPDia = pzasProdNoParteDia($line, $month, $year);
                                $datTargetProdAnio = targetProdAnio($line, $year);
                                $datTargetProdMes = targetProdMes($line, $year);

                                $dia;
                                $numPartDia;
                                $numPartCant;
                                $numPart;
                                $mes;
                                $anio;
                                $noParte;
                                $prodMes;
                                $prodAnio;
                                $targetProdAnio;
                                $targetProdMes;

                                for ($i = 0; $i < count($datProdAnio); $i++) {
                                    $anio[$i] = $datProdAnio[$i][0];
                                    $prodAnio[$i] = $datProdAnio[$i][1];
                                }

                                for ($i = 0; $i < count($datTargetProdAnio); $i++) {
                                    $targetProdAnio[$i] = $datTargetProdAnio [$i][1];
                                }

                                for ($i = 0; $i < count($datTargetProdMes); $i++) {
                                    $targetProdMes[$i] = $datTargetProdMes[$i][1];
                                }

                                for ($i = 0; $i < count($datProdMes); $i++) {
                                    $mes[$i] = $datProdMes[$i][0];

                                    switch ($mes[$i]) {
                                        case 1:
                                            $mesCadenaProd[$i] = (string) "'Enero'";
                                            break;
                                        case 2:
                                            $mesCadenaProd[$i] = (string) "'Febrero'";
                                            break;
                                        case 3:
                                            $mesCadenaProd[$i] = (string) "'Marzo'";
                                            break;
                                        case 4:
                                            $mesCadenaProd[$i] = (string) "'Abril'";
                                            break;
                                        case 5:
                                            $mesCadenaProd[$i] = (string) "'Mayo'";
                                            break;
                                        case 6:
                                            $mesCadenaProd[$i] = (string) "'Junio'";
                                            break;
                                        case 7:
                                            $mesCadenaProd[$i] = (string) "'Julio'";
                                            break;
                                        case 8:
                                            $mesCadenaProd[$i] = (string) "'Agosto'";
                                            break;
                                        case 9:
                                            $mesCadenaProd[$i] = (string) "'Septiembre'";
                                            break;
                                        case 10:
                                            $mesCadenaProd[$i] = (string) "'Octubre'";
                                            break;
                                        case 11:
                                            $mesCadenaProd[$i] = (string) "'Noviembre'";
                                            break;
                                        case 12:
                                            $mesCadenaProd[$i] = (string) "'Diciembre'";
                                            break;
                                    }
                                    $prodMes[$i] = $datProdMes[$i][1];
                                }

                                for ($i = 0; $i < 100; $i++) {
                                    $noParte[$i] = (string) '';
                                }

                                //Para cachar los numero de parte por Mes
                                for ($i = 0; $i < count($datProdNoP); $i++) {
                                    $noParte[$i] = (int) $datProdNoP[$i][0];
                                }

                                for ($i = 0; $i < 26; $i++) {
                                    for ($j = 1; $j < 32; $j++) {
                                        $numPartCant[$j][$i] = (int) 0;
                                        $numPartDia [$j] = (int) 0;
                                    }
                                }

                                for ($i = 0; $i < count($datProdNoPDia); $i++) {
                                    $numPart[$i] = (int) $datProdNoPDia[$i][1]; // Numuero de Parte
                                }

                                for ($i = 0; $i < count($datProdNoPDia); $i++) {
                                    $d = $datProdNoPDia[$i][0];
                                    if ($numPart[$i] == $noParte[0]) {
                                        $numPartCant[$d][0] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[1]) {
                                        $numPartCant[$d][1] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[2]) {
                                        $numPartCant[$d][2] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[3]) {
                                        $numPartCant[$d][3] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[4]) {
                                        $numPartCant[$d][4] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[5]) {
                                        $numPartCant[$d][5] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[6]) {
                                        $numPartCant[$d][6] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[7]) {
                                        $numPartCant[$d][7] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[8]) {
                                        $numPartCant[$d][8] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[9]) {
                                        $numPartCant[$d][9] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[10]) {
                                        $numPartCant[$d][10] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[11]) {
                                        $numPartCant[$d][11] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[12]) {
                                        $numPartCant[$d][12] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[12]) {
                                        $numPartCant[$d][13] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[13]) {
                                        $numPartCant[$d][14] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[14]) {
                                        $numPartCant[$d][15] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[15]) {
                                        $numPartCant[$d][16] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[16]) {
                                        $numPartCant[$d][17] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[17]) {
                                        $numPartCant[$d][18] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[18]) {
                                        $numPartCant[$d][19] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[19]) {
                                        $numPartCant[$d][20] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[20]) {
                                        $numPartCant[$d][21] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[21]) {
                                        $numPartCant[$d][22] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[22]) {
                                        $numPartCant[$d][23] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[23]) {
                                        $numPartCant[$d][24] = $datProdNoPDia[$i][2];
                                    } else if ($numPart[$i] == $noParte[24]) {
                                        $numPartCant[$d][25] = $datProdNoPDia[$i][2];
                                    }
                                }
                                ?>
                                
                                <form action="producidas.php" method="POST">
                                    <div aling = "center" id="produccion" class = "produccionGraph">
                                        <script>
                                                chartCPU = new Highcharts.chart('produccion', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                title: {
                                                    text: 'Producción'
                                                },
                                                xAxis: {
                                                    title: {
                                                        text: 'Día'
                                                    },
                                                    gridLineWidth: 1,
                                                    categories: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1 ;$i < 32;$i++){
                                                            ?>
                                                            data.push([<?php echo $i;?>]);
                                                            <?php } ?>
                                                            return data;
                                                        })()
                                                },
                                                yAxis: {
                                                    allowDecimals: false,
                                                    min: 0,
                                                    tickInterval: 2000,
                                                    title: {
                                                        text: 'Cantidad Pzas'
                                                    },
                                                    stackLabels: { //Para ver el numerito por dia
                                                        enabled: true,
                                                        style: {
                                                            fontWeight: 'bold',
                                                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                                                        }
                                                    }
                                                },
                                                legend: {
                                                    layout: 'vertical',
                                                    align: 'right',
                                                    verticalAlign: 'middle'

                                                },
                                                tooltip: {
                                                    valueSuffix: ' Pzs'
                                                },
                                                plotOptions: {
                                                    column: {
                                                        stacking: 'normal'
                                                    }
                                                },
                                                series: [{  
                                                    color: '#2874A6',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[0];?>]);
                                                            return data;
                                                        })(),

                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][0];?>]);
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#FF0000',
                                                    name: 'No.Parte '+(function() {
                                                            var dat = [];
                                                            dat.push([<?php echo 'No. Parte: '+$noParte[1];?>]);
                                                            return dat;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][1];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#C39BD3',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[2];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][2];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#6600FF',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[3];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][3];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#D35400',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[4];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                           var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][4];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#FF99CC',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[5];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][5];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#2980B9',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[6];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][6];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#76448A',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[7];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][7];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#1A5276',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[8];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][8];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#1E8449',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[9];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                           var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][9];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#996666',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[10];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][10];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#999966',
                                                    visible: true,
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[11];?>]);
                                                            return data;
                                                        })(),
                                                    data:  (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][11];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#791276',
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[12];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][12];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#00FFFF',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[13];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][13];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#D4E157',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[14];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][14];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    color: '#FF00FF',
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[15];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][16];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[17];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][17];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[18];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][18];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte '+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[19];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][19];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[20];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][20];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[21];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][21];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[22];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][22];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[23];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][23];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[24];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][24];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }, {
                                                    name: 'No.Parte'+(function() {
                                                            var data = [];
                                                            data.push([<?php echo $noParte[25];?>]);
                                                            return data;
                                                        })(),
                                                    data: (function() {
                                                            var data = [];
                                                            <?php
                                                                for($i = 1; $i < 32; $i++){
                                                            ?>
                                                            data.push([<?php echo $numPartCant[$i][25];?>]);                            
                                                            <?php } ?>
                                                            return data;                            
                                                        })(),
                                                    stack: 'female'
                                                }],
                                                credits: {
                                                        enabled: false
                                                },
                                                responsive: {
                                                    rules: [{
                                                        condition: {
                                                            maxWidth: 500
                                                        }
                                                    }]
                                                }
                                            });
                                        </script>
                                    </div>
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                        echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$year.">";
                                    ?>
                                    <button id="plain">Detalle Producci&oacute;n</button>
                                </form>
                            </td>
                            <td> <!-- Gráfica de perdidas tecnicas -->
                                <?php
                                    $datTecnicasDia = pTecnicasDia($line, $month);
                                    $datTecnicasMes = pTecnicasMes($line, $year);
                                    $datTargetDiaTecnicas = targetDiaTecnicas($line, $month, $year);
                                    $datTargetMesTecnicas = targetMesTecnicas($line, $year);

                                    $diaPTec;
                                    $mesPTecnicas;
                                    $mesCadenaPTec = '';
                                    $duracionDiaPTec;
                                    $duracionMesPTec;   
                                    $targetDiaPTec;
                                    $targetMesPTec;

                                    for ($i = 1; $i<32; $i++){
                                        $diaPTec[$i] = $i;
                                        $duracionDiaPTec[$i] = 0;   
                                        $targetDiaPTec[$i] = 0;
                                    }

                                    for ($i = 0; $i<count($datTargetDiaTecnicas); $i++){
                                        $dt = (int)$datTargetDiaTecnicas[$i][0];
                                        $targetDiaPTec[$dt] = $datTargetDiaTecnicas[$i][1];
                                    }

                                    for($i = 0 ;$i<count($datTecnicasDia);$i++){
                                        $d = (int)$datTecnicasDia[$i][0];
                                        $diaPTec[$i] = $datTecnicasDia[$i][0];
                                        $duracionDiaPTec[$d]= $datTecnicasDia[$i][1]; 
                                    }

                                    for ($i = 0; $i<count($datTargetMesTecnicas); $i++){
                                        $mt = (int)$datTargetMesTecnicas[$i][0];
                                        $targetMesPTec[$i] = $datTargetMesTecnicas[$i][1];
                                    }

                                    for($i = 0 ;$i<count($datTecnicasMes);$i++){
                                        $mesPTecnicas[$i] = $datTecnicasMes[$i][0]; //imprime el valor del mes

                                        switch ($mesPTecnicas[$i]){
                                            case 1:
                                                $mesCadenaPTec[$i] = (string) "'Enero'";
                                                break;
                                            case 2:
                                                $mesCadenaPTec[$i] = (string) "'Febrero'";
                                                break;
                                            case 3:
                                                $mesCadenaPTec[$i] = (string) "'Marzo'";
                                                break;
                                            case 4:
                                                $mesCadenaPTec[$i] = (string) "'Abril'";
                                                break;
                                            case 5:
                                                $mesCadenaPTec[$i] = (string) "'Mayo'";
                                                break;
                                            case 6:
                                                $mesCadenaPTec[$i] = (string) "'Junio'";
                                                break;
                                            case 7:
                                                $mesCadenaPTec[$i] = (string) "'Julio'";
                                                break;
                                            case 8:
                                                $mesCadenaPTec[$i] = (string) "'Agosto'";
                                                break;
                                            case 9:
                                                $mesCadenaPTec[$i] = (string) "'Septiembre'";
                                                break;
                                            case 10:
                                                $mesCadenaPTec[$i] = (string) "'Octubre'";
                                                break;
                                            case 11:
                                                $mesCadenaPTec[$i] = (string) "'Noviembre'";
                                                break;
                                            case 12:
                                                $mesCadenaPTec[$i] = (string) "'Diciembre'";
                                                break;                
                                        }
                                        //echo $mesPTecnicas[$i] ,' - ',$mesCadenaPTec[$i],'<br>';
                                        $duracionMesPTec[$i]= $datTecnicasMes[$i][1]; 
                                    }
                                ?>
                                
                                <form action="pTecnicas.php" method="POST">
                                    <div aling = "center" id="tecnicas" class = "perdidaTecnica">
                                        <script>
                                            chartCPU = new Highcharts.chart('tecnicas', {
                                            title: {
                                                text: 'Pérdidas Técnicas'
                                            },
                                            xAxis: {
                                                title: {
                                                    text: 'Día'
                                                },
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
                                                title: {
                                                    text: 'Duracion (Minutos)'
                                                },
                                            }],
                                            series: [{ //BARRAS CHUNDAS
                                                color: '#1A06AF',
                                                name: 'Indicadores',
                                                type: 'spline',
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1 ;$i < 32; $i++){
                                                        ?>
                                                        data.push([<?php echo $duracionDiaPTec[$i];?>]);
                                                        <?php } ?>
                                                        return data;
                                                    })()
                                            }, { //LINEA DE META
                                                name: 'Meta',
                                                color: '#2ECC71',
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1 ;$i < 32; $i++){
                                                        ?>
                                                        data.push([<?php echo $targetDiaPTec[$i];?>]);
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
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                        echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$year.">";
                                    ?>
                                    <button id="plain">Detalle T&eacute;cnicas</button>
                                </form>
                            </td>
                        </tr>
                        <!--Second row-->
                        <tr>
                            <td><!-- Gráfica de perdidas organizacionales -->
                                <?php
                                    $datOrgDia = pOrganizacionalesDia($line, $month);
                                    $datOrgMes = pOrganizacionalesMes($line, $year);
                                    $datTargetMesOrg = targetMesOrganizacionales($line, $year);
                                    $datTargetDiaOrg = targetDiaOrganizacionales($line, $month, $year);

                                    $dia;
                                    $d;
                                    $mes;
                                    $duracionDia;
                                    $duracionMes;   
                                    $targetMesOrg;
                                    $targetDiaOrg;

                                    for ($i=1; $i<32; $i++){
                                        $dia[$i] = $i;
                                        $duracionDia[$i] = 0;
                                    }

                                    for ($i = 0; $i<count($datOrgDia); $i++){
                                        $d = (int) $datOrgDia[$i][0];
                                        $dia[$i] = $datOrgDia[$i][0];
                                        $duracionDia[$d]= $datOrgDia[$i][1]; 
                                    }

                                    for ($i = 0; $i<count($datOrgMes); $i++){
                                        $mes[$i] = $datOrgMes[$i][0];
                                        $duracionMes[$i]= $datOrgMes[$i][1]; 
                                    }

                                    for ($i = 0 ;$i<count($datTargetMesOrg);$i++){
                                        $targetMesOrg[$i] = $datTargetMesOrg[$i][1];
                                    }

                                    for ($i = 0 ;$i<count($datTargetDiaOrg);$i++){
                                        $targetDiaOrg[$i] = $datTargetDiaOrg[$i][1];
                                    }

                                ?>
                                <form action="pOrganizacionales.php" method="POST">
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
                                            series: [{ //LINEA META
                                                color: '#2ECC71',
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 0; $i < count($datTargetDiaOrg); $i++){
                                                        ?>
                                                        data.push([<?php echo $targetDiaOrg[$i];?>]);
                                                        <?php } ?>
                                                        return data;
                                                    })()
                                            }, { //BARRAS CHUNDAS
                                                color: '#1A06AF',
                                                name: 'Indicadores',
                                                type: 'spline',
                                                zIndex: 1,
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1; $i < 32; $i++){
                                                        ?>
                                                        data.push([<?php echo $duracionDia[$i];?>]);
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
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                        echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$year.">";
                                    ?>
                                    <button id="plain">Detalle Organizacionales</button>
                                </form>
                            </td>
                            <td><!-- Gráfica de perdidas por paros planeados -->
                                <?php
                                    $datPlaneadoDia = pPlaneadoDia($line, $month);
                                    $datPlaneadosMes = pPlaneadoMes($line, $year);
                                    $datTargetDiaPlaneados = targetDiaPlaneado($line, $month, $year);
                                    $datTargetMesPlaneados = targetMesPlaneado($line, $year);

                                    //$d;
                                    $diaPPlaneados;
                                    $mesPPlaneados;
                                    $duracionDiaPPlaneados;
                                    $duracionMesPPlaneados;       
                                    $targetDiaPlaneados;
                                    $targetMesPlaneados;


                                    for ($i=1; $i<32; $i++){
                                        $diaPPlaneados[$i] = $i;
                                        $duracionDiaPPlaneados[$i] = 0;
                                        $targetDiaPlaneados[$i] = 0;
                                    }   

                                    for($i = 0; $i<count($datPlaneadoDia);$i++){
                                        $d = (int) $datPlaneadoDia[$i][0];
                                        $diaPPlaneados[$i] = $datPlaneadoDia[$i][0];
                                        $duracionDiaPPlaneados[$d]= $datPlaneadoDia[$i][1]; 
                                    }

                                    for($i = 0 ;$i<count($datPlaneadosMes);$i++){
                                        $mesPPlaneados[$i] = $datPlaneadosMes[$i][0];
                                        switch ($mesPPlaneados[$i]){
                                            case 1:
                                                $mesCadenaPPlaneados[$i] = (string) "'Enero'";
                                                break;
                                            case 2:
                                                $mesCadenaPPlaneados[$i] = (string) "'Febrero'";
                                                break;
                                            case 3:
                                                $mesCadenaPPlaneados[$i] = (string) "'Marzo'";
                                                break;
                                            case 4:
                                                $mesCadenaPPlaneados[$i] = (string) "'Abril'";
                                                break;
                                            case 5:
                                                $mesCadenaPPlaneados[$i] = (string) "'Mayo'";
                                                break;
                                            case 6:
                                                $mesCadenaPPlaneados[$i] = (string) "'Junio'";
                                                break;
                                            case 7:
                                                $mesCadenaPPlaneados[$i] = (string) "'Julio'";
                                                break;
                                            case 8:
                                                $mesCadenaPPlaneados[$i] = (string) "'Agosto'";
                                                break;
                                            case 9:
                                                $mesCadenaPPlaneados[$i] = (string) "'Septiembre'";
                                                break;
                                            case 10:
                                                $mesCadenaPPlaneados[$i] = (string) "'Octubre'";
                                                break;
                                            case 11:
                                                $mesCadenaPPlaneados[$i] = (string) "'Noviembre'";
                                                break;
                                            case 12:
                                                $mesCadenaPPlaneados[$i] = (string) "'Diciembre'";
                                                break;                
                                        }
                                        $duracionMesPPlaneados[$i]= $datPlaneadosMes[$i][1];
                                    }

                                    for($i = 0; $i < count($datTargetDiaPlaneados); $i++){
                                        $d = (int) $datTargetDiaPlaneados[$i][0];
                                        $targetDiaPlaneados[$d] = $datTargetDiaPlaneados[$i][1];
                                    }

                                    for ($i = 0; $i < count($datTargetMesPlaneados); $i++){
                                        $targetMesPlaneados[$i] = $datTargetMesPlaneados [$i][1];
                                    }

                                ?>
                                <form action="pPlaneados.php" method="POST">
                                    <div aling = "center" id="parosPlaneados" class = "perdidaParosPlaneados">
                                        <script>
                                            chartCPU = new Highcharts.chart('parosPlaneados', {
                                            title: {
                                                text: 'Perdidas Por Paros Planeados'
                                            },
                                            xAxis: {
                                                title: {
                                                    text: 'Día'
                                                },
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
                                                title: {
                                                    text: 'Duración (Minutos)'
                                                },
                                            }],
                                            series: [{ //LINEA META
                                                color: '#2ECC71',
                                                name: 'Meta',
                                                 data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1; $i < 32; $i++){
                                                        ?>
                                                        data.push([<?php echo $targetDiaPlaneados[$i];?>]);
                                                        <?php } ?>
                                                        return data;
                                                    })()
                                            }, { //BARRAS CHUNDAS
                                                color: '#1A06AF',
                                                name: 'Indicadores',
                                                type: 'spline',
                                                zIndex: 1,
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1 ;$i<32;$i++){
                                                        ?>
                                                        data.push([<?php echo $duracionDiaPPlaneados[$i];?>]);
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
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                        echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$year.">";
                                    ?>
                                    <button id="plain">Detalle Paros Planeados</button>
                                </form>
                            </td>
                        </tr>
                        <!--Third row-->
                        <tr>
                            <td><!-- Gráfica de perdidas por cambios de modelo -->
                                <?php
                                $datCModDia= pCambioModDia($line, $month);
                                $datCModMes = pCambioModMes($line, $year);
                                $datTargetDiaCMod = targetDiaCambMod($line, $month, $year);
                                $datTargetMesCMod = targetMesCambMod($line, $year);

                                $d;
                                $dia;
                                $mes;
                                $duracionDia;
                                $duracionMes;  
                                $targetDiaCMod;
                                $targetMesCMod;

                                for ($i=1; $i<32; $i++){
                                    $dia[$i] = $i;
                                    $duracionDia[$i] = 0;
                                    $targetDiaCMod[$i] = 0;
                                }   

                                for($i = 0; $i<count($datCModDia);$i++){
                                    $d = (int) $datCModDia[$i][0];
                                    $dia[$i] = $datCModDia[$i][0];
                                    $duracionDia[$d]= $datCModDia[$i][1];             
                                }

                                for($i = 0 ;$i<count($datCModMes);$i++){
                                    $mes[$i] = $datCModMes[$i][0];

                                    switch ($mes[$i]){
                                        case 1:
                                            $mesCadenaPCamMod[$i] = (string) "'Enero'";
                                            break;
                                        case 2:
                                            $mesCadenaPCamMod[$i] = (string) "'Febrero'";
                                            break;
                                        case 3:
                                            $mesCadenaPCamMod[$i] = (string) "'Marzo'";
                                            break;
                                        case 4:
                                            $mesCadenaPCamMod[$i] = (string) "'Abril'";
                                            break;
                                        case 5:
                                            $mesCadenaPCamMod[$i] = (string) "'Mayo'";
                                            break;
                                        case 6:
                                            $mesCadenaPCamMod[$i] = (string) "'Junio'";
                                            break;
                                        case 7:
                                            $mesCadenaPCamMod[$i] = (string) "'Julio'";
                                            break;
                                        case 8:
                                            $mesCadenaPCamMod[$i] = (string) "'Agosto'";
                                            break;
                                        case 9:
                                            $mesCadenaPCamMod[$i] = (string) "'Septiembre'";
                                            break;
                                        case 10:
                                            $mesCadenaPCamMod[$i] = (string) "'Octubre'";
                                            break;
                                        case 11:
                                            $mesCadenaPCamMod[$i] = (string) "'Noviembre'";
                                            break;
                                        case 12:
                                            $mesCadenaPCamMod[$i] = (string) "'Diciembre'";
                                            break;                
                                    }
                                    $duracionMes[$i]= $datCModMes[$i][1];            
                                }

                                for ($i = 0; $i < count($datTargetDiaCMod); $i++){
                                    $targetDiaCMod[$i] = $datTargetDiaCMod[$i][1];
                                }

                                for ($i = 0; $i < count($datTargetMesCMod); $i++){
                                    $targetMesCMod[$i] = $datTargetMesCMod[$i][1];
                                }
                            ?>
                                <form action="pCModelo.php" method="POST">
                                    <div aling = "center" id="cambios" class = "perdidaCambioModelo">
                                        <script>
                                            chartCPU = new Highcharts.chart('cambios', {
                                            title: {
                                                text: 'Perdidas Por Cambio De Modelo'
                                            },
                                            xAxis: {
                                                title: {
                                                    text: 'Día'
                                                },
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
                                                title: {
                                                    text: 'Duracion (Minutos)'
                                                },
                                            }],
                                            series: [{ //LINEA META
                                                color: '#2ECC71',
                                                name: 'Meta',
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1 ;$i<32;$i++){
                                                        ?>
                                                        data.push([<?php echo $targetDiaCMod[$i];?>]);
                                                        <?php } ?>
                                                        return data;
                                                    })()

                                            }, { //BARRAS 
                                                color: '#1A06AF',
                                                name: 'Indicadores',
                                                type: 'spline',
                                                zIndex: 1,
                                                //data: [5, 5, 5, 7, 5]
                                                data: (function() {
                                                        var data = [];
                                                        <?php
                                                            for($i = 1 ;$i<32;$i++){
                                                        ?>
                                                        data.push([<?php echo $duracionDia[$i];?>]);
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
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                        echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$year.">";
                                    ?>
                                    <button id="plain">Detalle Cambios de Modelo</button>
                                </form>
                            </td>
                            <td><!-- Grafica de perdidas de calidad-->
                                <?php
                                $datCalidadDia= pCalidadDia($line, $month);
                                $datCalidadMes = pCalidadMes($line, $year);
                                $datTargetDiaCalidad = targetDiaCalidad($line, $month, $year);
                                $datTargetMesCalidad = targetMesCalidad($line, $year);

                                $d;
                                $dia;
                                $mes;
                                $duracionDia;
                                $duracionMes;    
                                $targetDiaCalidad;
                                $targetMesCalidad;

                                for ($i=1; $i<32; $i++){
                                    $dia[$i] = $i;
                                    $duracionDia[$i] = 0;
                                    $targetDiaCalidad[$i] = 0;
                                }   

                                for($i = 0; $i<count($datCalidadDia);$i++){
                                    $d = (int) $datCalidadDia[$i][0];
                                    $dia[$i] = $datCalidadDia[$i][0];
                                    $duracionDia[$d]= $datCalidadDia[$i][1]; 
                                }

                                for($i = 0 ;$i<count($datCalidadMes);$i++){
                                    $mes[$i] = $datCalidadMes[$i][0];

                                    switch ($mes[$i]){
                                        case 1:
                                            $mesCadenaPCalidad[$i] = (string) "'Enero'";
                                            break;
                                        case 2:
                                            $mesCadenaPCalidad[$i] = (string) "'Febrero'";
                                            break;
                                        case 3:
                                            $mesCadenaPCalidad[$i] = (string) "'Marzo'";
                                            break;
                                        case 4:
                                            $mesCadenaPCalidad[$i] = (string) "'Abril'";
                                            break;
                                        case 5:
                                            $mesCadenaPCalidad[$i] = (string) "'Mayo'";
                                            break;
                                        case 6:
                                            $mesCadenaPCalidad[$i] = (string) "'Junio'";
                                            break;
                                        case 7:
                                            $mesCadenaPCalidad[$i] = (string) "'Julio'";
                                            break;
                                        case 8:
                                            $mesCadenaPCalidad[$i] = (string) "'Agosto'";
                                            break;
                                        case 9:
                                            $mesCadenaPCalidad[$i] = (string) "'Septiembre'";
                                            break;
                                        case 10:
                                            $mesCadenaPCalidad[$i] = (string) "'Octubre'";
                                            break;
                                        case 11:
                                            $mesCadenaPCalidad[$i] = (string) "'Noviembre'";
                                            break;
                                        case 12:
                                            $mesCadenaPCalidad[$i] = (string) "'Diciembre'";
                                            break;                
                                    }
                                    $duracionMes[$i]= $datCalidadMes[$i][1];            
                                }

                                for ($i = 0; $i < count($datTargetDiaCalidad); $i++){
                                    $dt = (int) $datTargetDiaCalidad[$i][0];
                                    $targetDiaCalidad[$dt] = $datTargetDiaCalidad[$i][1];
                                }

                                for ($i = 0; $i < count($datTargetMesCalidad); $i++){
                                    //$mt = (int) $datTargetMesCalidad[$i][0];
                                    $targetMesCalidad[$i] = $datTargetMesCalidad[$i][1];
                                }

                            ?>
                                <form action="pCalidad.php" method="POST">
                                    <div aling = "center" id="calidad" class = "perdidaCalidad">
                                    <script>
                                        chartCPU = new Highcharts.chart('calidad', {
                                        title: {
                                            text: 'Perdidas de Calidad'
                                        },
                                        xAxis: {
                                            gridLineWidth: 1,
                                            title: {
                                                text: 'Día'
                                            },
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
                                            title: {
                                                text: 'Duracion (Munitos)'
                                            },
                                        }],
                                        series: [{ //LINEA CHUNDA
                                            color: '#2ECC71',
                                            name: 'Meta',
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $targetDiaCalidad[$i];?>]);
                                                    <?php } ?>
                                                    return data;
                                                })()
                                        }, { //BARRAS CHUNDAS
                                            color: '#1A06AF',
                                            name: 'Indicadores',
                                            type: 'spline',
                                            zIndex: 1,
                                            data: (function() {
                                                    var data = [];
                                                    <?php
                                                        for($i = 1 ;$i<32;$i++){
                                                    ?>
                                                    data.push([<?php echo $duracionDia[$i];?>]);
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
                                    <?php
                                        echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$line.">";
                                        echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$month.">";
                                        echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$year.">";
                                    ?>
                                    <button id="plain">Detalle Calidad</button>
                                </form>
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
                                                                color: '#2ECC71',
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
                                                                    lineWidth: 1,
                                                                    lineColor: '#2ECC71',
                                                                    fillColor: '#2ECC71'
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