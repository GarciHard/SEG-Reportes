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

/*PIEZAS PRODUCIDAS*/
function pzasProdAnual() {
    $sql = "SELECT anio, SUM(cantPzas) FROM Bitacora GROUP BY anio";
    return getArraySQL($sql);
}

function pzasProdDiaMes($linea, $mes) {
    $sql = "SELECT dia, SUM(cantPzas) FROM Bitacora WHERE linea = '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pzasProdMes($linea, $anio) {
    $sql = "SELECT mes, SUM(cantPzas) FROM Bitacora WHERE linea = '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

/* PERDIDAS TECNICAS */
function pTecnicasMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pTecnicasDia($linea, $mes) {
    $sql = "SELECT dia, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pTecnicasTabla($linea, $anio) {
    $sql = "SELECT  dia, area, operacion, problema, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND mes = $anio GROUP BY dia, area, operacion, problema ORDER BY dia ASC";
    return getArraySQL($sql);
}

/* PERDIDAS ORGANIZACIONALES */
function pOrganizacionalesMes($linea, $anio) {
    $sql = "SELECT mes,SUM(duracion) FROM Bitacora WHERE tema LIKE 'Organizacionales' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pOrganizacionalesDia($linea, $mes) {
    $sql = "SELECT dia, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Organizacionales' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pOrganizacionalesTabla($linea, $mes) {
    $sql = "SELECT dia, area,problema,detalleMaterial, SUM(duracion) AS tmp  FROM Bitacora where tema LIKE 'Organizacionales' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia,area, problema, detalleMaterial ORDER BY dia ASC";
    return getArraySQL($sql);
}

/*PERDIDAS PAROS PLANEADOS*/
function pPlaneadoMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema LIKE 'Paros Planeados' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pPlaneadoDia($linea, $mes) {
    $sql = "SELECT dia, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Paros Planeados' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pPlaneadoTabla($linea, $mes) {
    $sql = "SELECT dia, area, SUM(duracion) AS tmp  FROM Bitacora where tema LIKE 'Paros Planeados' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, area ORDER BY dia ASC";
    return getArraySQL($sql);
}

/* PERDIDAS CAMBIO DE MODELO */
function pCambioModMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema LIKE 'Calidad' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pCambioModDia($linea, $mes) {
    $sql = "SELECT dia, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Cambio de Modelo' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pCambioModTabla($linea, $mes) {
    $sql = "SELECT dia, area,problema, SUM(duracion) AS tmp  FROM Bitacora where tema LIKE 'Cambio de Modelo' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, area, problema ORDER BY dia ASC";
    return getArraySQL($sql);
}

/* PERDIDAS CALIDAD */
function pCalidadMes($linea, $anio) {
    $sql = "SELECT mes, SUM(duracion) as tmp FROM Bitacora WHERE tema LIKE 'Calidad' AND linea LIKE '$linea' AND anio = $anio GROUP BY mes ORDER BY mes ASC";
    return getArraySQL($sql);
}

function pCalidadDia($linea, $mes) {
    $sql = "SELECT dia, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Calidad' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pCalidadTabla($linea, $mes) {
    $sql = "SELECT dia, operacion, problema, SUM(duracion) AS tmp  FROM Bitacora where tema LIKE 'Calidad' AND linea LIKE '$linea' AND mes = $mes GROUP BY dia, operacion, problema ORDER BY dia ASC";
    return getArraySQL($sql);
}

/*OEE DIARIO*/
function oeeDiarioGrafica ($linea, $mes) {
    $sql = "SELECT Dia, OEE, Calidad, Organizacionales, Tecnicas, Cambios, Desempeno FROM HourlyCountOEE WHERE Linea LIKE '$linea' AND Mes = $mes ORDER BY dia ASC";
    return getArraySQL($sql);
}