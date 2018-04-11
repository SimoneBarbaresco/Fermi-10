<?php
    header('Content-Type: application/json');
    require_once ('funzioni.php');

    function controlla($nome){
        if(isset($_GET[$nome]) && !empty(trim($_GET[$nome])))
            return trim($_GET[$nome]);
        else
            return false;
    }
    session_start();
    $destinatario= controlla('destinatario');
    $servizio_traduttore= strtolower($_GET['serviziotraduzione']);
    $primofile=   '../FILE/'.$_SESSION['nome'].'-'.$destinatario.'.json';
    $secondofile= '../FILE/'.$destinatario.'-'.$_SESSION['nome'].'.json';
    $stringa_messaggi= '';
    $contatorepari= 0;
    $contatoredispari= 0;

    if(is_file($primofile)){
        $f= fopen($primofile, 'r');
        $abc= fread($f, filesize($primofile));
        $abc= openssl_decrypt($abc, "AES-128-CBC", $primofile);
        echo $abc;
    }
    else if(is_file($secondofile)){
        $primofile= $secondofile;
        $f= fopen($primofile, 'r');
        $abc= fread($f, filesize($primofile));
        $abc= openssl_decrypt($abc, "AES-128-CBC", $primofile);
        echo $abc;
    }
    else{
        $abc= [];
        echo json_encode($abc);
    }
?>