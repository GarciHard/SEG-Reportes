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

        $datPlaneadoDia = pPlaneadoDia($varLine, $varMonth);
        $datPlaneadosMes = pPlaneadoMes($varLine, $varYear);
        $datTargetDiaPlaneados = targetDiaPlaneado($varLine, $varMonth, $varYear);
        $datTargetMesPlaneados = targetMesPlaneado($varLine, $varYear);

        $diaPPlaneados;
        $mesPPlaneados;
        $duracionDiaPPlaneados;
        $duracionMesPPlaneados;       
        $targetDiaPlaneados;
        $targetMesPlaneados;
        

        for ($i = 1; $i < 32; $i++){
            $diaPPlaneados[$i] = $i;
            $duracionDiaPPlaneados[$i] = 0;
            $targetDiaPlaneados[$i] = 0;
        }   
        
        for ($i = 1; $i < 13; $i++){
            $duracionMesPPlaneados [$i] = 0;
            $targetMesPlaneados [$i] = 0;
        }
        
        for($i = 0; $i < count($datPlaneadoDia); $i++){
            $d = (int) $datPlaneadoDia[$i][0];
            $diaPPlaneados[$i] = $datPlaneadoDia[$i][0];
            $duracionDiaPPlaneados[$d]= $datPlaneadoDia[$i][1]; 
        }
                   
        for($i = 0 ;$i< count($datPlaneadosMes); $i++){
            $mesPPlaneados[$i] = $datPlaneadosMes[$i][0];
            $duracionMesPPlaneados[$mesPPlaneados[$i]]= $datPlaneadosMes[$i][1];
        }
        
        for($i = 0; $i < count($datTargetDiaPlaneados); $i++){
            $d = (int) $datTargetDiaPlaneados[$i][0];
            $targetDiaPlaneados[$d] = $datTargetDiaPlaneados[$i][1];
        }
        
        for ($i = 0; $i < count($datTargetMesPlaneados); $i++){
            $mt[$i] = $datTargetMesPlaneados [$i][0];
            $targetMesPlaneados[$mt[$i]] = $datTargetMesPlaneados [$i][1];
        }
        
        
    ?>    
<BODY>
    <h3 align=center id="titulo">
        Paros Planeados
        <br>
        <?php echo "Linea: " . $varLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
    </h3>
    <form action="top3Planeados.php" method="POST">
            <?php
                echo "<input type="."\"hidden\" name="."\"pLine\""."value=".$varLine.">";
                echo "<input type="."\"hidden\" name="."\"pMonth\""."value=".$varMonth.">";
                echo "<input type="."\"hidden\" name="."\"pYear\""."value=".$varYear.">";
            ?>
        <button id="plain" style="height: 4vh; width: 8vh;  float:right; margin: -4.2% 0%; background-color: #D7DBDD; border-radius: 6px; border: 2px solid #C0392B;">Top 3</button>
    </form>        
    
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
                    categories:  ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Minutos)'
                    },
                    tickInterval: 1000,
                }],
                series: [{ //BARRAS DURACION
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 13; $i++){
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
                                for($i = 1; $i < 13; $i++){
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
        
        <div aling = "center" id="semanaPPlaneados" class="arribaDiaMes">
            <script>
                chartCPU = new Highcharts.chart('semanaPPlaneados', {
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
                    tickInterval: 50,
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
        
        
        <div aling = "center" id="diaPPlaneados" style="height: 60vh; width: 200.5vh; float: left;  margin: -1% 0%;">
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
                    tickInterval: 50,
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
        <table style="height: 38vh; width: 196vh; float: left;  margin: 1% 1.5%;">
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