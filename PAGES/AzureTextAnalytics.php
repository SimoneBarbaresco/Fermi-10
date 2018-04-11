<?php
    function scan_message($message){
        /*$accessKey = '';
        $host = 'https://westus.api.cognitive.microsoft.com';
        $path = '/text/analytics/v2.0/sentiment';

        $data = array (
            'documents' => array (
                array ( 'id' => '1', 'language' => 'it', 'text' => $message )
            )
        );
        $headers = "Content-type: text/json\r\n"."Ocp-Apim-Subscription-Key: $accessKey\r\n";

        $data = json_encode ($data);

        $options = array (
            'http' => array (
                'header' => $headers,
                'method' => 'POST',
                'content' => $data
            )
        );
        $context  = stream_context_create ($options);
        $result = file_get_contents ($host . $path, false, $context);
        $result= json_decode($result, true);*/
        $f= fopen('simulated_result.json', 'r');
        $result= fread($f, filesize('simulated_result.json'));
        fclose($f);
        $result= json_decode($result, true);
        //-----------------------------------------------------------------------------------------//

        $temi_chiave= $result['keyPhrases'];
        $sentimento= $result['sentiment'];
        $stringa= $temi_chiave['documents'];
        $stringa_ritorno= '';
        foreach($stringa as $puntatore => $contenuto){
            foreach($contenuto as $a => $b){
                if($a=='keyPhrases'){
                    foreach($b as $cella => $parola)
                        $stringa_ritorno.= $parola. ' - ';
                }
            }
        }
        return $stringa_ritorno;
    }
?>