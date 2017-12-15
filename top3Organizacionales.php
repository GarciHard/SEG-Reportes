<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        
            <!--------CONSULTAS------------->
            <?php
            require_once 'ServerFunctions.php';
            $pLine = $_REQUEST['pLine'];
            $pMonth = $_REQUEST['pMonth'];
            $pYear = $_REQUEST['pYear'];
            $varMesStr = listarMeses();

            $dattop3 = t3Organizacionales($pLine,$pMonth);
                      
            $problemaOrg;
            $detalleMatOrg;
            $durOrg;
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $problemaOrg[$i] = $dattop3[$i][0];                
                $detalleMatOrg[$i] = $dattop3[$i][1];
                $durOrg[$i]= $dattop3[$i][2]; 
            }
            
        ?>
    </head>
    
    <body>
        <h3 align=center id="titulo">
        TOP 3: Paros Organizacionales
        <br>
        <?php echo "Linea: " . $pLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$pMonth - 1] ?>
        </h3>
        
        <form action="top3OrganizacionalesFrec.php" method="POST">
            <?php
                echo "<input type="."\"hidden\" name="."\"pLine\""."value=".$pLine.">";
                echo "<input type="."\"hidden\" name="."\"pMonth\""."value=".$pMonth.">";
                echo "<input type="."\"hidden\" name="."\"pYear\""."value=".$pYear.">";
            ?>
            <button id="plain" style="height: 4vh; width: 13vh;  float:right; margin: -1% 0%;">Frecuencia</button>
        </form> 
        
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%;"> 
            <script>
            chartCPU = new  Highcharts.chart('ptc', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Top 3: Organizacionales (Duración)'
            },
            xAxis: {
                gridLineWidth: 1,

                categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($dattop3);$i++){
                            ?>
                            data.push([<?php echo "'$problemaOrg[$i]'";?>]);
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
                        data.push([<?php echo $durOrg[$i];?>]);
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
            <table style="height: 24vh; width: 130vh; float: left;  margin: 0% 17%;" >
                <thead>     
                    <tr style="background: #F2F2F2">
                        <th>Problema</span></th>
                        <th>Detalle Material</span></th>
                        <th>Duraci&oacute;n</span></th>
                        
                    </tr>
                </thead>

                <tbody>        
                    <?php
                       require_once 'ServerFunctions.php';
                        $pLine = $_REQUEST['pLine'];
                        $pMonth = $_REQUEST['pMonth'];
                        $pYear = $_REQUEST['pYear'];
            
                        $datTOrg = t3Organizacionales($pLine,$pMonth);    
                        $descripcion;       

                        for($i = 0; $i<count($datTOrg);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<3; $j++){
                                $descripcion[$i][$j] = $datTOrg[$i][$j];
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
