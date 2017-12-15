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

/* OEE MENSUAL */
function oeeMensualGrafica($linea) {
    $sql = "SELECT MonthOEE, OEE, Quality, Organizational, Technical, Changeover, Performance FROM HourlyCountPercent WHERE Line LIKE '$linea' ORDER BY MonthOEE ASC";
    return getArraySQL($sql);
}

//Listar los dias de produccion por Mes 
function listarDiasMes($linea,$mes, $anio){
    $sql = "SELECT dia FROM Bitacora WHERE linea LIKE '$linea' AND mes LIKE '$mes' AND anio LIKE '$anio' GROUP BY DIA ORDER BY Dia ASC;";
    return getArraySQL($sql);
}

/* PIEZAS PRODUCIDAS */
function pzasProdAnual($linea, $mes) {
    $sql = "SELECT anio, SUM(cantPzas) FROM bitacora WHERE linea LIKE '$linea' AND mes = $mes GROUP BY anio";
    return getArraySQL($sql);
}

function pzasProdMes($linea, $anio) {
    $sql = "SELECT mes, SUM(cantPzas) FROM bitacora WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pzasProdTabla($linea, $mes, $anio) {
    $sql = "SELECT  dia, cliente, noParte, SUM(cantPzas) as Piezas FROM Bitacora WHERE linea LIKE '$linea' AND Mes = $mes and Anio = $anio AND tema = 'Piezas Producidas' GROUP BY Dia, cliente, noParte ORDER BY Dia ASC";
    return getArraySQL($sql);
}

function pzasProdNoParte($linea, $mes, $anio) {
    $sql = "SELECT noParte FROM Bitacora WHERE linea LIKE '$linea' AND Mes = $mes and Anio = $anio AND tema = 'Piezas Producidas' GROUP BY noParte ORDER BY noParte ASC";
    return getArraySQL($sql);
}

function pzasProdNoParteDia($linea, $mes, $anio) {
    $sql = "SELECT dia, noParte, SUM(cantPzas) AS suma,ROW_NUMBER() OVER(PARTITION BY noParte ORDER BY dia ASC) as cont FROM Bitacora WHERE linea LIKE '$linea' AND Mes = $mes and Anio = $anio AND tema = 'Piezas Producidas' GROUP BY noParte, dia ORDER BY noParte ASC";
    return getArraySQL($sql);
}

/* TARGETS */
function targetProdAnio($linea, $anio) {
    $sql = "SELECT anio,SUM (producidas) FROM targets WHERE linea LIKE '$linea' AND anio = $anio  GROUP BY anio";
    return getArraySQL($sql);
}

function targetProdMes($linea, $anio) {
    $sql = "SELECT mes,SUM (producidas) FROM targets WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes";
    return getArraySQL($sql);
}

function targetProdDia($linea, $mes, $anio) {
    $sql = "SELECT dia ,producidas FROM targets WHERE linea LIKE '$linea' AND anio = $anio AND Mes = $mes GROUP BY dia, producidas";
    return getArraySQL($sql);
}

/* SCRAP */
function scrapAnual() {
    $sql = "SELECT anio, SUM(cast(scrap AS INTEGER)) FROM bitacora GROUP BY anio";
    return getArraySQL($sql);
}

function scrapMes($linea, $anio) {
    $sql = "SELECT mes, SUM(cast(scrap AS INTEGER)) FROM bitacora WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function scrapDia($linea, $mes) {
    $sql = "SELECT dia, SUM(cast(scrap AS INTEGER)) FROM bitacora WHERE linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia";
    return getArraySQL($sql);
}

function targetAnioScrap($linea) {
    $sql = "SELECT anio, SUM(scrap) FROM targets WHERE linea LIKE '$linea' GROUP BY anio ORDER BY anio ASC";
    return getArraySQL($sql);
}

function targetMesScrap($linea) {
    $sql = "SELECT mes, SUM(scrap) FROM targets WHERE linea LIKE '$linea' GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function targetDiaScrap($linea, $mes) {
    $sql = "SELECT dia, scrap FROM targets WHERE linea LIKE '$linea' AND mes = $mes GROUP BY dia, scrap ORDER BY dia ASC;";
    return getArraySQL($sql);
}

