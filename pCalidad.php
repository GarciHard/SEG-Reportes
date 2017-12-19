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
        $varMesStr = listarMeses();
        
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
        
        for ($i = 1; $i < 13; $i++){
            $duracionMes[$i] = 0;
            $targetMesCalidad[$i] = 0;
        }
        
        for($i = 0; $i<count($datCalidadDia);$i++){
            $d = (int) $datCalidadDia[$i][0];
            $dia[$i] = $datCalidadDia[$i][0];
            $duracionDia[$d]= $datCalidadDia[$i][1]; 
        }
                   
        for($i = 0 ;$i<count($datCalidadMes);$i++){
            $mes[$i] = $datCalidadMes[$i][0];            
            $duracionMes[$mes[$i]]= $datCalidadMes[$i][1];  
        }
        
        for ($i = 0; $i < count($datTargetDiaCalidad); $i++){
            $dt[$i] = (int) $datTargetDiaCalidad[$i][0];
           
            $targetDiaCalidad[$dt[$i]] = $datTargetDiaCalidad[$i][1];
        }
        
        for ($i = 0; $i < count($datTargetMesCalidad); $i++){
            $mt[$i] = (int) $datTargetMesCalidad[$i][0];
            $targetMesCalidad[$mt[$i]] = $datTargetMesCalidad[$i][1];
        }
        
    ?>
    
<BODY>
    <h3 align=center id="titulo">
        Paros por Calidad
        <br>
        <?php echo "Linea: " . $varLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
    </h3>
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
                    categories:  ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Munitos)'
                    },
                    tickInterval: 1000,
                }],
                series: [ { //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 13; $i++){
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
                                for($i = 1; $i < 13 ;$i++){
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
        
        <div aling = "center" id="semana" class = "arribaDiaMes">
            <script>
                chartCPU = new Highcharts.chart('semana', {
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
                    tickInterval: 500,
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
        
        <div aling = "center" id="dia" style="height: 60vh; width: 200.5vh; float: left;  margin: -1% 0%;" >
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
                    tickInterval: 50,
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
        <table style="height: 38vh; width: 196vh; float: left;  margin: 1% 1.5%;">
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