<?php

function tabelaNextId($tabela, $campo) {
    
    $conn = bdConnectErp();
    if ($conn) {
        $str_sql = "SELECT MAX(" . $campo . ") AS last_id 
                    FROM " . $tabela;

        $rs_id = mysqli_query($conn, $str_sql);	   
        $num_id = mysqli_num_rows($rs_id);    

        if ($num_id > 0){
            while($r = mysqli_fetch_assoc($rs_id)) {
                $LastID = $r['last_id'];
                $LastID++;

            }                         

        } else {
            $LastID = 1;
        }
        
        return $LastID;
        
    } else {
        return false;

    }
}

function tabelaCampoValor($tabela, $campo_busca, $busca_valor, $campo_ret, $filter = null, $join = null) {
    $RetCampo = null;

    $conn = bdConnectErp();

    if ($conn) {
        $str_sql = " SELECT " . $campo_ret . 
                    " FROM " . $tabela . 
                    " " . ($join ?: '') . 
                    " WHERE " . $campo_busca . " = '" . $busca_valor . "' " . 
                    ($filter ?: '') . 
                    " LIMIT 1";

        $rs = mysqli_query($conn, $str_sql);	   
        $num = mysqli_num_rows($rs);    

        if ($num > 0){
            while($r = mysqli_fetch_assoc($rs)) {
                $RetCampo = $r[$campo_ret];
            }                         
        }
    }

    return $RetCampo;
}
