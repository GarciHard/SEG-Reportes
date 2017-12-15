<HTML>
    <head>
        <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <!--------CONSULTAS------------->
            <?php
            require_once 'ServerFunctions.php';
            $pLine = $_REQUEST['pLine'];
            $pMonth = $_REQUEST['pMonth'];
            $pYear = $_REQUEST['pYear'];
            $varMesStr = listarMeses();

            $dattop3 = t3Calidad($pLine,$pMonth);
            $dias = listarDiasMes($pLine,$pMonth,$pYear);
            
            $diasArr;      
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
            
            for ($i = 0; $i < count($dias); $i++) {
                $diasArr[$i] = $dias[$i][0];
            }            
            
        ?>
    </head>
    
    <body>
        <h3 align=center id="titulo">
            TOP 3: Paros por Calidad
        <br>
        <?php echo "Linea: " . $pLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$pMonth - 1] ?>
        </h3>
        
        <form action="top3CalidadFrec.php" method="POST">
            <?php
                echo "<input type="."\"hidden\" name="."\"pLine\""."value=".$pLine.">";
                echo "<input type="."\"hidden\" name="."\"pMonth\""."value=".$pMonth.">";
                echo "<input type="."\"hidden\" name="."\"pYear\""."value=".$pYear.">";
            ?>
            <button id="plain" style="height: 4vh; width: 13vh;  float:right; margin: -1% 0%;">Frecuencia</button>
        </form>  
        
        
        <table>            
            <form action="MenuGraficas.php" method="POST">
                <caption>
                    <label>Día: </label>
                    <select id="diaI" name="cmbDiaI">
                        <?php
                        for ($i = 0; $i < count($diasArrObj); $i++) {
                            echo "<option>" . $diasArr[$i] . "</option>";
                        }
                        ?>
                    </select>      
                    <b> al </b>
                    <select id="diaF" name="cmbDiaF" >
                        <?php
                        for ($i = 0; $i < count($diasArrObj); $i++) {
                            echo "<option>" . $diasArr[$i] . "</option>";
                        }
                        ?>
                    </select>
                    <button>Calcular Gr&aacute;ficas</button>
                    <br><br>
                </caption>
            </form>
        </table>
        
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%;"> 
            <script>
            chartCPU = new  Highcharts.chart('ptc', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'TOP 3: Calidad (Duración)'
            },
            xAxis: {
                gridLineWidth: 1,

                categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i < 3; $i++){
                            ?>
                            data.push([<?php echo "'$opCalidad[$i], $problemaCalidad[$i]'";?>]);
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
                    text: 'Duración (minutos)'
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
                name: 'Duración',
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
        
        <div id = "tabla" style="height: 22vh; width: 100vh; float: left;  margin: 0% 23%;">            
            <table>
                <thead>     
                    <tr style="background: #F2F2F2">
                        <th>Operaci&oacute;n</span></th>
                        <th>Problema</span></th>
                        <th>Duraci&oacute;n</span></th>
                        
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once 'ServerFunctions.php';
                        $pLine = $_REQUEST['pLine'];
                        $pMonth = $_REQUEST['pMonth'];
                        $pYear = $_REQUEST['pYear'];
                        
                        
                        $datTCalidad = t3Calidad($pLine,$pMonth);    
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
    </body>
</html>
