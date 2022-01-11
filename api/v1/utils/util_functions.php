<?
    require_once '../db/db_connections.php';
    require_once '../db/db_functions.php';

    function convert_to_utf8_recursively($dat) {
        if(is_string($dat) ) {
          return mb_convert_encoding($dat, 'UTF-8', 'UTF-8');
        
        } else if(is_array($dat)) {
          $ret = array();
          foreach($dat as $i => $d){
            $ret[$i] = convert_to_utf8_recursively($d);
          }
          return $ret;
        }
        else {
          return $dat;
        }
    }

    function emailSend($destino, $assunto, $mensagem, $remetente = 'cobranca@fitgroup.com.br', $nome = 'FITGROUP ERP') {

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $nome . '<' . $remetente . '>';
        //$headers .= "Bcc: $EmailPadrao\r\n";

        $ret_mail = mail($destino,$assunto,$mensagem, $headers); //mail($destino, $assunto, , $headers);
        if($ret_mail){
          $ret = "E-MAIL ENVIADO COM SUCESSO!";
        
        } else {
          $ret = "ERRO AO ENVIAR E-MAIL!";
  
        }

        return $ret;
    }

    function charLeft($str, $len, $char) {
        $num_char = $len - strlen($str);
        $ret_str = $str;

        for ($i = 1; $i <= $num_char; $i++) {
            $ret_str  = $char . $ret_str;
        }

        return $ret_str;
    }
?>