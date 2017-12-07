<HTML>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    <meta charset="utf-8">
    <!--------CONSULTAS------------->
    <?php
        require_once("control.php");

        $rand = new BaseKPI();

        $datPlaneadoDia = $rand->pPlaneadoDia();
        $datPlaneadosMes = $rand->pPlaneadoMes();
        $datTargetDiaPlaneados = $rand->targetDiaPlaneado();
        $datTargetMesPlaneados = $rand->targetMesPlaneado();

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
    
    <div id = "table-wrapper">
        <div id="table-scroll">
            <table class="pure-table pure-table-bordered" >
                <thead>     
                    <tr>
                        <th><span class="text">D&iacute;a</span></th>
                        <th><span class="text">&Aacute;rea</span></th>
                        <th><span class="text">Duraci&oacute;n</span></th>
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once("control.php");

                        $rand = new BaseKPI();
                        $datPlaneadoTabla = $rand->pPlaneadoTabla();    
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
    </div>
    

</BODY>

</html>