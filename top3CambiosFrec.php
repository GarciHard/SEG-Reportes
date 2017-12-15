<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        
            <?php
            require_once 'ServerFunctions.php';
            $pLine = $_REQUEST['pLine'];
            $pMonth = $_REQUEST['pMonth'];
            $pYear = $_REQUEST['pYear'];
            $varMesStr = listarMeses();

            $dattop3 = t3CambioModelo($pLine,$pMonth);
                      
            $problemaCambio;
            $durCambio;
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $problemaCambio[$i] = $dattop3[$i][0];                
                $durCambio[$i]= $dattop3[$i][1]; 
            }
            
        ?>
    </head>
    
    <body>
        <h3 align=center id="titulo">
        TOP 3: Paros por Cambio de Modelo
        <br>
        <?php echo "Linea: " . $pLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$pMonth - 1] ?>
        </h3>
               
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%;"> 
                 <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Top 3: Cambio de Modelo (Frecuencia)'
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
                            })(),
                    title: {
                        text: 'Problema'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Frecuencia'
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
                    name: 'Frecuencia',
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
                        <th >Frecuencia</span></th>
                        
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once 'ServerFunctions.php';
                        $pLine = $_REQUEST['pLine'];
                        $pMonth = $_REQUEST['pMonth'];
                        $pYear = $_REQUEST['pYear'];
                        
                        $datTCambio= t3CambioModeloFrec($pLine,$pMonth);    
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
