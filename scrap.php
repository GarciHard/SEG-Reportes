<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <meta charset="utf-8">
        <!--------CONSULTAS------------->
        <?php
            require_once("control.php");

            $rand = new BaseKPI();

            $datScrapDia = $rand->scrapDia();
            $datScrapMes = $rand->scrapMes();
            $datScrapAnio = $rand->scrapAnual();
            $datTargetAnioScrap = $rand->targetAnioScrap();
            $datTargetMesScrap = $rand->targetMesScrap();
            $datTargetDiaScrap = $rand->targetDiaScrap();

            $dia;
            $mes;
            $anio;
            $prodDia;
            $prodMes;
            $prodAnio;
            $targetDiaScrap;
            $targetMesScrap;
            $targetAnioScrap;            

            for ($i = 1; $i < 32; $i++){
                $dia[$i] = (int) 0;
                $prodDia[$i] = (int) 0;
                $targetDiaScrap [$i] = (int) 0;
            }
            
            for($i = 0 ;$i<count($datScrapAnio);$i++){
                $anio[$i] = $datScrapAnio[$i][0];
                $prodAnio[$i]= $datScrapAnio[$i][1]; 
            }

            for($i = 0 ;$i<count($datScrapDia);$i++){
                $d = $datScrapDia[$i][0];
                $dia[$i] = $datScrapDia[$i][0];
                $prodDia[$d]= $datScrapDia[$i][1];
            }

            for($i = 0 ;$i<count($datScrapMes);$i++){
                $mes[$i] = $datScrapMes[$i][0];
                switch ($mes[$i]){
                    case 1:
                        $mesCadenaScrap[$i] = (string) "'Enero'";
                        break;
                    case 2:
                        $mesCadenaScrap[$i] = (string) "'Febrero'";
                        break;
                    case 3:
                        $mesCadenaScrap[$i] = (string) "'Marzo'";
                        break;
                    case 4:
                        $mesCadenaScrap[$i] = (string) "'Abril'";
                        break;
                    case 5:
                        $mesCadenaScrap[$i] = (string) "'Mayo'";
                        break;
                    case 6:
                        $mesCadenaScrap[$i] = (string) "'Junio'";
                        break;
                    case 7:
                        $mesCadenaScrap[$i] = (string) "'Julio'";
                        break;
                    case 8:
                        $mesCadenaScrap[$i] = (string) "'Agosto'";
                        break;
                    case 9:
                        $mesCadenaScrap[$i] = (string) "'Septiembre'";
                        break;
                    case 10:
                        $mesCadenaScrap[$i] = (string) "'Octubre'";
                        break;
                    case 11:
                        $mesCadenaScrap[$i] = (string) "'Noviembre'";
                        break;
                    case 12:
                        $mesCadenaScrap[$i] = (string) "'Diciembre'";
                        break;                
                }
                $prodMes[$i]= $datScrapMes[$i][1]; 
            }
            
            for($i = 0; $i < count($datTargetDiaScrap);$i++){
                $dt = $datTargetDiaScrap[$i][0];
                $targetDiaScrap[$dt] = $datTargetDiaScrap[$i][1];
            }
            
            for($i = 0; $i < count($datTargetMesScrap);$i++){
                $mt = $datTargetMesScrap[$i][1];
                $targetMesScrap[$i] = $datTargetMesScrap[$i][1];
            }
            
            for($i = 0; $i < count($datTargetAnioScrap);$i++){
                $targetAnioScrap[$i] = $datTargetAnioScrap[$i][1];
            }
            
        ?>
    </head>
    
<BODY>
    <h1 ALIGN=center id="titulo">Seguimiento de Scrap</h1>
    
    <!--------------GRAFICA----dia-------------->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/pareto.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <div id = "graficasSuperiores">
        <div aling = "center" id="anual" class="contenedor">
            <script>
                chartCPU = new Highcharts.chart('anual', {
                title: {
                    text: 'Scrap por Año'
                },
                xAxis: {
                        title: {
                            text: 'Año'
                        },      
                        gridLineWidth: 1,
                        categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datScrapAnio);$i++){
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
                    valueSuffix: ' Pzs'
                },
                series: [{ //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores', 
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datScrapAnio);$i++){
                            ?>
                            data.push([<?php echo $prodAnio[$i];?>]);
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
                                for($i = 0 ;$i<count($datScrapAnio);$i++){
                            ?>
                            data.push([<?php echo $targetAnioScrap[$i];?>]);
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
                    text: 'Scrap por Mes'
                },
                xAxis: {
                    title: {
                        text: 'Mes'
                    },      
                    gridLineWidth: 1,
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datScrapMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaScrap[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Cantidad Pzs'
                    },      
                }],
                tooltip: {
                    valueSuffix: ' Pzs'
                },
                series: [{ //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datScrapMes);$i++){
                            ?>
                            data.push([<?php echo $prodMes[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA CHUNDA
                    type: 'spline',
                    name: 'Meta',
                    color: '#2ECC71',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datScrapMes);$i++){
                            ?>
                            data.push([<?php echo $targetMesScrap[$i];?>]);
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
                  type: 'scatter'  
                },
                title: {
                    text: 'Scrap por Día'
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
                tooltip: {
                    valueSuffix: ' Pzs'
                },
                yAxis: [{
                    title: {
                        text: 'Cantidad Pzs'
                    },      
                }],
                series: [{ //BARRAS CANTIDAD DE SCRAP POR DIA
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 32; $i++){
                            ?>
                            data.push([<?php echo $prodDia[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA META
                    type: 'spline',
                    name: 'Meta',
                    color: '#2ECC71',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 32; $i++){
                            ?>
                            data.push([<?php echo $targetDiaScrap[$i];?>]);
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
    
    <div id="tabla">
        
    </div>

</BODY>

</html>