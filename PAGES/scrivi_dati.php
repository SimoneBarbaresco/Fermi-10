<?php
    require_once('funzioni.php');
    session_start();
    
    $invio= array(
        'status' => $_GET['status'],
        'country' => $_GET['country'],
        'region' => $_GET['region'],
        'city' => $_GET['city'],
        'zip' => $_GET['zip'],
        'lat' => $_GET['lat'],
        'lon' => $_GET['lon'],
        'timezone' => $_GET['timezone'],
        'isp' => $_GET['isp'],
        'IP' => $_GET['IP']
    );
    registra_accesso($invio);
    echo "bho";
?>