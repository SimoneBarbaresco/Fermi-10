<?php

    $messaggio= trim($_GET['messaggio']);
    $servizio_traduzione= $_GET['servizio_traduzione'];

    if($servizio_traduzione === 'Bing'){
        $id = '';
        $host = "https://api.microsofttranslator.com";
        $path = "/V2/Http.svc/Translate";
        $lentarget = "it-it";
        $params = '?to=' . $lentarget . '&text=' . urlencode($messaggio);
        $content = '';

        $headers = "Content-type: text/xml\r\n" ."Ocp-Apim-Subscription-Key: $id\r\n";

        $options = array (
            'http' => array (
                'header' => $headers,
                'method' => 'GET'
            )
        );
        $context  = stream_context_create ($options);
        $result = file_get_contents ($host . $path . $params, false, $context);
        echo $result;
    }
?>