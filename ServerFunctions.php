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

function pTecnicasDia($linea, $anio) {
    $sql = "SELECT dia, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND mes = $anio GROUP BY dia ORDER BY dia ASC";
    return getArraySQL($sql);
}

function pTecnicasTabla($linea, $anio) {
    $sql = "SELECT  dia, area, operacion, problema, SUM(duracion) FROM Bitacora WHERE tema LIKE 'Tecnicas' AND linea LIKE '$linea' AND mes = $anio GROUP BY dia, area, operacion, problema ORDER BY dia ASC";
    return getArraySQL($sql);
}