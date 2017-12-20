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



        <!--------------GRAFICA----diaPTec-------------->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/pareto.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <div id = "graficasSuperiores">      
            <div aling = "center" id="orgDay" style="height: 40vh; width: 30%; float: left; margin: 0% 1%">
                <script>
                    chartCPU = new Highcharts.chart('orgDay', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas Organizacionales'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Total percent market share'
                            }
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
                            colorByPoint: true,
                            data: [{
                                name: 'Microsoft Internet Explorer',
                                y: 56.33,
                                drilldown: 'Microsoft Internet Explorer'
                            }, {
                                name: 'Chrome',
                                y: 24.03,
                                drilldown: 'Chrome'
                            }, {
                                name: 'Firefox',
                                y: 10.38,
                                drilldown: 'Firefox'
                            }, {
                                name: 'Safari',
                                y: 4.77,
                                drilldown: 'Safari'
                            }, {
                                name: 'Opera',
                                y: 0.91,
                                drilldown: 'Opera'
                            }, {
                                name: 'Proprietary or Undetectable',
                                y: 0.2,
                                drilldown: null
                            }]
                        }]
                    });
                </script> 
            </div>

            <div aling = "center" id="tecDay" style="height: 40vh; width: 30%; float: left; margin: 0% 1%">
                <script>
                    chartCPU = new Highcharts.chart('tecDay', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas Tecnicas'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Total percent market share'
                            }
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
                            color: '#08088A',
                            data: [{
                                name: 'Microsoft Internet Explorer',
                                y: 56.33,
                                drilldown: 'Microsoft Internet Explorer'
                            }, {
                                name: 'Chrome',
                                y: 24.03,
                                drilldown: 'Chrome'
                            }, {
                                name: 'Firefox',
                                y: 10.38,
                                drilldown: 'Firefox'
                            }, {
                                name: 'Safari',
                                y: 4.77,
                                drilldown: 'Safari'
                            }, {
                                name: 'Opera',
                                y: 0.91,
                                drilldown: 'Opera'
                            }, {
                                name: 'Proprietary or Undetectable',
                                y: 0.2,
                                drilldown: null
                            }]
                        }]
                    });
                </script> 
            </div>

            <div aling = "center" id="caliDay" style="height: 40vh; width: 30%; float: left; margin: 0% 1%">
                <script>
                    chartCPU = new Highcharts.chart('caliDay', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Perdidas de Calidad'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Total percent market share'
                            }
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
                            colorByPoint: true,
                            data: [{
                                name: 'Microsoft Internet Explorer',
                                y: 56.33,
                                drilldown: 'Microsoft Internet Explorer'
                            }, {
                                name: 'Chrome',
                                y: 24.03,
                                drilldown: 'Chrome'
                            }, {
                                name: 'Firefox',
                                y: 10.38,
                                drilldown: 'Firefox'
                            }, {
                                name: 'Safari',
                                y: 4.77,
                                drilldown: 'Safari'
                            }, {
                                name: 'Opera',
                                y: 0.91,
                                drilldown: 'Opera'
                            }, {
                                name: 'Proprietary or Undetectable',
                                y: 0.2,
                                drilldown: null
                            }]
                        }]
                    });
                </script> 
            </div>
        </div>

        <div  aling = "center">
            <table style="height: 38vh; width: 195vh; float: left;  margin: 1% 1.5%;" >
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