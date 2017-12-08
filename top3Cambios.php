<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        
            <?php
            require_once("control.php");

            $rand = new BaseKPI();

            $dattop3 = $rand->t3CambioModelo();
                      
            $problemaCambio;
            $durCambio;
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $problemaCambio[$i] = $dattop3[$i][0];                
                $durCambio[$i]= $dattop3[$i][1]; 
            }
            
        ?>
    </head>
    
    <body>
        
        <h1 ALIGN=center id="titulo">TOP 3: Paros por Cambio de Modelo</h1>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%;"> 
                 <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Top 3: Cambio de Modelo'
                },
                xAxis: {
                    gridLineWidth: 1,
                    
                    categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop3);$i++){
                                ?>
                                data.push([<?php echo "'$problemaCambio[$i]'";?>]);
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
        
        <div id = "tabla" style="height: 22vh; width: 100vh; float: left;  margin: 0% 23%;">            
            <table>
                <thead>     
                    <tr style="background: #F2F2F2">
                        <th>Problema</span></th>
                        <th >Duraci&oacute;n</span></th>
                        
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once("control.php");

                        $rand = new BaseKPI();
                        $datTCambio= $rand->t3CambioModelo();    
                        $descripcion;       

                        for($i = 0; $i<count($datTCambio);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<2; $j++){
                                $descripcion[$i][$j] = $datTCambio[$i][$j];
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
