<HTML>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    <meta charset="utf-8">
    <!--------CONSULTAS------------->
    <?php
        require_once("control.php");

        $rand = new BaseKPI();

        $datCalidadDia= $rand->pCalidadDia();
        $datCalidadMes = $rand->pCalidadMes(); 
        $datTargetDiaCalidad = $rand->targetDiaCalidad();
        $datTargetMesCalidad = $rand->targetMesCalidad();

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
    
    <div id = "table-wrapper">
        <div id="table-scroll">
            <table class="pure-table pure-table-bordered" >
                <thead>     
                    <tr>
                        <th><span class="text">D&iacute;a</span></th>
                        <th><span class="text">Oper&aacute;cion</span></th>
                        <th><span class="text">Pobl&eacute;ma</span></th>
                        <th><span class="text">Durac&iacute;on</span></th>
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once("control.php");

                        $rand = new BaseKPI();
                        $datCalidadTabla = $rand->pCalidadTabla();    
                        $diaT;       

                        for($i = 0; $i<count($datCalidadTabla);$i++){
                            echo "<tr>";
                            for ($j = 0; $j<3; $j++){
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
    </div>
    

</BODY>

</html>