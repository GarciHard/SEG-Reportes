<?php
require_once 'ServerConfig.php';
/**
 * Description of ServerFunctions
 *
 * @author GJA5TL
 */

function listarLineas() {
    $connectionObj = new ServerConfig();
    $connectionStr = $connectionObj -> serverConnection();
    
    $queryVar = sqlsrv_query($connectionStr, "SELECT linea FROM Lineas ORDER BY 1");
    
    if ($queryVar) {
        
        $lineasArr = array();
        $i = 0;
        
        while ($aux = sqlsrv_fetch_array( $queryVar )) {
            $lineasArr[$i] = $aux;
            $i++;
        }
        return $lineasArr;
    }
    $connectionObj -> serverDisconnect();
}
function listarMeses() {
    $mesesArr = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    return $mesesArr;
}
function listarAnio() {
    $anioArr = array("2017", "2016", "2015");
    return $anioArr;
}

//Devuelve un array multidimensional con el resultado de la consulta
function getArraySQL($sql) {
    $connectionObj = new ServerConfig();
    $connectionStr = $connectionObj -> serverConnection();
    
    if (!$result = sqlsrv_query($connectionStr, $sql))
        die();

    $rawdata = array();
    $i = 0;
    while ($row = sqlsrv_fetch_array($result)) {
        $rawdata[$i] = $row;
        $i++;
    }
    $connectionObj ->serverDisconnect();
    return $rawdata;
}

