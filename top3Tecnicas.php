<HTML>
    <head>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
            <meta charset="utf-8">
            <!--------CONSULTAS------------->
            <?php
            require_once("control.php");

            $rand = new BaseKPI();

            $dattop3 = $rand->t3Tecnicas();
                      
            $problemaTec;
            $operacionTec;
            $opTec;
            $durTec;
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $operacionTec[$i] = $dattop3[$i][0];
                $problemaTec [$i] = $dattop3[$i][1];
                $opTec[$i] = (string) $operacionTec[$i]; //cambio de valor para imprimir operacionTecOrg
                $durTec[$i]= $dattop3[$i][2]; 
            }
            
        ?>
    </head>
    
    <body>
        
        <h1 ALIGN=center id="titulo">TOP 3: Paros Tecnicos</h1>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

            <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%;"> 
                 <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Top 3: Tecnicos'
                },
                xAxis: {
                    gridLineWidth: 1,                    
                    categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop3);$i++){
                                ?>
                                data.push([<?php echo "'$opTec[$i], $problemaTec[$i]'";?>]);
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
                            data.push([<?php echo $durTec[$i];?>]);
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
        
        <div  aling = "center" style="height: 10vh; width: 100vh; float: left;  margin: 0% 30%;">
            <div aling = "center" >
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
                        $datTTecnicas = $rand->t3Tecnicas();    
                        $descripcion;       

                        for($i = 0; $i<count($datTTecnicas);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<3; $j++){
                                $descripcion[$i][$j] = $datTTecnicas[$i][$j];
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
