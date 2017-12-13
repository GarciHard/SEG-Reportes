<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <LINK REL=StyleSheet HREF="est.css" TYPE="text/css" MEDIA=screen>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <!--------CONSULTAS------------->
        <?php
            require_once 'ServerFunctions.php';
            $varLine = $_REQUEST['varLine'];
            $varMonth = $_REQUEST['varMonth'];
            $varYear = $_REQUEST['varYear'];
            $varMesStr = listarMeses();

            $datProdMes = pzasProdMes($varLine, $varYear);
            $datProdAnio = pzasProdAnual($varLine, $varMonth); 
            $datProdNoP = pzasProdNoParte($varLine, $varMonth, $varYear);
            $datProdNoPDia = pzasProdNoParteDia($varLine, $varMonth, $varYear);
            $datTargetProdAnio = targetProdAnio($varLine, $varYear);
            $datTargetProdMes = targetProdMes($varLine, $varYear);
                    
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
            
            for($i = 0 ;$i<count($datProdAnio);$i++){
                $anio[$i] = $datProdAnio[$i][0];
                $prodAnio[$i]= $datProdAnio[$i][1]; 
            }
            
            for ($i = 0; $i < count($datTargetProdAnio); $i++){
                $targetProdAnio[$i] = $datTargetProdAnio [$i][1];
            }
            
            for ($i = 0; $i < count($datTargetProdMes); $i++){
                $targetProdMes[$i] = $datTargetProdMes[$i][1];
            }

            for($i = 0 ;$i<count($datProdMes);$i++){
                $mes[$i] = $datProdMes[$i][0];
                
                switch ($mes[$i]){
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
                $prodMes[$i]= $datProdMes[$i][1]; 
            }
            
            for($i = 0; $i < 100; $i++){
                $noParte[$i] = (string) ''; 
            }
            
            //Para cachar los numero de parte por Mes
            for($i = 0; $i<count($datProdNoP);$i++){
                $noParte[$i] = (int) $datProdNoP[$i][0]; 
            }
            
            for($i = 0; $i < 26; $i++){
                for($j = 1; $j < 32; $j++){
                    $numPartCant[$j][$i] = (int) 0; 
                    $numPartDia [$j] = (int) 0;
                }
            }            
            
            for ($i = 0; $i<count($datProdNoPDia); $i++){
                $numPart[$i] = (int) $datProdNoPDia[$i][1]; // Numuero de Parte
            }
            
            for($i = 0; $i<count($datProdNoPDia);$i++){
                $d = $datProdNoPDia[$i][0];
                if($numPart[$i] == $noParte[0]){
                    $numPartCant[$d][0] = $datProdNoPDia[$i][2];
                } else if($numPart[$i] == $noParte[1]){
                    $numPartCant[$d][1] = $datProdNoPDia[$i][2];
                } else if($numPart[$i] == $noParte[2]){
                   $numPartCant[$d][2] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[3]){
                    $numPartCant[$d][3] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[4]){
                    $numPartCant[$d][4] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[5]){
                   $numPartCant[$d][5] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[6]){
                    $numPartCant[$d][6] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[7]){
                   $numPartCant[$d][7] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[8]){
                    $numPartCant[$d][8] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[9]){
                    $numPartCant[$d][9] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[10]){
                    $numPartCant[$d][10] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[11]){
                    $numPartCant[$d][11] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[12]){
                    $numPartCant[$d][12] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[12]){
                    $numPartCant[$d][13] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[13]){
                    $numPartCant[$d][14] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[14]){
                    $numPartCant[$d][15] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[15]){
                    $numPartCant[$d][16] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[16]){
                    $numPartCant[$d][17] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[17]){
                    $numPartCant[$d][18] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[18]){
                    $numPartCant[$d][19] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[19]){
                    $numPartCant[$d][20] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[20]){
                    $numPartCant[$d][21] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[21]){
                    $numPartCant[$d][22] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[22]){
                    $numPartCant[$d][23] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[23]){
                    $numPartCant[$d][24] = $datProdNoPDia[$i][2];
                }else if($numPart[$i] == $noParte[24]){
                    $numPartCant[$d][25] = $datProdNoPDia[$i][2];
                }
            }
            
        ?>
    </head>
    
<BODY>
    <h3 align=center id="titulo">
        Piezas Producidas
        <br>
        <?php echo "Linea: " . $varLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
    </h3>
    
    <!--------------GRAFICA----dia-------------->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/pareto.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <div id = "graficasSuperiores">
        <div aling = "center" id="anual" class="contenedor">
            <script>
                chartCPU = new Highcharts.chart('anual', {
                title: {
                    text: 'Piezas Producidas por Año'
                },
                xAxis: {
                    title: {
                        text: 'Año'
                    },
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datProdAnio);$i++){
                            ?>
                            data.push([<?php echo $anio[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Cantidad Pzas'
                    },
                    lineWidth: 1
                }],
                series: [ { //BARRAS DE PZAS PRODUCIDAD
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datProdAnio);$i++){
                            ?>
                            data.push([<?php echo $prodAnio[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA META
                    color: '#2ECC71',
                    type: 'spline',
                    name: 'Meta',
                    yAxis: 0,
                    zIndex: 0,
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTargetProdAnio);$i++){
                            ?>
                            data.push([<?php echo $targetProdAnio[$i];?>]);
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
        
        <div aling = "center" id="mensual" class="contenedor">
            <script>
                chartCPU = new Highcharts.chart('mensual', {
                title: {
                    text: 'Piezas Producidas por Mes '
                },
                xAxis: {
                    title: {
                        text: 'Mes'
                    },
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datProdMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaProd[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Cantidad Pzas'
                    },
                }],
                series: [{ //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    zIndex: 1,
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datProdMes);$i++){
                            ?>
                            data.push([<?php echo $prodMes[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA CHUNDA
                    color: '#2ECC71',
                    type: 'spline',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTargetProdMes);$i++){
                            ?>
                            data.push([<?php echo $targetProdMes[$i];?>]);
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
    
    <div id="graficaGrande">
        <div aling = "center" id="dia" class = "contenedor2">
            <script>                
                chartCPU = new Highcharts.chart('dia', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Piezas Producidas por Día'
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
            });//                
            </script> 
        </div>
    </div>
    
    <div id="tabla">  
        <table style="height: 48vh; width: 200vh; float: left;  margin: 0% 1%;">
            <thead>
            <tr style="background: #F2F2F2">
                <th>Día</th>
                    <th>Cliente</th>
                    <th>No. Parte</th>
                    <th>Cantidad Pzas Producidas</th>
                </tr>   
            </thead>
                
            <tbody>        
                <?php
                    require_once("ServerFunctions.php");

                    $datProducidasTabla = pzasProdTabla($varLine, $varMonth, $varYear);
                    $diaT;

                    for($i = 0; $i<count($datProducidasTabla);$i++){
                        echo "<tr>";
                        for ($j = 0; $j<4; $j++){
                            $diaT[$i][$j] = $datProducidasTabla[$i][$j];
                            echo "<td>";
                                echo $diaT[$i][$j];
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                ?>        
            </tbody>    
        </table>
    </div>

</BODY>

</html>