/* PERDIDAS */
function pTecnicasMes($linea, $anio) {
    $sql = "SELECT mes,SUM(duracion) FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pTecnicasDia($linea, $mes) {
    $sql = "SELECT dia,duracion FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pTecnicasTabla($linea, $mes) {
    $sql = "SELECT  dia, area, operacion,problema,duracion FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, area, operacion,problema,duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function targetMesTecnicas($linea, $anio) {
    $sql = "SELECT mes, SUM(tecnicas) FROM targets WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes, tecnicas";
    return getArraySQL($sql);
}

function targetDiaTecnicas($linea, $mes, $anio) {
    $sql = "SELECT dia ,tecnicas FROM targets WHERE linea LIKE '$linea' AND anio = $anio AND Mes = $mes GROUP BY dia, tecnicas";
    return getArraySQL($sql);
}

/* ORGANIZACIONALES */
function pOrganizacionalesMes($linea, $anio) {
    $sql = "SELECT mes,SUM(duracion) FROM Bitacora WHERE tema LIKE 'Organizacionales' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pOrganizacionalesDia($linea, $mes) {
    $sql = "SELECT dia, duracion FROM Bitacora WHERE tema LIKE 'Organizacionales' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pOrganizacionalesTabla($linea, $mes) {
    $sql = "SELECT dia, area,problema,detalleMaterial,duracion AS tmp  FROM Bitacora where tema LIKE 'Organizacionales' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia,area, problema, detalleMaterial, duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function targetMesOrganizacionales($linea, $anio) {
    $sql = "SELECT mes, SUM(organizacionales) FROM targets WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes";
    return getArraySQL($sql);
}

function targetDiaOrganizacionales($linea, $mes, $anio) {
    $sql = "SELECT dia, organizacionales FROM targets WHERE linea LIKE '$linea' AND anio = $anio AND mes = $mes GROUP BY dia, organizacionales";
    return getArraySQL($sql);
}

/* CAMBIOS */
function pCambioModMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema LIKE 'Cambio de Modelo' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pCambioModDia($linea, $mes) {
    $sql = "SELECT dia, duracion FROM Bitacora WHERE tema LIKE 'Cambio de Modelo' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia,duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pCambioModTabla($linea, $mes) {
    $sql = "SELECT dia, area,problema, duracion AS tmp  FROM Bitacora where tema LIKE 'Cambio de Modelo' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia,area, problema, duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function targetDiaCambMod($linea, $mes, $anio) {
    $sql = "SELECT dia, cambio FROM targets WHERE linea LIKE '$linea' AND anio = $anio AND mes = $mes GROUP BY dia, cambio";
    return getArraySQL($sql);
}

function targetMesCambMod($linea, $anio) {
    $sql = "SELECT mes, SUM(cambio) FROM targets WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes";
    return getArraySQL($sql);
}

/* PLANEADOS */
function pPlaneadoMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema LIKE 'Paros Planeados' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pPlaneadoDia($linea, $mes) {
    $sql = "SELECT dia, SUM (duracion) FROM Bitacora WHERE tema LIKE 'Paros Planeados' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pPlaneadoTabla($linea, $mes, $anio) {
    $sql = "SELECT dia, area, SUM(duracion) AS tmp  FROM Bitacora where tema LIKE 'Paros Planeados' AND linea LIKE '$linea' AND anio = $anio AND mes = $mes GROUP BY dia,area ORDER BY dia ASC";
    return getArraySQL($sql);
}

function targetDiaPlaneado($linea, $mes, $anio) {
    $sql = "SELECT dia, planeado FROM targets WHERE linea LIKE '$linea' AND anio = $anio AND mes = $mes GROUP BY dia, planeado";
    return getArraySQL($sql);
}

function targetMesPlaneado($linea, $anio) {
    $sql = "SELECT mes, SUM(planeado) FROM targets WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes";
    return getArraySQL($sql);
}

/* CALIDAD */
function pCalidadMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema LIKE 'Calidad' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pCalidadDia($linea, $mes) {
    $sql = "SELECT dia, duracion FROM Bitacora WHERE tema LIKE 'Calidad' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pCalidadTabla($linea, $mes) {
    $sql = "SELECT dia, operacion, problema, duracion FROM Bitacora where tema LIKE 'Calidad' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia,operacion,problema, duracion ORDER BY dia ASC";
    return getArraySQL($sql);
}

