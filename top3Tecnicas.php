<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <?php
            require_once 'ServerFunctions.php';
            $pLine = $_REQUEST['pLine'];
            $pMonth = $_REQUEST['pMonth'];
            $pYear = $_REQUEST['pYear'];
            $varMesStr = listarMeses();

            $dattop3 = t3Tecnicas($pLine,$pMonth);
                      
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
        <h3 align=center id="titulo">
        TOP 3: Paros Técnicos
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
                    text: 'Top 3: Técnicos'
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
        
        <div  aling = "center">
            <table style="height: 28vh; width: 130vh; float: left;  margin: 0% 17%;" >
                <thead>     
                    <tr style="background: #F2F2F2">
                        <th><span class="textP">Operaci&oacute;n</span></th>
                        <th><span class="textP">Problema</span></th>
                        <th><span class="textP">Duraci&oacute;n</span></th> 
                    </tr>
                </thead>

                <tbody>        
                    <?php
                       require_once 'ServerFunctions.php';
                        $pLine = $_REQUEST['pLine'];
                        $pMonth = $_REQUEST['pMonth'];
                        $pYear = $_REQUEST['pYear'];
                        
                        $datTTecnicas = t3Tecnicas($pLine,$pMonth);    
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
    </body>
</html>
