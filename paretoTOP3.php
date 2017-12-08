<HTML>
    <head>
       <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <!--------CONSULTAS------------->
            <?php
            require_once("control.php");

            $rand = new BaseKPI();

            $dattop5 = $rand->t5TecnicasYOrganizacionales();
            $dattop1 = $rand->t1pareto();
            $dattop3 = $rand->t3Calidad();
            
            $operacionTecOrg;
            $opTecOrg;
            $problemaTecOrg;
            $durTecOrg;
            
            $cambio;
            $cam;
            $durCambio;
            
            $problemaCalidad;
            $operacionCalidad;
            $durCalidad;
            
            for($i = 0 ;$i<count($dattop5);$i++){
                $operacionTecOrg[$i] = $dattop5[$i][0];
                $op[$i] = (string) $operacionTecOrg[$i]; //cambio de valor para imprimir operacionTecOrg
                $problemaTecOrg[$i] = (string) $dattop5[$i][1];
                $durTecOrg[$i]= $dattop5[$i][2]; 
            }
            
            for($i = 0 ;$i<count($dattop1);$i++){
                $cambio[$i] = $dattop1[$i][0];
                $durCambio[$i]= $dattop1[$i][2]; 
            }
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $operacionCalidad[$i] = $dattop3[$i][0];
                $problemaCalidad[$i] = $dattop3[$i][1];
                $durCalidad[$i]= $dattop3[$i][2]; 
            }
            
        ?>
    </head>
    
    <body>
        
        <h1 ALIGN=center id="titulo">Pareto TOP</h1>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <div>
            <div aling = "center" id="ptto" style="height: 70vh; width: 95vh; float: left;  margin: 0% 1%;"> 
                <script>
                    chartCPU = new  Highcharts.chart('ptto', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'TOP 5: Técnicos y Organizacionales'
                    },
                    xAxis: {
                        gridLineWidth: 1,
                        categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop5);$i++){
                                ?>
                                data.push([<?php echo "'$problemaTecOrg[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Duracion (minutos)'
                        }
                    },
                    legend: {
                        reversed: true
                    }, 
                    tooltip: {
                        valueSuffix: ' min'
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'

                        }
                    },
                    series: [{
                        name: 'Incidencia',
                        color: '#1A06AF',
                        data: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop5);$i++){
                                ?>
                                data.push([<?php echo $durTecOrg[$i];?>]);
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
        
        
        <div aling = "center" id="derecha" class="pderecha">
            <div aling = "center"  id="ptcm" style="height: 30vh; width: 95vh; float: left;  margin: 0% 1%;">  
                <script>
                    chartCPU = new  Highcharts.chart('ptcm', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Top 1: Cambio de Modelo'
                    },
                    xAxis: {
                        gridLineWidth: 1,
                        categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($dattop1);$i++){
                            ?>
                            data.push([<?php echo "'$cambio[$i]'";?>]);
                            <?php } ?>
                            return data;
                        })()
                        
                        
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Duracion (minutos)'
                        }
                    },
                    legend: {
                        reversed: true
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' min'
                    },
                    series: [{
                        name: 'Incidencia',
                        color: '#1A06AF',
                        data: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop1);$i++){
                                ?>
                                data.push([<?php echo $durCambio[$i];?>]);
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

            <div aling = "center" id="ptc" style="height: 40vh; width: 95vh; float: left;  margin: 0% 1%;">
                <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Top 3: Calidad'
                },
                xAxis: {
                    gridLineWidth: 1,
                    categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop3);$i++){
                                ?>
                                data.push([<?php echo "'$operacionCalidad[$i], $problemaCalidad[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Duracion (minutos)'
                    }
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                tooltip: {
                    valueSuffix: ' min'
                },
                series: [{
                    name: 'Incidencia',
                    color: '#1A06AF',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($dattop3);$i++){
                            ?>
                            data.push([<?php echo $durCalidad[$i];?>]);
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
        
        <div>
            <div id = "tablaTop5" style="height: 115 vh; width: 95vh;  margin: 0% 1%;" > 
                <table style="height: 45vh; width: 100vh; float: left;  margin: 0% 0%;" >
                    <thead>     
                        <tr style="background: #F2F2F2">
                            <th><span class="textP">Operaci&oacute;n</span></th>
                            <th><span class="textP">Problema</span></th>
                            <th><span class="textP">Duraci&oacute;n</span></th>
                        </tr>
                    </thead>
                    <tbody>        
                        <?php
                            require_once("control.php");

                            $rand = new BaseKPI();
                            $datTop5pareto = $rand->t5TecnicasYOrganizacionales();    
                            $descripcion;       

                            for($i = 0; $i<count($datTop5pareto);$i++){
                                echo "<tr>";
                                for ($j = 0; $j<3; $j++){
                                    $descripcion[$i][$j] = $datTop5pareto[$i][$j];
                                    echo "<td>";
                                        echo $descripcion[$i][$j];
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                        ?>        
                    </tbody> 
                </table>
            </div>  
            
            <div aling = "center" >                
                <div id = "tablaTop1" style="height: 30vh; width: 95vh; float: left;  margin: 0% 1%;" >   
                    <table style="height: 11vh; width: 97vh; float: left;  margin: 0% 0%;" >
                        <thead>     
                            <tr style="background: #F2F2F2">
                                <th><span class="textP">Problema</span></th>
                                <th><span class="textP">Duraci&oacute;n</span></th>
                            </tr>
                        </thead>
                        <tbody>        
                            <?php
                                require_once("control.php");

                                $rand = new BaseKPI();
                                $datTop1Pareto = $rand->t1pareto();    
                                $descripcion;       

                                for($i = 0; $i<count($datTop1Pareto);$i++){
                                    echo "<tr>";
                                    for ($j = 0; $j<2; $j++){
                                        $descripcion[$i][$j] = $datTop1Pareto[$i][$j];
                                        echo "<td>";
                                            echo $descripcion[$i][$j];
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>        
                        </tbody> 
                    </table>
                </div>  
            
                <div id = "tablaTop3" style="height: 30vh; width: 95vh; float: left;  margin: -5.4% 1%;" >        
                    <table style="height: 26vh; width: 97vh; margin: 0% 0%;" >
                        <thead>     
                            <tr style="background: #F2F2F2">
                                <th><span class="textP">Operaci&oacute;n</span></th>
                                <th><span class="textP">Problema</span></th>
                                <th><span class="textP">Duraci&oacute;n</span></th>
                            </tr>
                        </thead>

                        <tbody>        
                            <?php
                                require_once("control.php");

                                $rand = new BaseKPI();
                                $datTop3pareto = $rand->t3Calidad();    
                                $descripcion;       

                                for($i = 0; $i<count($datTop3pareto);$i++){
                                    echo "<tr>";
                                    for ($j = 0; $j<3; $j++){
                                        $descripcion[$i][$j] = $datTop3pareto[$i][$j];
                                        echo "<td>";
                                            echo $descripcion[$i][$j];
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>        
                        </tbody> 
                    </table>
                </div>
            </div>
            
        </div>       
    </body>
</html>
