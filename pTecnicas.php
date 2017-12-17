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
        
        $datTecnicasDia = pTecnicasDia($varLine, $varMonth);
        $datTecnicasMes = pTecnicasMes($varLine, $varYear);
        $datTargetDiaTecnicas = targetDiaTecnicas($varLine, $varMonth, $varYear);
        $datTargetMesTecnicas = targetMesTecnicas($varLine, $varYear);
        
        $diaPTec;
        $mesPTecnicas;
        $mesCadenaPTec = '';
        $duracionDiaPTec;
        $duracionMesPTec;   
        $targetDiaPTec;
        $targetMesPTec;

        for ($i = 1; $i<32; $i++){
            $diaPTec[$i] = $i;
            $duracionDiaPTec[$i] = 0;   
            $targetDiaPTec[$i] = 0;
        }
        
        for ($i = 1; $i<13; $i++){
            $duracionMesPTec[$i] = 0;
            $targetMesPTec[$i] = 0;
        }
        
        for ($i = 0; $i<count($datTargetDiaTecnicas); $i++){
            $dt = (int)$datTargetDiaTecnicas[$i][0];
            $targetDiaPTec[$dt] = $datTargetDiaTecnicas[$i][1];
        }
        
        for($i = 0 ;$i<count($datTecnicasDia);$i++){
            $diaPTec[$i] = $datTecnicasDia[$i][0];
            $duracionDiaPTec[$diaPTec[$i]]= $datTecnicasDia[$i][1]; 
        }
        
        for ($i = 0; $i<count($datTargetMesTecnicas); $i++){
            $mt[$i] = (int)$datTargetMesTecnicas[$i][0];             
            $targetMesPTec[$mt[$i]] = $datTargetMesTecnicas[$i][1];
        }
        
        for($i = 0 ;$i<count($datTecnicasMes);$i++){
            $mesPTecnicas[$i] = $datTecnicasMes[$i][0]; //imprime el valor del mes
            $duracionMesPTec[$mesPTecnicas[$i]]= $datTecnicasMes[$i][1]; 
        }               
    ?>
    
<BODY>
    <h3 align=center id="titulo">
        Paros T&eacute;cnicos
        <br>
        <?php echo "Linea: " . $varLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
    </h3>
    <form action="top3Tecnicas.php" method="POST">
            <?php
                echo "<input type="."\"hidden\" name="."\"pLine\""."value=".$varLine.">";
                echo "<input type="."\"hidden\" name="."\"pMonth\""."value=".$varMonth.">";
                echo "<input type="."\"hidden\" name="."\"pYear\""."value=".$varYear.">";
            ?>
        <button id="plain" style="height: 4vh; width: 8vh;  float:right; margin: -4.2% 0%; background-color: #D7DBDD; border-radius: 6px; border: 2px solid #C0392B;">Top 3</button>
    </form>        
    
    <!--------------GRAFICA----diaPTec-------------->
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
                    gridLineWidth: 1,
                    categories:  ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
                },
                yAxis: [{
                    title: {
                        text: 'Duración (Minutos)'
                    },
                    tickInterval: 1000,
                }],
                series: [{ //BARRAS PARA DURACION 
                    name: 'Indicadores',
                    type: 'column',
                    color: '#1A06AF',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i < 13;$i++){
                            ?>
                            data.push([<?php echo $duracionMesPTec[$i];?>]);
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
                            data.push([<?php echo $targetMesPTec[$i];?>]);
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
        
        <div aling = "center" id="diaPTec" class = "arribaDiaMes">
            <script>
                chartCPU = new Highcharts.chart('diaPTec', {
                title: {
                    text: 'Minutos con Falla por Día'
                },
                xAxis: {
                    title: {
                        text: 'Día'
                    },
                    gridLineWidth: 1,
                    categories: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 32; $i++){
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
                series: [{ //BARRAS CHUNDAS
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'spline',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i < 32; $i++){
                            ?>
                            data.push([<?php echo $duracionDiaPTec[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA DE META
                    name: 'Meta',
                    color: '#2ECC71',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1 ;$i < 32; $i++){
                            ?>
                            data.push([<?php echo $targetDiaPTec[$i];?>]);
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
    
    <div  aling = "center">
        <table style="height: 44vh; width: 200vh; float: left;  margin: 0% 1%;" >
            <thead>     
                <tr style="background: #F2F2F2">
                    <th><span class="text">D&iacute;a</span></th>
                    <th><span class="text">&Aacute;rea</span></th>
                    <th><span class="text">Operaci&oacute;n</span></th>
                    <th><span class="text">Problema</span></th>
                    <th><span class="text">Duraci&oacute;n (Minutos)</span></th>
                </tr>
            </thead>

            <tbody>        
                <?php
                    require_once("ServerFunctions.php");

                    $datTecnicasTabla = pTecnicasTabla($varLine, $varMonth);
                    $diaPTecT;       

                    for($i = 0; $i<count($datTecnicasTabla);$i++){
                        echo "<tr>";
                        for ($j = 0; $j<5; $j++){
                            $diaPTecT[$i][$j] = $datTecnicasTabla[$i][$j];
                            echo "<td>";
                                echo $diaPTecT[$i][$j];
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