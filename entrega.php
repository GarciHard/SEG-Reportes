<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <meta charset="utf-8">
        <!--------CONSULTAS------------->
        <?php
            require_once("control.php");

            $rand = new BaseKPI();
        
            $datEntregaRealDia = $rand->pzasEntregaRealDia();
            $datEntregaEsperadaDia = $rand->pzasEntregaEsperadaDia();
            $datEntregaRealMes = $rand->pzasProdMes();
            $datTargetEntregaMensual = $rand->targetProdMes();
            $datEntregaRealAnio = $rand->pzasProdAnual();
            $datTargetEntregaAnio = $rand->targetProdAnio();
            
            //$datEntregaRealMes 
            $erd = (int) 0 ;
            $ard = (int) 0 ;
            $dia = (int) 0;
            $dia;
            $mes;
            $anio;
            $prodDia;
            $prodMes;
            $prodAnio;
            $targetEntregaMes;
            $targetEntregaAnio;  
            
            $entregaRealDia;
            $acumuladoRealDia;
            $entregaEsperadaDia;
            $acumuladoEsperadaDia;
            $entregaRealMes;
            $entregaRealAnio;
            

            for ($i = 1; $i < 32; $i++){                
                $prodDia[$i] = (int) 0;
                $entregaRealDia [$i] = (int) 0;
                $acumuladoRealDia[$i] = (int) 0;
                $entregaEsperadaDia[$i] = (int) 0;
                $acumuladoEsperadaDia[$i] = (int) 0;
            }
            
            for ($i = 0; $i < count($datEntregaRealDia); $i++){ 
                $dia = $datEntregaRealDia[$i][0];
                $entregaRealDia[$dia] = $datEntregaRealDia[$i][1]; 
            }
            
            for ($i = 0; $i < count($datEntregaEsperadaDia); $i++){ 
                $dia = $datEntregaEsperadaDia[$i][0];
                $acumuladoEsperadaDia[$dia] = $datEntregaEsperadaDia[$i][1]; 
            }
            
            for ($i = 1; $i < 32; $i++){
                $acumuladoRD[$i] = $ard + $erd;
                $erd = $entregaRealDia[$i];  
                $ard = $acumuladoRD[$i];
                $acumuladoRealDia[$i] = $acumuladoRD[$i]+$entregaRealDia[$i];
            }
               
            for($i = 0 ;$i<count($datEntregaRealAnio);$i++){
                $anio[$i] = $datEntregaRealAnio[$i][0];
                $entregaRealAnio[$i]= $datEntregaRealAnio[$i][1]; 
            }
            
            for($i = 0; $i < count($datTargetEntregaAnio);$i++){
                $targetEntregaAnio[$i] = $datTargetEntregaAnio[$i][1];
            }

            for($i = 0 ;$i<count($datEntregaRealMes);$i++){
                $mes[$i] = $datEntregaRealMes[$i][0];
                switch ($mes[$i]){
                    case 1:
                        $mesCadena[$i] = (string) "'Enero'";
                        break;
                    case 2:
                        $mesCadena[$i] = (string) "'Febrero'";
                        break;
                    case 3:
                        $mesCadena[$i] = (string) "'Marzo'";
                        break;
                    case 4:
                        $mesCadena[$i] = (string) "'Abril'";
                        break;
                    case 5:
                        $mesCadena[$i] = (string) "'Mayo'";
                        break;
                    case 6:
                        $mesCadena[$i] = (string) "'Junio'";
                        break;
                    case 7:
                        $mesCadena[$i] = (string) "'Julio'";
                        break;
                    case 8:
                        $mesCadena[$i] = (string) "'Agosto'";
                        break;
                    case 9:
                        $mesCadena[$i] = (string) "'Septiembre'";
                        break;
                    case 10:
                        $mesCadena[$i] = (string) "'Octubre'";
                        break;
                    case 11:
                        $mesCadena[$i] = (string) "'Noviembre'";
                        break;
                    case 12:
                        $mesCadena[$i] = (string) "'Diciembre'";
                        break;                
                }    
                $entregaRealMes[$i] = $datEntregaRealMes[$i][1];
            }
            
            for($i = 0; $i < count($datTargetEntregaMensual);$i++){
                $targetEntregaMes[$i] = $datTargetEntregaMensual[$i][1];
            }
            
        ?>
    </head>
    
