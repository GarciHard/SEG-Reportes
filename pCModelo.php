<HTML>
    <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php
        require_once 'ServerFunctions.php';
        $varLine = $_REQUEST['varLine'];
        $varMonth = $_REQUEST['varMonth'];
        $varYear = $_REQUEST['varYear'];
        $varMesStr = listarMeses();

        $datCModDia= pCambioModDia($varLine, $varMonth);
        $datCModMes = pCambioModMes($varLine, $varYear);
        $datTargetDiaCMod = targetDiaCambMod($varLine, $varMonth, $varYear);
        $datTargetMesCMod = targetMesCambMod($varLine, $varYear);

        $d;
        $dia;
        $mes;
        $duracionDia;
        $duracionMes;  
        $targetDiaCMod;
        $targetMesCMod;

        for ($i=1; $i<32; $i++){
            $dia[$i] = $i;
            $duracionDia[$i] = 0;
            $targetDiaCMod[$i] = 0;
        }   
        
        for($i = 0; $i<count($datCModDia);$i++){
            $d = (int) $datCModDia[$i][0];
            $dia[$i] = $datCModDia[$i][0];
            $duracionDia[$d]= $datCModDia[$i][1];             
        }
                   
        for($i = 0 ;$i<count($datCModMes);$i++){
            $mes[$i] = $datCModMes[$i][0];
            
            switch ($mes[$i]){
                case 1:
                    $mesCadenaPCamMod[$i] = (string) "'Enero'";
                    break;
                case 2:
                    $mesCadenaPCamMod[$i] = (string) "'Febrero'";
                    break;
                case 3:
                    $mesCadenaPCamMod[$i] = (string) "'Marzo'";
                    break;
                case 4:
                    $mesCadenaPCamMod[$i] = (string) "'Abril'";
                    break;
                case 5:
                    $mesCadenaPCamMod[$i] = (string) "'Mayo'";
                    break;
                case 6:
                    $mesCadenaPCamMod[$i] = (string) "'Junio'";
                    break;
                case 7:
                    $mesCadenaPCamMod[$i] = (string) "'Julio'";
                    break;
                case 8:
                    $mesCadenaPCamMod[$i] = (string) "'Agosto'";
                    break;
                case 9:
                    $mesCadenaPCamMod[$i] = (string) "'Septiembre'";
                    break;
                case 10:
                    $mesCadenaPCamMod[$i] = (string) "'Octubre'";
                    break;
                case 11:
                    $mesCadenaPCamMod[$i] = (string) "'Noviembre'";
                    break;
                case 12:
                    $mesCadenaPCamMod[$i] = (string) "'Diciembre'";
                    break;                
            }
            $duracionMes[$i]= $datCModMes[$i][1];            
        }
        
        for ($i = 0; $i < count($datTargetDiaCMod); $i++){
            $targetDiaCMod[$i] = $datTargetDiaCMod[$i][1];
        }
        
        for ($i = 0; $i < count($datTargetMesCMod); $i++){
            $targetMesCMod[$i] = $datTargetMesCMod[$i][1];
        }
        
        
    ?>
    
<BODY>
    <h3 align=center id="titulo">
        Paros por Cambio de Modelo
        <br>
        <?php echo "Linea: " . $varLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
    </h3>
    <form action="top3Cambios.php" method="POST">
            <?php
                echo "<input type="."\"hidden\" name="."\"pLine\""."value=".$varLine.">";
                echo "<input type="."\"hidden\" name="."\"pMonth\""."value=".$varMonth.">";
                echo "<input type="."\"hidden\" name="."\"pYear\""."value=".$varYear.">";
            ?>
        <button id="plain" style="height: 4vh; width: 8vh;  float:right; margin: -4.2% 0%; background-color: #D7DBDD; border-radius: 6px; border: 2px solid #C0392B;">Top 3</button>
    </form> 
    
    <!--------------GRAFICA----dia-------------->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/pareto.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <div id = "graficasSuperiores">      
        <div aling = "center" id="mensual" class="arribaMes">
            <script>
                chartCPU = new Highcharts.chart('mensual', {
                title: {
                    text: 'Minutos por Mes '
                },
                xAxis: {
                    title: {
                        text: 'Mes'
                    },
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datCModMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaPCamMod[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Minutos)'
                    },
                }],
                series: [{ //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datCModMes);$i++){
                            ?>
                            data.push([<?php echo $duracionMes[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA META
                    color: '#2ECC71',
                    type: 'spline',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTargetMesCMod);$i++){
                            ?>
                            data.push([<?php echo $targetMesCMod[$i];?>]);
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
        
        <div aling = "center" id="dia" class = "arribaDiaMes">
            <script>
                chartCPU = new Highcharts.chart('dia', {
                title: {
                    text: 'Minutos por Día'
                },
                xAxis: {
                    title: {
                        text: 'Día'
                    },
                    gridLineWidth: 1,
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i<32;$i++){
                            ?>
                            data.push([<?php echo $i;?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Minutos)'
                    },
                }],
                series: [{ //LINEA META
                    color: '#2ECC71',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i<32;$i++){
                            ?>
                            data.push([<?php echo $targetDiaCMod[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                    
                }, { //BARRAS 
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'spline',
                    zIndex: 1,
                    //data: [5, 5, 5, 7, 5]
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i<32;$i++){
                            ?>
                            data.push([<?php echo $duracionDia[$i];?>]);
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
        <table style="height: 48vh; width: 200vh; float: left;  margin: 0% 1%;">
            <thead>
                <tr style="background: #F2F2F2">
                        <th><span class="text">D&iacute;a</span></th>
                        <th><span class="text">Ar&eacute;a</span></th>
                        <th><span class="text">Pobl&eacute;ma</span></th>
                        <th><span class="text">Duraci&oacute;n (Minutos)</span></th>
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once 'ServerFunctions.php';

                        $datCModTabla = pCambioModTabla($varLine, $varMonth);
                        $diaT;       

                        for($i = 0; $i<count($datCModTabla);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<4; $j++){
                                $diaT[$i][$j] = $datCModTabla[$i][$j];
                                echo "<td>";
                                    echo $diaT[$i][$j];
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                    ?>        
                </tbody> 
            </table>
    </div>
    
</BODY>

</html>