/* OEE DIARIO */
function oeeDiarioGrafica($linea, $mes) {
    $sql = "SELECT Dia, OEE, Calidad, Organizacionales, Tecnicas, Cambios, Desempeno FROM HourlyCountOEE WHERE Linea LIKE '$linea' AND Mes = $mes ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pzasProdAnual(){
        $sql = "SELECT anio, SUM(cantPzas) FROM bitacora WHERE linea = 'L003' AND mes = 10 GROUP BY anio;";
        return $this->getArraySQL($sql);
    }
    
    function pzasProdMes (){
        $sql = "SELECT mes, SUM(cantPzas) FROM bitacora WHERE linea = 'L003' AND anio = 2017 GROUP BY mes ORDER BY mes ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pzasProdTabla (){
        $sql = "SELECT  dia, cliente, noParte, SUM(cantPzas) as Piezas FROM Bitacora WHERE linea = 'L003' AND Mes = 10 and Anio =2017 AND tema = 'Piezas Producidas' GROUP BY Dia, cliente, noParte ORDER BY Dia ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pzasProdNoParte (){
        $sql = "SELECT noParte FROM Bitacora WHERE linea = 'L003' AND Mes = 10 and Anio = 2017 AND tema = 'Piezas Producidas' GROUP BY noParte ORDER BY noParte ASC;";
        return $this->getArraySQL($sql);
    } 
    
    function pzasProdNoParteDia (){
        $sql = "SELECT dia, noParte, SUM(cantPzas) AS suma,ROW_NUMBER() OVER(PARTITION BY noParte ORDER BY dia ASC) as cont FROM Bitacora WHERE linea = 'L003' AND Mes = 10 and Anio = 2017 AND tema = 'Piezas Producidas' GROUP BY noParte, dia ORDER BY noParte ASC;";
        return $this->getArraySQL($sql);
    } 
    
    function targetProdAnio (){
        $sql = "SELECT anio,SUM (producidas) FROM targets WHERE linea = 'L003' AND anio = 2017  GROUP BY anio;";
        return $this->getArraySQL($sql);
    }
    
    function targetProdMes (){
        $sql = "SELECT mes,SUM (producidas) FROM targets WHERE linea = 'L003' AND anio = 2017 GROUP BY mes;";
        return $this->getArraySQL($sql);
    }
    
    function targetProdDia (){
        $sql = "SELECT dia ,producidas FROM targets WHERE linea = 'L003' AND anio = 2017 AND Mes = 10 GROUP BY dia, producidas;";
        return $this->getArraySQL($sql);
    }    
    
    ///////////////////SCRAP
    function scrapAnual(){
        $sql = "SELECT anio, SUM(cast(scrap AS INTEGER)) FROM bitacora GROUP BY anio;";
        return $this->getArraySQL($sql);
    }
        
    function scrapMes (){
        $sql = "SELECT mes, SUM(cast(scrap AS INTEGER)) FROM bitacora WHERE linea = 'L003' AND anio = 2017 GROUP BY mes ORDER BY mes ASC";
        return $this->getArraySQL($sql);
    }
    
    function scrapDia (){
        $sql = "SELECT dia, SUM(cast(scrap AS INTEGER)) FROM bitacora WHERE linea = 'L003' AND mes = 10 GROUP BY dia ORDER BY dia;";
        return $this->getArraySQL($sql);
    }
    
    function targetAnioScrap (){
        $sql = "SELECT anio, SUM(scrap) FROM targets WHERE linea = 'L003' GROUP BY anio ORDER BY anio ASC;";
        return $this->getArraySQL($sql);
    }
    
    function targetMesScrap (){
        $sql = "SELECT mes, SUM(scrap) FROM targets WHERE linea = 'L003' GROUP BY mes ORDER BY mes ASC;";
        return $this->getArraySQL($sql);
    }
    
    function targetDiaScrap (){
        $sql = "SELECT dia, scrap FROM targets WHERE linea = 'L003' AND mes = 10 GROUP BY dia, scrap ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }
    
    
    /***********CONSULTAS PARA PERDIDAS************/
    function pTecnicasMes(){
        $sql = "SELECT mes,SUM(duracion) FROM Bitacora WHERE tema = 'Tecnicas' AND linea = 'L003' AND anio = 2017 GROUP BY mes ORDER BY mes ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pTecnicasDia(){
        $sql = "SELECT dia,duracion FROM Bitacora WHERE tema = 'Tecnicas' AND linea = 'L003' AND mes = 10 GROUP BY dia, duracion ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }   
    
    function pTecnicasTabla(){
        $sql = "SELECT  dia, area, operacion,problema,duracion FROM Bitacora WHERE tema = 'Tecnicas' AND linea = 'L003' AND mes = 10 GROUP BY dia, area, operacion,problema,duracion ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }
    
    function targetMesTecnicas(){
        $sql = "SELECT mes, SUM(tecnicas) FROM targets WHERE linea = 'L003' AND anio = 2017 GROUP BY mes, tecnicas;";
        return $this->getArraySQL($sql);
    }
    
    function targetDiaTecnicas(){
        $sql = "SELECT dia ,tecnicas FROM targets WHERE linea = 'L003' AND anio = 2017 AND Mes = 10 GROUP BY dia, tecnicas;";
        return $this->getArraySQL($sql);
    }
    
    //ORGANIZACIONALES
    function pOrganizacionalesMes(){
        $sql = "SELECT mes,SUM(duracion) FROM Bitacora WHERE tema = 'Organizacionales' AND linea = 'L003' AND anio = 2017 GROUP BY mes ORDER BY mes ASC ";
        return $this->getArraySQL($sql);
    }
    
    function pOrganizacionalesDia(){
        $sql = "SELECT dia, duracion FROM Bitacora WHERE tema = 'Organizacionales' AND linea = 'L003' AND mes = 10 GROUP BY dia, duracion ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }   
    
    function pOrganizacionalesTabla(){
        $sql = "SELECT dia, area,problema,detalleMaterial,duracion AS tmp  FROM Bitacora where tema = 'Organizacionales' AND linea = 'L003' AND mes = 10 GROUP BY dia,area, problema, detalleMaterial, duracion ORDER BY dia ASC ;";
        return $this->getArraySQL($sql);
    }
    
    function targetMesOrganizacionales(){
        $sql = "SELECT mes, SUM(organizacionales) FROM targets WHERE linea = 'L003' AND anio = 2017 GROUP BY mes;";
        return $this->getArraySQL($sql);
    }
    
    function targetDiaOrganizacionales(){
        $sql = "SELECT dia, organizacionales FROM targets WHERE linea = 'L003' AND anio = 2017 AND mes = 10 GROUP BY dia, organizacionales;";
        return $this->getArraySQL($sql);
    }
    
    //CAMBIO DE MODELO
    function pCambioModMes(){
        $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema = 'Cambio de Modelo' AND linea = 'L003' AND anio = 2017 GROUP BY mes ORDER BY mes ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pCambioModDia(){
        $sql = "SELECT dia, duracion FROM Bitacora WHERE tema = 'Cambio de Modelo' AND linea = 'L003' AND mes = 10 GROUP BY dia,duracion ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }   
    
    function pCambioModTabla(){
        $sql = "SELECT dia, area,problema, duracion AS tmp  FROM Bitacora where tema = 'Cambio de Modelo' AND linea = 'L003' AND mes = 10 GROUP BY dia,area, problema, duracion ORDER BY dia ASC ;";
        return $this->getArraySQL($sql);
    }
    
    function targetDiaCambMod(){
        $sql = "SELECT dia, camMod FROM targets WHERE linea = 'L003' AND anio = 2017 AND mes = 10 GROUP BY dia, camMod;";
        return $this->getArraySQL($sql);
    }
    
    function targetMesCambMod(){
        $sql = "SELECT mes, SUM(camMod) FROM targets WHERE linea = 'L003' AND anio = 2017 GROUP BY mes;";
        return $this->getArraySQL($sql);
    }

    //PLANEADO
    function pPlaneadoMes(){
        $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema = 'Paros Planeados' AND linea = 'L003' AND anio = 2017 GROUP BY mes ORDER BY mes ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pPlaneadoDia(){
        $sql = "SELECT dia, SUM (duracion) FROM Bitacora WHERE tema = 'Paros Planeados' AND linea = 'L003' AND mes = 9 GROUP BY dia ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }   
    
    function pPlaneadoTabla(){
        $sql = "SELECT dia, area, SUM(duracion) AS tmp  FROM Bitacora where tema = 'Paros Planeados' AND linea = 'L003' AND anio = 2017 AND mes = 9 GROUP BY dia,area ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }
    
    function targetDiaPlaneado(){
        $sql = "SELECT dia, planeado FROM targets WHERE linea = 'L003' AND anio = 2017 AND mes = 9 GROUP BY dia, planeado;";
        return $this->getArraySQL($sql);
    }
    
    function targetMesPlaneado(){
        $sql = "SELECT mes, SUM(planeado) FROM targets WHERE linea = 'L003' AND anio = 2017 GROUP BY mes;";
        return $this->getArraySQL($sql);
    }
    
    //CALIDAD
    function pCalidadMes(){
        $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema = 'Calidad' AND linea = 'L022' AND anio = 2017 GROUP BY mes ORDER BY mes ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pCalidadDia(){
        $sql = "SELECT dia, duracion FROM Bitacora WHERE tema = 'Calidad' AND linea = 'L022' AND mes = 10 GROUP BY dia, duracion ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }   
    
    function pCalidadTabla(){
        $sql = "SELECT dia, operacion, problema, duracion FROM Bitacora where tema = 'Calidad' AND linea = 'L022' AND mes = 10 GROUP BY dia,operacion,problema, duracion ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }
    
    function targetDiaCalidad(){
        $sql = "SELECT dia, calidad FROM targets WHERE linea = 'L022' AND anio = 2017 AND mes = 9 GROUP BY dia, calidad;";
        return $this->getArraySQL($sql);
    }
    
    function targetMesCalidad(){
        $sql = "SELECT mes, SUM(calidad) FROM targets WHERE linea = 'L022' AND anio = 2017 GROUP BY mes;";
        return $this->getArraySQL($sql);
    }
    
    
    /************CONSULTAS PARA EL PARETO DE TOP'S*************/
    function t5TecnicasYOrganizacionales (){
        $sql = "SELECT TOP 5 operacion,problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA = 'L022' AND tema IN('Tecnicas','Organizacionales') and mes = 10 AND problema <> '' GROUP BY operacion,problema order by tm desc;";
        return $this->getArraySQL($sql);
    }
    
    function t1pareto(){
        $sql = "SELECT TOP 1 problema,COUNT(problema) as con, MAX(DURACION) as tm FROM Bitacora WHERE LINEA = 'L022' AND tema IN('Cambio de Modelo') and mes = 10 AND problema <> '' GROUP BY problema order by con DESC ;";
        return $this->getArraySQL($sql);
    }
    
    function t3Calidad(){
        $sql = "SELECT TOP 3 operacion,problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA = 'L022' AND tema IN('Calidad') and mes = 10 AND problema <> '' GROUP BY operacion,problema order by tm desc;";
        return $this->getArraySQL($sql);
    }
    
    /******************TOP 3 ******************/
    function t3Tecnicas(){
        $sql = "SELECT TOP 3 operacion,problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA = 'L003' AND tema IN('Tecnicas') and mes = 10 AND problema <> '' GROUP BY operacion,problema order by tm desc;";
        return $this->getArraySQL($sql);
    }
    
    function t3Organizacionales(){
        $sql = "SELECT TOP 3 problema, detalleMaterial, SUM(duracion) as tm FROM Bitacora WHERE LINEA = 'L003' AND tema IN('Organizacionales') and mes = 10 AND problema <> '' GROUP BY problema,detalleMaterial order by tm desc;";
        return $this->getArraySQL($sql);
    }
    
    function t3CambioModelo(){
        $sql = "SELECT TOP 3 problema, duracion as tm FROM Bitacora WHERE LINEA = 'L003' AND tema IN('Cambio de Modelo') and mes = 10 AND problema <> '' GROUP BY problema, duracion order by tm desc;";
        return $this->getArraySQL($sql);
    }
    
    function t3Planeados(){
        $sql = "SELECT TOP 3 area, SUM(duracion) as tm FROM Bitacora WHERE LINEA = 'L625' AND tema IN('Paros Planeados') and mes = 10  GROUP BY problema, area order by tm desc;";
        return $this->getArraySQL($sql);
    }
    
    /***********ENTREGAS**************/
    
    function pzasEntregaRealDia (){
        $sql = "SELECT dia, sum(cantPzas) FROM bitacora WHERE linea = 'L003' AND mes = 10 GROUP BY dia ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }
    
    function pzasEntregaEsperadaDia(){
        $sql = "SELECT dia, sum(producidas) OVER( ORDER BY dia, producidas) AS sumAcum  FROM targets WHERE linea = 'L003' AND mes = 10 GROUP BY dia, producidas ORDER BY dia ASC;";
        return $this->getArraySQL($sql);
    }