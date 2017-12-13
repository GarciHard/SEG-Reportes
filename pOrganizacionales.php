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

        $datOrgDia = pOrganizacionalesDia($varLine, $varMonth);
        $datOrgMes = pOrganizacionalesMes($varLine, $varYear);
        $datTargetMesOrg = targetMesOrganizacionales($varLine, $varYear);
        $datTargetDiaOrg = targetDiaOrganizacionales($varLine, $varMonth, $varYear);

        $dia;
        $d;
        $mes;
        $duracionDia;
        $duracionMes;   
        $targetMesOrg;
        $targetDiaOrg;
        
        for ($i=1; $i<32; $i++){
            $dia[$i] = $i;
            $duracionDia[$i] = 0;
        }
        
        for ($i = 0; $i<count($datOrgDia); $i++){
            $d = (int) $datOrgDia[$i][0];
            $dia[$i] = $datOrgDia[$i][0];
            $duracionDia[$d]= $datOrgDia[$i][1]; 
        }
        
        for ($i = 0; $i<count($datOrgMes); $i++){
            $mes[$i] = $datOrgMes[$i][0];
            switch ($mes[$i]){
                    case 1:
                        $mesCadenaOrg[$i] = (string) "'Enero'";
                        break;
                    case 2:
                        $mesCadenaOrg[$i] = (string) "'Febrero'";
                        break;
                    case 3:
                        $mesCadenaOrg[$i] = (string) "'Marzo'";
                        break;
                    case 4:
                        $mesCadenaOrg[$i] = (string) "'Abril'";
                        break;
                    case 5:
                        $mesCadenaOrg[$i] = (string) "'Mayo'";
                        break;
                    case 6:
                        $mesCadenaOrg[$i] = (string) "'Junio'";
                        break;
                    case 7:
                        $mesCadenaOrg[$i] = (string) "'Julio'";
                        break;
                    case 8:
                        $mesCadenaOrg[$i] = (string) "'Agosto'";
                        break;
                    case 9:
                        $mesCadenaOrg[$i] = (string) "'Septiembre'";
                        break;
                    case 10:
                        $mesCadenaOrg[$i] = (string) "'Octubre'";
                        break;
                    case 11:
                        $mesCadenaOrg[$i] = (string) "'Noviembre'";
                        break;
                    case 12:
                        $mesCadenaOrg[$i] = (string) "'Diciembre'";
                        break;                
                }
            $duracionMes[$i]= $datOrgMes[$i][1]; 
        }
        
        for ($i = 0 ;$i<count($datTargetMesOrg);$i++){
            $targetMesOrg[$i] = $datTargetMesOrg[$i][1];
        }
        
        for ($i = 0 ;$i<count($datTargetDiaOrg);$i++){
            $targetDiaOrg[$i] = $datTargetDiaOrg[$i][1];
        }
        
    ?>
    
<BODY>
    <h1 ALIGN=center id="titulo">Paros Organizacionales</h1>
    <form action="top3Organizacionales.php" method="POST">
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
                                for($i = 0 ;$i<count($datOrgMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaOrg[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Duración (Minutos)'
                    },
                }],
                series: [{ //BARRAS DURACION
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'column',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datOrgMes);$i++){
                            ?>
                            data.push([<?php echo $duracionMes[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },{ //LINEA META
                    color: '#2ECC71',
                    type: 'spline',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTargetMesOrg);$i++){
                            ?>
                            data.push([<?php echo $targetMesOrg[$i];?>]);
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
                }],
                series: [{ //BARRAS Duracion
                    color: '#1A06AF',
                    name: 'Indicadores',
                    type: 'spline',
                    zIndex: 1,
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 1; $i < 32; $i++){
                            ?>
                            data.push([<?php echo $duracionDia[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                }, { //LINEA META
                    color: '#2ECC71',
                    name: 'Meta',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0; $i < count($datTargetDiaOrg); $i++){
                            ?>
                            data.push([<?php echo $targetDiaOrg[$i];?>]);
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
                <th>Día</th>
                    <th><span class="text">&Aacute;rea</span></th>
                    <th><span class="text">Operaci&oacute;n</span></th>
                    <th><span class="text">Problema</span></th>
                    <th><span class="text">Duraci&oacute;n</span></th>
                </tr>
            </thead>

            <tbody>        
                <?php
                    require_once 'ServerFunctions.php';

                    $datOrgTabla = pOrganizacionalesTabla($varLine, $varMonth);
                    $diaT;       

                    for($i = 0; $i<count($datOrgTabla);$i++){
                        echo "<tr>";
                        for ($j = 0; $j<5; $j++){
                            $diaT[$i][$j] = $datOrgTabla[$i][$j];
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