function targetDiaCalidad($linea, $mes, $anio) {
    $sql = "SELECT dia, calidad FROM targets WHERE linea LIKE '$linea' AND anio = $anio AND mes = $mes GROUP BY dia, calidad";
    return getArraySQL($sql);
}

function targetMesCalidad($linea, $anio) {
    $sql = "SELECT mes, SUM(calidad) FROM targets WHERE linea LIKE '$linea' AND anio = $anio GROUP BY mes";
    return getArraySQL($sql);
}

/* PARETOS TOPS */
function t5TecnicasYOrganizacionales($linea, $mes) {
    $sql = "SELECT TOP 5 operacion,problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Tecnicas','Organizacionales') and mes = $mes AND problema <> '' GROUP BY operacion,problema order by tm desc";
    return getArraySQL($sql);
}

function t1pareto($linea, $mes) {
    $sql = "SELECT TOP 1 problema,COUNT(problema) as con, MAX(DURACION) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Cambio de Modelo') and mes = $mes AND problema <> '' GROUP BY problema order by con DESC";
    return getArraySQL($sql);
}

function t3Calidad($linea, $mes) {
    $sql = "SELECT TOP 3 operacion,problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Calidad') and mes = $mes AND problema <> '' GROUP BY operacion,problema order by tm desc";
    return getArraySQL($sql);
}

/* TOP 3 */
function t3Tecnicas($linea, $mes) {
    $sql = "SELECT TOP 3 operacion,problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Tecnicas') and mes = $mes AND problema <> '' GROUP BY operacion,problema order by tm desc";
    return getArraySQL($sql);
}

function t3Organizacionales($linea, $mes) {
    $sql = "SELECT TOP 3 problema, detalleMaterial, SUM(duracion) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Organizacionales') and mes = $mes AND problema <> '' GROUP BY problema,detalleMaterial order by tm desc;";
    return getArraySQL($sql);
}

function t3CambioModelo($linea, $mes) {
    $sql = "SELECT TOP 3 problema, SUM(duracion) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Cambio de Modelo') and mes = $mes AND problema <> '' GROUP BY problema, duracion order by tm desc";
    return getArraySQL($sql);
}

function t3Planeados($linea, $mes) {
    $sql = "SELECT TOP 3 area, SUM(duracion) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Paros Planeados') and mes = $mes  GROUP BY problema, area order by tm desc";
    return getArraySQL($sql);
}

/* ENTREGAS */
    
function pzasEntregaRealDia($linea, $mes) {
    $sql = "SELECT dia, sum(cantPzas) FROM bitacora WHERE linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pzasEntregaEsperadaDia($linea, $mes) {
    $sql = "SELECT dia, sum(producidas) OVER( ORDER BY dia, producidas) AS sumAcum  FROM targets WHERE linea LIKE '$linea' AND mes = $mes GROUP BY dia, producidas ORDER BY dia ASC";
    return getArraySQL($sql);
}

/***************** FRECUENCIAS **********************/
function t3TecnicasFrec($linea, $mes) {
    $sql = "SELECT TOP 3 operacion,problema, COUNT(problema) as frec FROM Bitacora WHERE LINEA = 'L003' AND tema IN('Tecnicas') and mes = 10 AND problema <> '' GROUP BY operacion,problema order by frec desc";
    return getArraySQL($sql);
}

function t3OrganizacionalesFrec($linea, $mes) {
    $sql = "SELECT TOP 3 problema, detalleMaterial, COUNT(problema) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Organizacionales') and mes = $mes AND problema <> '' GROUP BY problema,detalleMaterial order by tm desc;";
    return getArraySQL($sql);
}

function t3CambioModeloFrec($linea, $mes) {
    $sql = "SELECT TOP 3 problema, COUNT(problema) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Cambio de Modelo') and mes = $mes AND problema <> '' GROUP BY problema, duracion order by tm desc";
    return getArraySQL($sql);
}


function t3PlaneadosFrec($linea, $mes) {
    $sql = "SELECT TOP 3 area, COUNT(area) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Paros Planeados') and mes = $mes  GROUP BY problema, area order by tm desc";
    return getArraySQL($sql);
}

function t3CalidadFrec($linea, $mes) {
    $sql = "SELECT TOP 3 operacion,problema, count(problema) as tm FROM Bitacora WHERE LINEA LIKE '$linea' AND tema IN('Calidad') and mes = $mes AND problema <> '' GROUP BY operacion,problema order by tm desc";
    return getArraySQL($sql);
}