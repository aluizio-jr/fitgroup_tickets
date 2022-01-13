<?php

header('Content-Type: application/json;charset=UTF-8');
ini_set('default_charset','UTF-8');

require_once '../db/db_connection.php';
require_once '../db/db_functions.php';

try {
    
    $retHook = array(
        'dataOcorrencia' => $data_ocorrencia,
        'hookContent' => json_decode($str_json, true),
        'clienteID' => '',
        'apiToken' => '',
        'SQL' => false
    );

    foreach($_SERVER as $key => $val) {
        if ($key == 'HTTP_ASAAS_ACCESS_TOKEN') {
            $apiToken = $val;
        }
        $arrHttp .= $key . " = " . $val . "|";
    }

    $retHook['apiToken'] = $apiToken;
    if (!$apiToken) {
        $retHook['Error'] = 'Token não identificado';
        return $retHook;
    }

    $retCliente = getClienteAsaasInfo(false, $apiToken);
    $clienteID = $retCliente['id_cliente'];
    $retHook['clienteID'] = $clienteID;
    if (!$clienteID) {
        $retHook['Error'] = 'ID do cliente nao identificado';
        return $retHook;
    }
   
 
    $cnn = bdConnectErp();
    if (!$cnn) {
        $retHook['Error'] = 'Falha conexao banco';
        return $retHook;                
    }


    $str_sql = "INSERT INTO c_cloud_webhook 
                (id_cloud_webhook,
                id_cliente,
                data_hora_ocorrencia, 
                json) 
                VALUES 
                (" . $id_webhook . "," .
                $clienteID . ",
                '" . $data_ocorrencia . "',
                '" . addslashes($str_json) . "')";

    $rs_asaas = mysqli_query($cnn, $str_sql);	
    $result = mysqli_affected_rows($cnn);

    if($result <= 0) {
        $retHook['Error'] = 'Erro INSERT';
        $retHook['SQL'] = $str_sql;
        
        return $retHook;        

    } else {
        $retHook['Error'] = false;
    }

} catch (Exception $e) {
    $retHook['Error'] = $e->getMessage();
    $retHook['SQL'] = $str_sql;

    
}  finally {
    $dados = $arr_result;
    //$dados = convert_to_utf8_recursively($arr_result);
    //$str_json = json_encode($dados, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
    
    $str_json = utf8_decode(json_encode($dados, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_NUMERIC_CHECK));
    echo $str_json;

}