<BODY>
    <h1 ALIGN=center id="titulo">Entregas</h1>
    
    <!--------------GRAFICA----dia-------------->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/pareto.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    
    <div id = "graficasSuperiores">
        <div aling = "center" id="anual" class="contenedor">
            <script>
                chartCPU = new Highcharts.chart('anual', {
                title: {
                    text: 'Entregas Anuales'
                },
                xAxis: {
                        title: {
                            text: 'Año'
                        },      
                        gridLineWidth: 1,
                        categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datEntregaRealAnio);$i++){
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
                }],
                tooltip: {
                    valueSuffix: ' Pzas'
                },
                series: [{ //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores', 
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datEntregaRealAnio);$i++){
                            ?>
                            data.push([<?php echo $entregaRealAnio[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },{ //LINEA CHUNDA
                    type: 'spline',
                    name: 'Meta',
                    color: '#2ECC71',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTargetEntregaAnio);$i++){
                            ?>
                            data.push([<?php echo $targetEntregaAnio[$i];?>]);
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
                    text: 'Entregas Mensuales'
                },
                xAxis: {
                    title: {
                        text: 'Mes'
                    },      
                    gridLineWidth: 1,
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datEntregaRealMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadena[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Cantidad Pzas'
                    },      
                }],
                tooltip: {
                    valueSuffix: ' Pzas'
                },
                series: [{ //BARRAS pzas
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datEntregaRealMes);$i++){
                            ?>
                            data.push([<?php echo $entregaRealMes[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA meta
                    type: 'spline',
                    name: 'Meta',
                    color: '#2ECC71',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTargetEntregaMensual);$i++){
                            ?>
                            data.push([<?php echo $targetEntregaMes[$i];?>]);
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
                        }                        
                    }]
                }                
            });
            </script> 
        </div>
    </div>
    
    <div id="graficaGrande" style="height: 70vh; width: 200vh; float: left;  margin: 0% 0%;">
        <script>
            chartCPU = new Highcharts.chart('graficaGrande', {
                chart: {
                    zoomType: 'xy'
                },
                title: {
                    text: 'Entregas Diarias'
                },                
                xAxis: [{
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
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        //format: '{value} pzas',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: 'Cantidad Acumulada',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true
                }, { // Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: 'Piezas',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        //format: '{value} pzas',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }, { visible: false}],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 105,
                    verticalAlign: 'top',
                    y: 40,
                    floating: true,
                },
                series: [{
                    name: 'Produccion Actual (Día)',
                    color: '#1A06AF',
                    type: 'column',
                    yAxis: 1,
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i < 32;$i++){
                            ?>
                            data.push([<?php echo $entregaRealDia[$i];?>]);
                            <?php } ?>
                            return data;
                        })(),
                    tooltip: {
                        valueSuffix: ' pzas'
                    }

                }, {
                    name: 'Acumulado Planeado',
                    color: '#000000',
                    type: 'spline',
                    yAxis: 2,
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i < 32;$i++){
                            ?>
                            data.push([<?php echo $acumuladoEsperadaDia[$i];?>]);
                            <?php } ?>
                            return data;
                        })(),
                    marker: {
                        enabled: false
                    },
                    dashStyle: 'shortdot',
                    tooltip: {
                        valueSuffix: ' pzas'
                    }

                }, {
                    name: 'Acumulado Real',
                    color: '#2ECC71',
                    type: 'spline',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i < 32;$i++){
                            ?>
                            data.push([<?php echo $acumuladoRealDia[$i];?>]);
                            <?php } ?>
                            return data;
                        })(),
                    tooltip: {
                        valueSuffix: ' pzas'
                    }
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

    <div id="tabla">
        
    </div>

</BODY>

</html>