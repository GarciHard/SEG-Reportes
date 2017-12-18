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
            
            $varDiaI = 1;
            $varDiaF = 31;
            
            $dattop3 = t3Calidad($pLine,$pMonth);
            $diasArrObj = listarDiasMes($pLine,$pMonth,$pYear);
            
            $diasArr;
            $band = 0;
            $titulo [0] = "Top 3: Calidad (Duración)";
            
            $seleccionado = "";
            
            if (isset($_REQUEST["btnCalcular"])) {
                $pDiaI = isset($_POST['cmbDiaI']) ? $_POST['cmbDiaI'] : '';
                $pDiaF = isset($_POST['cmbDiaF']) ? $_POST['cmbDiaF'] : '';                
                
                if ($pDiaI == 'All' && $pDiaF == 'All'){
                    $pDiaI = 1;
                    $pDiaF = 31;
                } else if ($pDiaI == 'All' && $pDiaF != 'All' || $pDiaI != 'All' && $pDiaF == 'All' ) {
                    echo '<script language="javascript">alert("Debes seleccionar bien los dias");</script>'; 
                }
                
                $opcion = $_REQUEST["cmbOpcion"];
                if ($opcion == "1") {
                    $dattop3 = t3Calidad($pLine,$pMonth,$varDiaI,$varDiaF);
                    $band = 1;
                    $titulo [0] = "Top 3: Calidad (Duración)";
                } else if ($opcion == "2"){
                    $dattop3 = t3CalidadFrec($pLine,$pMonth,$varDiaI,$varDiaF);    
                    $band = 2;
                    $titulo [0] = "Top 3: Calidad (Frecuencia)";
                }                 
            }
            
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
            
            for ($i = 0; $i < count($diasArrObj); $i++) {
                $diasArr[$i] = $diasArrObj[$i][0];
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
        
        <FORM aling = "center" action="top3Calidad.php" method="POST" style=" height: 6vh; width: 120vh;  margin: -1% 40%;">            
            <label>Día: </label>
            <select id="diaI" name="cmbDiaI">
                <?php
                echo "<option>" . All . "</option>";
                for ($i = 0; $i < count($diasArrObj); $i++) {
                    if($diasArr[$i] == $pDiaI){
                        echo "<option value='".$i."' selected>".$diasArr[$i]."</option>";
                    }else{
                        echo "<option>" . $diasArr[$i] . "</option>";
                    }
                }
                ?>
            </select>  
            
            <label style="left: 50px"> al </label>
            <select id="diaF" name="cmbDiaF" >
                <?php
                echo "<option>" . All . "</option>";
                for ($i = 0; $i < count($diasArrObj); $i++) {
                    if($diasArr[$i] == $pDiaF){
                        echo "<option value='".$i."' selected>".$diasArr[$i]."</option>";
                    }else{
                        echo "<option>" . $diasArr[$i] . "</option>";
                    }
                }
                ?>
            </select>
            
            <select name="cmbOpcion" id="Opciones">
                //<?php
//                    if(){
//                        
//                    } else {
//                        
//                    }
//                ?>
                <option>Seleccione</option>
                <option value="1">Duración</option>
                <option value="2">Frecuencia </option>
            </select>
            <?php
                echo "<input type="."\"hidden\" name="."\"pLine\""."value=".$pLine.">";
                echo "<input type="."\"hidden\" name="."\"pMonth\""."value=".$pMonth.">";
                echo "<input type="."\"hidden\" name="."\"pYear\""."value=".$pYear.">";
            ?>
            <BUTTON name="btnCalcular">Calcular</BUTTON>
        </FORM>   
        
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <div aling = "center" id="ptc" style="height: 60vh; width: 140vh; float: left;  margin: 0% 10%; border: #08088A"> 
            <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {                    
                    text: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<1;$i++){
                                ?>
                                data.push([<?php echo "'$titulo[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
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
            <table  aling = "center" style="height: 24vh; width: 130vh; float: left;  margin: 0% 17%;" >
                <thead>     
                    <tr style="background: #F2F2F2">
                        <th><span class="textP">Operaci&oacute;n</span></th>
                        <th><span class="textP">Problema</span></th>
                        <?php
                            if($band == 2 ){
                                echo "<th>";
                                    echo 'Frecuencia';
                                echo "</th>";
                            } else {
                                echo "<th>";
                                    echo 'Duración';
                                echo "</th>";
                            }
                        ?>
                    </tr>
                </thead>

                <tbody>        
                    <?php
                       require_once 'ServerFunctions.php';
                        $pLine = $_REQUEST['pLine'];
                        $pMonth = $_REQUEST['pMonth'];
                        $pYear = $_REQUEST['pYear'];
                        
                        $descripcion;       

                        for($i = 0; $i<count($dattop3);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<3; $j++){
                                $descripcion[$i][$j] = $dattop3[$i][$j];
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
