<HTML>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <LINK REL=StyleSheet HREF="estilo.css" TYPE="text/css" MEDIA=screen>
    <meta charset="utf-8">
    <!--------CONSULTAS------------->
    <?php
        require_once("control.php");

        $rand = new BaseKPI();

        $datTecnicasDia = $rand->pTecnicasDia();
        $datTecnicasMes = $rand->pTecnicasMes();    
        $datTargetDiaTecnicas = $rand->targetDiaTecnicas();
        $datTargetMesTecnicas = $rand->targetMesTecnicas();
        
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
        
        for ($i = 0; $i<count($datTargetDiaTecnicas); $i++){
            $dt = (int)$datTargetDiaTecnicas[$i][0];
            $targetDiaPTec[$dt] = $datTargetDiaTecnicas[$i][1];
        }
        
        for($i = 0 ;$i<count($datTecnicasDia);$i++){
            $d = (int)$datTecnicasDia[$i][0];
            $diaPTec[$i] = $datTecnicasDia[$i][0];
            $duracionDiaPTec[$d]= $datTecnicasDia[$i][1]; 
        }
        
        for ($i = 0; $i<count($datTargetMesTecnicas); $i++){
            $mt = (int)$datTargetMesTecnicas[$i][0];
            $targetMesPTec[$i] = $datTargetMesTecnicas[$i][1];
        }
        
        for($i = 0 ;$i<count($datTecnicasMes);$i++){
            $mesPTecnicas[$i] = $datTecnicasMes[$i][0]; //imprime el valor del mes
            
            switch ($mesPTecnicas[$i]){
                case 1:
                    $mesCadenaPTec[$i] = (string) "'Enero'";
                    break;
                case 2:
                    $mesCadenaPTec[$i] = (string) "'Febrero'";
                    break;
                case 3:
                    $mesCadenaPTec[$i] = (string) "'Marzo'";
                    break;
                case 4:
                    $mesCadenaPTec[$i] = (string) "'Abril'";
                    break;
                case 5:
                    $mesCadenaPTec[$i] = (string) "'Mayo'";
                    break;
                case 6:
                    $mesCadenaPTec[$i] = (string) "'Junio'";
                    break;
                case 7:
                    $mesCadenaPTec[$i] = (string) "'Julio'";
                    break;
                case 8:
                    $mesCadenaPTec[$i] = (string) "'Agosto'";
                    break;
                case 9:
                    $mesCadenaPTec[$i] = (string) "'Septiembre'";
                    break;
                case 10:
                    $mesCadenaPTec[$i] = (string) "'Octubre'";
                    break;
                case 11:
                    $mesCadenaPTec[$i] = (string) "'Noviembre'";
                    break;
                case 12:
                    $mesCadenaPTec[$i] = (string) "'Diciembre'";
                    break;                
            }
            //echo $mesPTecnicas[$i] ,' - ',$mesCadenaPTec[$i],'<br>';
            $duracionMesPTec[$i]= $datTecnicasMes[$i][1]; 
        }
               
    ?>
    
<BODY>
    <h1 ALIGN=center id="titulo">Paros Técnicos</h1>
    
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
                    categories: (function() { // PARTE 
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTecnicasMes);$i++){
                            ?>
                            data.push([<?php echo $mesCadenaPTec[$i];?>]);
                            <?php } ?>
                            return data;
                        })()
                },
                yAxis: [{
                    title: {
                        text: 'Duracion (Minutos)'
                    },
                }],
                series: [{ //BARRAS PARA DURACION 
                    name: 'Indicadores',
                    type: 'column',
                    color: '#1A06AF',
                    data: (function() {
                            var data = [];
                            <?php
                                for($i = 0 ;$i<count($datTecnicasMes);$i++){
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
                                for($i = 0 ;$i<count($datTargetMesTecnicas);$i++){
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
                        text: 'Duracion (Minutos)'
                    },
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
    
    <div id = "table-wrapper">
        <div id="table-scroll">
            <table class="pure-table pure-table-bordered" >
                <thead>     
                    <tr>
                        <th><span class="text">D&iacute;a</span></th>
                        <th><span class="text">&Aacute;rea</span></th>
                        <th><span class="text">Operaci&oacute;n</span></th>
                        <th><span class="text">Problema</span></th>
                        <th><span class="text">Duraci&oacute;n</span></th>
                    </tr>
                </thead>

                <tbody>        
                    <?php
                        require_once("control.php");

                        $rand = new BaseKPI();
                        $datTecnicasTabla = $rand->pTecnicasTabla();    
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
    </div>  

</BODY>

</html>