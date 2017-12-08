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

        $datPlaneadoDia = pPlaneadoDia($varLine, $varMonth);
        $datPlaneadosMes = pPlaneadoMes($varLine, $varYear);
        $datTargetDiaPlaneados = targetDiaPlaneado($varLine, $varMonth, $varYear);
        $datTargetMesPlaneados = targetMesPlaneado($varLine, $varYear);

        //$d;
        $diaPPlaneados;
        $mesPPlaneados;
        $duracionDiaPPlaneados;
        $duracionMesPPlaneados;       
        $targetDiaPlaneados;
        $targetMesPlaneados;
        

        for ($i=1; $i<32; $i++){
            $diaPPlaneados[$i] = $i;
            $duracionDiaPPlaneados[$i] = 0;
            $targetDiaPlaneados[$i] = 0;
        }   
        
        for($i = 0; $i<count($datPlaneadoDia);$i++){
            $d = (int) $datPlaneadoDia[$i][0];
            $diaPPlaneados[$i] = $datPlaneadoDia[$i][0];
            $duracionDiaPPlaneados[$d]= $datPlaneadoDia[$i][1]; 
        }
                   
        for($i = 0 ;$i<count($datPlaneadosMes);$i++){
            $mesPPlaneados[$i] = $datPlaneadosMes[$i][0];
            switch ($mesPPlaneados[$i]){
                case 1:
                    $mesCadenaPPlaneados[$i] = (string) "'Enero'";
                    break;
                case 2:
                    $mesCadenaPPlaneados[$i] = (string) "'Febrero'";
                    break;
                case 3:
                    $mesCadenaPPlaneados[$i] = (string) "'Marzo'";
                    break;
                case 4:
                    $mesCadenaPPlaneados[$i] = (string) "'Abril'";
                    break;
                case 5:
                    $mesCadenaPPlaneados[$i] = (string) "'Mayo'";
                    break;
                case 6:
                    $mesCadenaPPlaneados[$i] = (string) "'Junio'";
                    break;
                case 7:
                    $mesCadenaPPlaneados[$i] = (string) "'Julio'";
                    break;
                case 8:
                    $mesCadenaPPlaneados[$i] = (string) "'Agosto'";
                    break;
                case 9:
                    $mesCadenaPPlaneados[$i] = (string) "'Septiembre'";
                    break;
                case 10:
                    $mesCadenaPPlaneados[$i] = (string) "'Octubre'";
                    break;
                case 11:
                    $mesCadenaPPlaneados[$i] = (string) "'Noviembre'";
                    break;
                case 12:
                    $mesCadenaPPlaneados[$i] = (string) "'Diciembre'";
                    break;                
            }
            $duracionMesPPlaneados[$i]= $datPlaneadosMes[$i][1];
        }
        
        for($i = 0; $i < count($datTargetDiaPlaneados); $i++){
            $d = (int) $datTargetDiaPlaneados[$i][0];
            $targetDiaPlaneados[$d] = $datTargetDiaPlaneados[$i][1];
        }
        
        for ($i = 0; $i < count($datTargetMesPlaneados); $i++){
            $targetMesPlaneados[$i] = $datTargetMesPlaneados [$i][1];
        }
        
    ?>
    
<BODY>
    <h1 ALIGN=center id="titulo">Paros Planeados</h1>
    
    <!--------------GRAFICA----diaPPlaneados-------------->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/pareto.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <div id = "graficasSuperiores">      
        <div aling = "center" id="mensual" class="arribaMes">
            <script>
                chartCPU = new Highcharts.chart('mensual', {
                title: {
                    text: 'Falla por Mes'
                },
                xAxis: {
                    title: {
                        text: 'Mes'
                    },
                    categories: (function() { //cambio de mes (Num) a mes (Cad)
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datPlaneadosMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaPPlaneados[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Minutos)'
                    },
                }],
                series: [{ //BARRAS DURACION
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datPlaneadosMes);$i++){
                            ?>
                            data.push([<?php echo $duracionMesPPlaneados[$i];?>]);
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
                                for($i = 0 ;$i<count($datPlaneadosMes);$i++){
                            ?>
                            data.push([<?php echo $targetMesPlaneados[$i];?>]);
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
        
        <div aling = "center" id="diaPPlaneados" class = "arribaDiaMes">
            <script>
                chartCPU = new Highcharts.chart('diaPPlaneados', {
                title: {
                    text: 'Fallas por Día'
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
                        text: 'Duración (Minutos)'
                    },
                }],
                series: [{ //LINEA META
                    color: '#2ECC71',
                    name: 'Meta',
                     data: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 32; $i++){
                            ?>
                            data.push([<?php echo $targetDiaPlaneados[$i];?>]);
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
                            data.push([<?php echo $duracionDiaPPlaneados[$i];?>]);
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
                    <th><span class="text">&Aacute;rea</span></th>
                    <th><span class="text">Duraci&oacute;n</span></th>
                </tr>
            </thead>

            <tbody>        
                <?php
                    require_once 'ServerFunctions.php';

                    $datPlaneadoTabla = pPlaneadoTabla($varLine, $varMonth, $varYear);
                    $diaPPlaneadosT;       

                    for($i = 0; $i<count($datPlaneadoTabla);$i++){
                        echo "<tr>";
                        for ($j = 0; $j<3; $j++){
                            $diaPPlaneadosT[$i][$j] = $datPlaneadoTabla[$i][$j];
                            echo "<td>";
                                echo $diaPPlaneadosT[$i][$j];
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