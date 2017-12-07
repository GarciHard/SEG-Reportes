<HTML>
    <head>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
            <meta charset="utf-8">
            <!--------CONSULTAS------------->
            <?php
            require_once("control.php");

            $rand = new BaseKPI();

            $dattop3 = $rand->t3Calidad();
                  
            $problemaCalidad;
            $operacionCalidad;
            $opCalidad;
            $durCalidad;
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $operacionCalidad[$i] = $dattop3[$i][0];
                $opCalidad[$i] = (string) $operacionCalidad[$i]; //cambio de valor para imprimir operacionTecOrg
                $problemaCalidad[$i] = (string) $dattop3[$i][1];
                $durCalidad[$i]= $dattop3[$i][2]; 
            }
            
        ?>
    </head>
    
    <body>
        
        <h1 ALIGN=center id="titulo">TOP 3: Paros por Calidad</h1>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

            <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%;"> 
                 <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'TOP 3: Calidad'
                },
                xAxis: {
                    gridLineWidth: 1,
                    
                    categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i < 3; $i++){
                                ?>
                                data.push([<?php echo "'$problemaCalidad[$i]'";?>]);
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
                series: [{
                    name: 'Incidencia',
                    color: '#08088A',
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
        
        <div  aling = "center" id = "table-wrapperP">
            <div aling = "center" id="table-scrollP" class>
            <table class="pure-table pure-table-borderedP" >
                <thead>     
                    <tr>
                        <th><span class="textP">Operaci&oacute;n</span></th>
                        <th><span class="textP">Problema</span></th>
                        <th><span class="textP">Duraci&oacute;n</span></th>
                        
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once("control.php");

                        $rand = new BaseKPI();
                        $datTCalidad = $rand->t3Calidad();    
                        $descripcion;       

                        for($i = 0; $i<count($datTCalidad);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<3; $j++){
                                $descripcion[$i][$j] = $datTCalidad[$i][$j];
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
    </body>
</html>
