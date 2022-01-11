<?php

function bdConnectErp() {

    $host="fitgroup.com.br";
    $user="fitgroup_erp";
    $pass="dhvtnc0809vps";
    $bd="fitgroup_erp";

    $cnn = mysqli_connect ($host, $user, $pass, $bd);

    if ($cnn) {
        $result = $cnn;
        $ret = mysqli_set_charset($cnn, "utf8");
        
    } else {
        $result = false; //array('cnn'=>false, 'erro_msg'=>mysqli_connect_error());

    }

    return $result;

}