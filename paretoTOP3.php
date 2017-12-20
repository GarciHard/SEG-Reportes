<HTML>
    <head>
       <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <!--------CONSULTAS------------->
            <?php
            require_once 'ServerFunctions.php';
            $varLine = $_REQUEST['varLine'];
            $varMonth = $_REQUEST['varMonth'];
            $varYear = $_REQUEST['varYear'];
            
            
            $varMesStr = listarMeses();
            $pDiaI = 1;
            $pDiaF = 31;
            $band = 0;
            
            $dattop3 = t3Calidad($varLine,$varMonth,$pDiaI,$pDiaF);
            $dattop5 = t5TecnicasYOrganizacionales($varLine,$varMonth,$pDiaI,$pDiaF);
            $dattop1 = t1pareto($varLine,$varMonth,$pDiaI,$pDiaF);
            $diasArrObj = listarDiasMes($varLine,$varMonth,$varYear);
            
             
            $operacionTecOrg;
            $opTecOrg;
            $problemaTecOrg;
            $durTecOrg;
            
            $cambio;
            $cam;
            $durCambio;
            
            $problemaCalidad;
            $operacionCalidad;
            $durCalidad;
            
            $titulo[0] = "Top 5: Tecnicos y Oranizacionales (Duración)";
            $titulo[1] = "Top 1: Cambio de Modelo (Duración)";
            $titulo[2] = "Top 3: Calidad (Duración)";
            
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
                    $dattop3 = t3Calidad($varLine,$varMonth,$pDiaI,$pDiaF);
                    $dattop5 = t5TecnicasYOrganizacionales($varLine,$varMonth,$pDiaI,$pDiaF);
                    $dattop1 = t1pareto($varLine,$varMonth,$pDiaI,$pDiaF);
                    $band = 1;
                    $titulo[0] = "Top 5: Tecnicos y Oranizacionales (Duración)";
                    $titulo[1] = "Top 1: Cambio de Modelo (Duración)";
                    $titulo[2] = "Top 3: Calidad (Duracion)";
                } else if ($opcion == "2"){
                    $dattop3 = t3CalidadFrec($varLine,$varMonth,$pDiaI,$pDiaF);
                    $dattop5 = t5TecnicasYOrganizacionalesFrec($varLine,$varMonth,$pDiaI,$pDiaF);
                    $dattop1 = t1pareto($varLine,$varMonth,$pDiaI,$pDiaF);   
                    $band = 2;
                    $titulo[0] = "Top 5: Tecnicos y Oranizacionales (Frecuencia)";
                    $titulo[1] = "Top 1: Cambio de Modelo (Frecuencia)";
                    $titulo[2] = "Top 3: Calidad(Frecuencia)";
                }                 
            }            
            
            for($i = 0 ;$i<count($dattop5);$i++){
                $operacionTecOrg[$i] = $dattop5[$i][0];
                $op[$i] = (string) $operacionTecOrg[$i]; //cambio de valor para imprimir operacionTecOrg
                $problemaTecOrg[$i] = (string) $dattop5[$i][1];
                $durTecOrg[$i]= $dattop5[$i][2]; 
            }
            
            for($i = 0 ;$i<count($dattop1);$i++){
                $cambio[$i] = $dattop1[$i][0];
                $durCambio[$i]= $dattop1[$i][2]; 
            }
            
            for($i = 0 ;$i<count($dattop3);$i++){
                $operacionCalidad[$i] = $dattop3[$i][0];
                $problemaCalidad[$i] = $dattop3[$i][1];
                $durCalidad[$i]= $dattop3[$i][2]; 
            }
            
            for ($i = 0; $i < count($diasArrObj); $i++) {
                $diasArr[$i] = $diasArrObj[$i][0];
            }
            
        ?>
    </head>
    
    <body>
        
        <h3 ALIGN=center id="titulo">
            Pareto TOP
        <br>
        <?php echo "Linea: " . $varLine ?>
        <br>
        <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
        </h3>
        
        <FORM aling = "center" action="paretoTOP3.php" method="POST" style=" height: 6vh; width: 120vh;  margin: -1% 40%;">            
            <label>Día: </label>
            <select id="diaI" name="cmbDiaI" >
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
                <option>Seleccione</option>
                <option value="1">Duración</option>
                <option value="2">Frecuencia </option>
            </select>
            <?php
                echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$varLine.">";
                echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$varMonth.">";
                echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$varYear.">";
            ?>
            <BUTTON name="btnCalcular">Calcular</BUTTON>
        </FORM>
        
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        

        <div>
            <div aling = "center" id="ptto" style="height: 70vh; width: 95vh; float: left;  margin: 0% 1%;"> 
                <script>
                    chartCPU = new  Highcharts.chart('ptto', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                       text: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < 1; $i++){
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
                                    for($i = 0; $i < count($dattop5); $i++){
                                ?>
                                data.push([<?php echo "'$problemaTecOrg[$i]'";?>]);
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
                    tooltip: {
                        valueSuffix: ' min'
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'

                        }
                    },
                    series: [{
                        name: 'Incidencia',
                        color: '#1A06AF',
                        data: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($dattop5); $i++){
                                ?>
                                data.push([<?php echo $durTecOrg[$i];?>]);
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
        
        
        <div aling = "center" id="derecha" class="pderecha">
            <div aling = "center"  id="ptcm" style="height: 30vh; width: 95vh; float: left;  margin: 0% 1%;">  
                <script>
                    chartCPU = new  Highcharts.chart('ptcm', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                       text: (function() {
                                var data = [];
                                <?php
                                    for($i = 1 ; $i < 2; $i++){
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
                                for($i = 0 ;$i<count($dattop1);$i++){
                            ?>
                            data.push([<?php echo "'$cambio[$i]'";?>]);
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
                    tooltip: {
                        valueSuffix: ' min'
                    },
                    series: [{
                        name: 'Incidencia',
                        color: '#1A06AF',
                        data: (function() {
                                var data = [];
                                <?php
                                    for($i = 0 ;$i<count($dattop1);$i++){
                                ?>
                                data.push([<?php echo $durCambio[$i];?>]);
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

            <div aling = "center" id="ptc" style="height: 40vh; width: 95vh; float: left;  margin: 0% 1%;">
                <script>
                chartCPU = new  Highcharts.chart('ptc', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: (function() {
                                var data = [];
                                <?php
                                    for($i = 2 ; $i < 3; $i++){
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
                                data.push([<?php echo "'$operacionCalidad[$i], $problemaCalidad[$i]'";?>]);
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
                tooltip: {
                    valueSuffix: ' min'
                },
                series: [{
                    name: 'Incidencia',
                    color: '#1A06AF',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($dattop3);$i++){
                            ?>
                            data.push([<?php echo $durCalidad[$i];?>]);
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
        
        <div>
            <div id = "tablaTop5" style="height: 115 vh; width: 95vh;  margin: 0% 1%;" > 
                <table style="height: 45vh; width: 100vh; float: left;  margin: 0% 0%;" >
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
                              
                            $descripcion;       

                            for($i = 0; $i<count($dattop5);$i++){
                                echo "<tr>";
                                for ($j = 0; $j<3; $j++){
                                    $descripcion[$i][$j] = $dattop5[$i][$j];
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
            
            <div aling = "center" >                
                <div id = "tablaTop1" style="height: 30vh; width: 95vh; float: left;  margin: 0% 1%;" >   
                    <table style="height: 11vh; width: 97vh; float: left;  margin: 0% 0%;" >
                        <thead>     
                            <tr style="background: #F2F2F2">
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
                               
                                $descripcion;       

                                for($i = 0; $i<count($dattop1);$i++){
                                    echo "<tr>";
                                    for ($j = 0; $j<2; $j++){
                                        $descripcion[$i][$j] = $dattop1[$i][$j];
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
            
                <div id = "tablaTop3" style="height: 30vh; width: 95vh; float: left;  margin: -5.4% 1%;" >        
                    <table style="height: 26vh; width: 97vh; margin: 0% 0%;" >
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
            </div>
            
        </div>       
    </body>
</html>
