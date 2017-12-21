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
        $diasArrObj = listarDiasMes($varLine, $varMonth,$varYear);
        
        $pDiaI = 1;
        $pDiaF = 31;
        
        $datTop3DayOrg = lossesDayOrg($varLine, $varMonth,$varYear,$pDiaI,$pDiaF);
        $datTop3DayOrgTotal = lossesDayOrgTotal($varLine,$varMonth,$varYear,$pDiaI,$pDiaF);
        $datTop3DayTec = lossesDayTec($varLine, $varMonth,$varYear,$pDiaI,$pDiaF);
        $datTop3DayTecTotal = lossesDayTecTotal($varLine,$varMonth,$varYear,$pDiaI,$pDiaF);
        $datTop3MesOrg = lossesMesOrg($varLine,$varMonth,$varYear);
        $datTop3MesOrgTotal = lossesMesOrgTotal($varLine,$varMonth,$varYear);
        $datTop3MesTec = lossesMesTec($varLine,$varMonth,$varYear);
        $datTop3MesTecTotal = lossesMesTecTotal($varLine,$varMonth,$varYear);
        
        if (isset($_REQUEST["btnCalcular"])) {
            $pDiaI = isset($_POST['cmbDiaI']) ? $_POST['cmbDiaI'] : '';
            $pDiaF = isset($_POST['cmbDiaF']) ? $_POST['cmbDiaF'] : '';                

            if ($pDiaI == 'All' && $pDiaF == 'All'){
                $pDiaI = 1;
                $pDiaF = 31;
            } else if ($pDiaI == 'All' && $pDiaF != 'All' || $pDiaI != 'All' && $pDiaF == 'All' ) {
                echo '<script language="javascript">alert("Debes seleccionar bien los dias");</script>'; 
                $pDiaI = 0;
                $pDiaF = 0;
            }
            $datTop3DayOrg = lossesDayOrg($varLine, $varMonth,$varYear,$pDiaI,$pDiaF);
            $datTop3DayOrgTotal = lossesDayOrgTotal($varLine,$varMonth,$varYear,$pDiaI,$pDiaF);
            $datTop3DayTec = lossesDayTec($varLine, $varMonth,$varYear,$pDiaI,$pDiaF);
            $datTop3DayTecTotal = lossesDayTecTotal($varLine,$varMonth,$varYear,$pDiaI,$pDiaF);
                            
        }
        
        $problemaDayOrg;
        $detalleMatDayOrg;
        $durDayOrg;
        $totalDayOrg;
        $porcentajeDayOrg;
        
        $operacionDayTec;
        $problemaDayTec;        
        $durDayTec;
        $totalDayTec;
        $porcentajeDayTec;
        
        $problemaMesOrg;
        $detalleMatMesOrg;
        $durMesOrg;
        $totalMesOrg;
        $porcentajeMesOrg;
        
        $operacionMesTec;
        $problemaMesTec;        
        $durMesTec;
        $totalMesTec;
        $porcentajeMesTec;
        
        for ($i = 0; $i < 3; $i++){
            $durDayOrg[$i] = 0;
            $durDayTec[$i] = 0;
            $durMesOrg[$i] = 0;
            $durMesTec[$i] = 0;
            $porcentajeDayOrg[$i] = 0;  
            $porcentajeDayTec[$i] = 0;
            $porcentajeMesOrg[$i] = 0;  
            $porcentajeMesTec[$i] = 0;
            //echo $operacionMesTec[$i],' ',$problemaMesTec[$i],' ', $durMesTec[$i], ' : ',$porcentajeMesTec[$i],'<br>';
        }
        for ($i = 0; $i < count($datTop3DayOrg); $i++){
            $problemaDayOrg[$i] = $datTop3DayOrg[$i][0];
            $detalleMatDayOrg[$i] = (string) $datTop3DayOrg[$i][1];
            $durDayOrg[$i] = $datTop3DayOrg[$i][2];
        }
        
        for ($i = 0; $i < count($datTop3DayOrgTotal); $i++){
            $totalDayOrg[$i] = $datTop3DayOrgTotal[$i][0];
        }
        
        for ($i = 0; $i < count($datTop3DayTec); $i++){
            $operacionDayTec[$i] = $datTop3DayTec[$i][0];
            $problemaDayTec[$i] = $datTop3DayTec[$i][1];
            $durDayTec[$i] = $datTop3DayTec[$i][2];
        }
        
        for ($i = 0; $i < count($datTop3DayTecTotal); $i++){
            $totalDayTec[$i] = $datTop3DayTecTotal[$i][0];
        }
        
        // Mes
        for ($i = 0; $i < count($datTop3MesOrg); $i++){
            $problemaMesOrg[$i] = $datTop3MesOrg[$i][0];
            $detalleMatMesOrg[$i] = (string) $datTop3MesOrg[$i][1];
            $durMesOrg[$i] = $datTop3MesOrg[$i][2];
        }
        
        for ($i = 0; $i < count($datTop3MesOrgTotal); $i++){
            $totalMesOrg[$i] = $datTop3MesOrgTotal[$i][0];
        }
        
        for ($i = 0; $i < count($datTop3MesTec); $i++){
            $operacionMesTec[$i] = $datTop3MesTec[$i][0];
            $problemaMesTec[$i] = $datTop3MesTec[$i][1];
            $durMesTec[$i] = $datTop3MesTec[$i][2];
        }
        
        for ($i = 0; $i < count($datTop3MesTecTotal); $i++){
            $totalMesTec[$i] = $datTop3MesTecTotal[$i][0];
        }
        
        for ($i = 0; $i < 3; $i++){            
            if ($durDayOrg[$i] != 0 ){
                $porcentajeDayOrg[$i] = (float) round(($durDayOrg[$i]*100)/$totalDayOrg[0],3); 
            } else {
                $porcentajeDayOrg[$i] = (float) round(0,3);
            }
            if($durDayTec[$i] != 0){
                $porcentajeDayTec[$i] = (float) round(($durDayTec[$i]*100)/$totalDayTec[0],3);
            }
            else {
                $porcentajeDayTec[$i] = (float) round(0,3);
            }
            if($durMesOrg[$i] != 0){
                $porcentajeMesOrg[$i] = (float) round(($durMesOrg[$i]*100)/$totalMesOrg[0],3); 
            }
            if($durMesTec[$i] != 0){
                $porcentajeMesTec[$i] = (float) round(($durMesTec[$i]*100)/$totalMesTec[0],3);
            }
        }
        
        for ($i = 0; $i < count($diasArrObj); $i++) {
            $diasArr[$i] = $diasArrObj[$i][0];
        } 
        
    ?>
    
    <BODY>
        <h3 align=center id="titulo">
            Losses
            <br>
            <?php echo "Linea: " . $varLine ?>
            <br>
            <?php echo "Mes: " . $varMesStr[$varMonth - 1] ?>
        </h3>

        <FORM aling = "center" action="losses.php" method="POST" style=" height: 6vh; width: 120vh;  margin: -1% 40%;">            
            <label>Día: </label>
            <select id="diaI" name="cmbDiaI">
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

            <?php
                echo "<input type="."\"hidden\" name="."\"varLine\""."value=".$varLine.">";
                echo "<input type="."\"hidden\" name="."\"varMonth\""."value=".$varMonth.">";
                echo "<input type="."\"hidden\" name="."\"varYear\""."value=".$varYear.">";
            ?>
            <BUTTON name="btnCalcular">Calcular</BUTTON>
        </FORM>

        <!--------------GRAFICA----diaPTec-------------->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/pareto.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
        <h3 style=" margin: 0% 47%" >Día</h3>
        <hr style="border: 2px inset #eee; height: -2px; width: 80%;"></hr>
        
        
        <div id = "graficasSuperiores">      
            <div aling = "center" id="orgDay" style="height: 40vh; width: 32%; float: left; margin: 0% .5%">
                <script>
                    chartCPU = new Highcharts.chart('orgDay', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas Organizacionales'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            type: 'category',
                            categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($datTop3DayOrg); $i++){
                                ?>
                                data.push([<?php echo "'$problemaDayOrg[$i] $detalleMatDayOrg[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                        },
                        yAxis: {
                            tickInterval: 5,
                            title: {
                                text: ''
                            },
                            labels: {
                              format: '{value} %'  
                            },                            
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },
                        series: [{
                        name: 'Incidencia',
                        color: '#F06292',
                        data: (function() {
                                var data = [];
                                <?php
                                    for ($i = 0; $i < count($datTop3DayOrg); $i++){
                                ?>
                                data.push([<?php echo $porcentajeDayOrg[$i];?>]);
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

            <div aling = "center" id="tecDay" style="height: 40vh; width: 32%; float: left; margin: 0% .5%">
                <script>
                    chartCPU = new Highcharts.chart('tecDay', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas Tecnicas'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            type: 'category',
                            categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($datTop3DayTec); $i++){
                                ?>
                                data.push([<?php echo "'$operacionDayTec[$i] $problemaDayTec[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                        },
                        yAxis: {
                            tickInterval: 5,
                            title: {
                                text: ''
                            },
                            labels: {
                              format: '{value} %'  
                            },                            
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },
                        series: [{
                        name: 'Incidencia',
                        color: '#08088A',                        
                        data: (function() {
                                var data = [];
                                <?php
                                    for ($i = 0; $i < count($datTop3DayTec); $i++){
                                ?>
                                data.push([<?php echo $porcentajeDayTec[$i];?>]);
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

            <div aling = "center" id="caliDay" style="height: 40vh; width: 32%; float: left; margin: 0% .5%">
                <script>
                    chartCPU = new Highcharts.chart('caliDay', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas de Calidad'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            type: 'category',
                            categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($datTop3DayTec); $i++){
                                ?>
                                data.push([<?php echo "'$operacionDayTec[$i] $problemaDayTec[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                        },
                        yAxis: {
                            tickInterval: 5,
                            title: {
                                text: ''
                            },
                            labels: {
                              format: '{value} %'  
                            },
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },
                        series: [{
                            name: 'Brands',
                            color: '#B71C1C',
                            data: (function() {
                                var data = [];
                                <?php
                                    for ($i = 0; $i < count($datTop3DayTec); $i++){
                                ?>
                                data.push([<?php echo $porcentajeDayTec[$i];?>]);
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
        
        <h3 style=" margin: 0% 47%" >Mensuales</h3>
        <hr style="border: 2px inset #eee; height: -2px; width: 80%;"></hr>

        <div id = "graficasInferiores">      
            <div aling = "center" id="orgMes" style="height: 40vh; width: 32%; float: left; margin: 0% .5%">
                <script>
                    chartCPU = new Highcharts.chart('orgMes', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas Organizacionales'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            type: 'category',
                            categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($datTop3MesOrg); $i++){
                                ?>
                                data.push([<?php echo "'$problemaMesOrg[$i] $detalleMatMesOrg[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                        },
                        yAxis: {
                            tickInterval: 5,
                            title: {
                                text: ''
                            },
                            labels: {
                              format: '{value} %'  
                            },                            
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },
                        series: [{
                        name: 'Incidencia',
                        color: '#F06292',
                        data: (function() {
                                var data = [];
                                <?php
                                    for ($i = 0; $i < count($datTop3MesOrg); $i++){
                                ?>
                                    data.push([<?php echo $porcentajeMesOrg[$i];?>]);
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

            <div aling = "center" id="tecMes" style="height: 40vh; width: 32%; float: left; margin: 0% .5%">
                <script>
                    chartCPU = new Highcharts.chart('tecMes', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas Tecnicas'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            type: 'category',
                            categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($datTop3MesTec); $i++){
                                ?>
                                data.push([<?php echo "'$operacionMesTec[$i] $problemaMesTec[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                        },
                        yAxis: {
                            tickInterval: 5,
                            title: {
                                text: ''
                            },
                            labels: {
                              format: '{value} %'  
                            },                            
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },
                        series: [{
                        name: 'Incidencia',
                        color: '#08088A',                        
                        data: (function() {
                                var data = [];
                                <?php
                                    for ($i = 0; $i < count($datTop3MesTec); $i++){
                                ?>
                                data.push([<?php echo $porcentajeMesTec[$i];?>]);
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

            <div aling = "center" id="caliMes" style="height: 40vh; width: 32%; float: left; margin: 0% .5%">
                <script>
                    chartCPU = new Highcharts.chart('caliMes', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas de Calidad'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            type: 'category',
                            categories: (function() {
                                var data = [];
                                <?php
                                    for($i = 0; $i < count($datTop3MesTec); $i++){
                                ?>
                                data.push([<?php echo "'$operacionMesTec[$i] $problemaMesTec[$i]'";?>]);
                                <?php } ?>
                                return data;
                            })()
                        },
                        yAxis: {
                            tickInterval: 5,
                            title: {
                                text: ''
                            },
                            labels: {
                              format: '{value} %'  
                            },                            
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },
                        series: [{
                            name: 'Brands',
                            color: '#B71C1C',
                            data: (function() {
                                var data = [];
                                <?php
                                    for ($i = 0; $i < count($datTop3MesTec); $i++){
                                ?>
                                data.push([<?php echo $porcentajeMesTec[$i];?>]);
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
    </BODY>
</html>