<HTML>
    <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--------CONSULTAS------------->
    <?php
        require_once 'ServerFunctions.php';
        $varLine = $_REQUEST['varLine'];
        $varMonth = $_REQUEST['varMonth'];
        $varYear = $_REQUEST['varYear'];
        
        $datCalidadDia= pCalidadDia($varLine, $varMonth);
        $datCalidadMes = pCalidadMes($varLine, $varYear);
        $datTargetDiaCalidad = targetDiaCalidad($varLine, $varMonth, $varYear);
        $datTargetMesCalidad = targetMesCalidad($varLine, $varYear);

        $d;
        $dia;
        $mes;
        $duracionDia;
        $duracionMes;    
        $targetDiaCalidad;
        $targetMesCalidad;

        for ($i=1; $i<32; $i++){
            $dia[$i] = $i;
            $duracionDia[$i] = 0;
            $targetDiaCalidad[$i] = 0;
        }   
        
        for($i = 0; $i<count($datCalidadDia);$i++){
            $d = (int) $datCalidadDia[$i][0];
            $dia[$i] = $datCalidadDia[$i][0];
            $duracionDia[$d]= $datCalidadDia[$i][1]; 
        }
                   
        for($i = 0 ;$i<count($datCalidadMes);$i++){
            $mes[$i] = $datCalidadMes[$i][0];
            
            switch ($mes[$i]){
                case 1:
                    $mesCadenaPCalidad[$i] = (string) "'Enero'";
                    break;
                case 2:
                    $mesCadenaPCalidad[$i] = (string) "'Febrero'";
                    break;
                case 3:
                    $mesCadenaPCalidad[$i] = (string) "'Marzo'";
                    break;
                case 4:
                    $mesCadenaPCalidad[$i] = (string) "'Abril'";
                    break;
                case 5:
                    $mesCadenaPCalidad[$i] = (string) "'Mayo'";
                    break;
                case 6:
                    $mesCadenaPCalidad[$i] = (string) "'Junio'";
                    break;
                case 7:
                    $mesCadenaPCalidad[$i] = (string) "'Julio'";
                    break;
                case 8:
                    $mesCadenaPCalidad[$i] = (string) "'Agosto'";
                    break;
                case 9:
                    $mesCadenaPCalidad[$i] = (string) "'Septiembre'";
                    break;
                case 10:
                    $mesCadenaPCalidad[$i] = (string) "'Octubre'";
                    break;
                case 11:
                    $mesCadenaPCalidad[$i] = (string) "'Noviembre'";
                    break;
                case 12:
                    $mesCadenaPCalidad[$i] = (string) "'Diciembre'";
                    break;                
            }
            $duracionMes[$i]= $datCalidadMes[$i][1];            
        }
        
        for ($i = 0; $i < count($datTargetDiaCalidad); $i++){
            $dt = (int) $datTargetDiaCalidad[$i][0];
            $targetDiaCalidad[$dt] = $datTargetDiaCalidad[$i][1];
        }
        
        for ($i = 0; $i < count($datTargetMesCalidad); $i++){
            //$mt = (int) $datTargetMesCalidad[$i][0];
            $targetMesCalidad[$i] = $datTargetMesCalidad[$i][1];
        }
        
    ?>
    
<BODY>
    <h1 ALIGN=center id="titulo">Paros por Calidad</h1>
    <form action="top3Calidad.php" method="POST">
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
                    text: 'Minutos con Falla por Mes'
                },
                xAxis: {
                    title: {
                        text: 'Mes'
                    },
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datCalidadMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaPCalidad[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Munitos)'
                    },
                }],
                series: [ { //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datCalidadMes);$i++){
                            ?>
                            data.push([<?php echo $duracionMes[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA CHUNDA
                    color: '#2ECC71',
                    type: 'spline',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datCalidadMes);$i++){
                            ?>
                            data.push([<?php echo $targetMesCalidad[$i];?>]);
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
                    text: 'Minutos con Falla por Día'
                },
                xAxis: {
                    gridLineWidth: 1,
                    title: {
                        text: 'Día'
                    },
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
                        text: 'Duracion (Munitos)'
                    },
                }],
                series: [{ //LINEA CHUNDA
                    color: '#2ECC71',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i<32;$i++){
                            ?>
                            data.push([<?php echo $targetDiaCalidad[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'spline',
                    zIndex: 1,
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
                    <th><span class="text">Oper&aacute;cion</span></th>
                    <th><span class="text">Pobl&eacute;ma</span></th>
                    <th><span class="text">Durac&iacute;on</span></th>
                </tr>
            </thead>

            <tbody>        
                <?php
                    require_once 'ServerFunctions.php';

                    $datCalidadTabla = pCalidadTabla($varLine, $varMonth);
                    $diaT;       

                    for($i = 0; $i<count($datCalidadTabla);$i++){
                        echo "<tr>";
                        for ($j = 0; $j<4; $j++){
                            $diaT[$i][$j] = $datCalidadTabla[$i][$j];
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