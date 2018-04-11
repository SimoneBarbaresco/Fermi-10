<?php 

    function getBrowser(){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge')!==false)
            return 'Edge';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')!==false)
            return 'Firefox';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')!==false)
            return 'Chrome';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')!==false)
            return 'Safari';
        else
            return 'Browser non Identificato';
    }

    function getOS(){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 10')!==false)
            return 'Windows 10';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows')!==false)
            return 'Windows';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Ubuntu')!==false)
            return 'Ubuntu';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')!==false)
            return 'Android';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Mac')!==false)
            return 'MacOS';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'macintosh')!==false)
            return 'OS X';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==false)
            return 'Linux';
        else
            return 'OS non Identificato';
    }

    function registra_accesso($query){
        $prima_chiave= genera_chiave();
        $nome_file= strtolower("../FILE/".$_SESSION['nome'].".json");
        if(is_file($nome_file)){
            $f= fopen($nome_file, 'r') or die ("Location: ./registrazione.php?Messaggio=Errore+durante+l'apertura+del+file+per+l'aggiunta+utente");
            if(filesize($nome_file)!= 0){
                $lista_accessi= fread($f, filesize($nome_file));
                $lista_accessi= json_decode($lista_accessi, true);
            }
            fclose($f);
        }
        $lista_accessi[]=[
            "time" => openssl_encrypt($_SESSION['orario_accesso'], "AES-128-CBC", $prima_chiave),
            "status" => $query['status'],
            "coutry" => openssl_encrypt($query['country'], "AES-128-CBC", $prima_chiave),
            "region" => openssl_encrypt($query['region'], "AES-128-CBC", $prima_chiave),
            "city" => openssl_encrypt($query['city'], "AES-128-CBC", $prima_chiave),
            "zip" => openssl_encrypt($query['zip'], "AES-128-CBC", $prima_chiave),
            "lat" => openssl_encrypt($query['lat'], "AES-128-CBC", $prima_chiave),
            "lon" => openssl_encrypt($query['lon'], "AES-128-CBC", $prima_chiave),
            "timezone" => openssl_encrypt($query['timezone'], "AES-128-CBC", $prima_chiave),
            "isp" => openssl_encrypt($query['isp'], "AES-128-CBC", $prima_chiave),
            "IP" => openssl_encrypt($query['IP'], "AES-128-CBC", $prima_chiave),
            "browser" => openssl_encrypt(getBrowser(), "AES-128-CBC", $prima_chiave),
            "OS" => openssl_encrypt(getOS(), "AES-128-CBC", $prima_chiave)
        ];
        usort($lista_accessi, 
                        function($ind1, $ind2){
                            return strcmp( openssl_decrypt($ind1['time'], "AES-128-CBC", $prima_chiave), openssl_decrypt($ind2['time'], "AES-128-CBC", $prima_chiave));
                    });
        $lista_accessi= json_encode($lista_accessi, JSON_PRETTY_PRINT);
        $f= fopen($nome_file, 'w');
        fwrite($f, $lista_accessi);
        fclose($f);
        return true;
    }

    function genera_chiave(){
        if(strlen($_SESSION['nome'])%2==0){
            $stringa_risultante= "";
            $stringa_normale= $_SESSION['nome'];
            $stringa_inversa = strrev($_SESSION['nome']);
            for($i=0; $i< strlen($_SESSION['nome']); $i++)
                if($i%2==0) 
                    $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
                else
                    $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
            return $stringa_risultante.strrev($_SESSION['nome']);
        }
        else{
            $stringa_risultante= "";
            $stringa_normale= $_SESSION['nome'];
            $stringa_inversa = strrev($_SESSION['nome']);
            for($i=0; $i< strlen($_SESSION['nome']); $i++)
                if($i%2==0) 
                    $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
                else
                    $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
            return strrev($_SESSION['nome']).$stringa_risultante;
        }
    }

    function genera_chiave1($stringa){
        if(strlen($stringa)%2==0){
            $stringa_risultante= "";
            $stringa_normale= $stringa;
            $stringa_inversa = strrev($stringa);
            for($i=0; $i< strlen($stringa); $i++)
                if($i%2==0) 
                    $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
                else
                    $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
            return $stringa_risultante.strrev($stringa);
        }
        else{
            $stringa_risultante= "";
            $stringa_normale= $stringa;
            $stringa_inversa = strrev($stringa);
            for($i=0; $i< strlen($stringa); $i++)
                if($i%2==0) 
                    $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
                else
                    $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
            return strrev($stringa).$stringa_risultante;
        }
    }

    function carica_dati(){
        $nome= $_SESSION['nome'];
        $prima_lettera= $nome[0];
        $nome_file= "../FILE/".strtolower($prima_lettera).".json";
        $_SESSION['flag']=false;
        $f= fopen($nome_file, 'r');
        $lista_utenti= fread($f, filesize($nome_file));
        $lista_utenti= json_decode($lista_utenti, true);

        foreach($lista_utenti as $contenitore_utente => $campo){
            if($_SESSION['flag'])
                break;
            foreach($campo as $singolo_carattere => $contenuto){
                if($singolo_carattere==='username' && $_SESSION['nome']===$contenuto)
                    $_SESSION['flag']= true;
                if($singolo_carattere!= 'username'){
                    $_SESSION[$singolo_carattere]= $contenuto;
                }
            }
        }
    }

    function traduci($stringa,$from, $to){
        //return file_get_contents("http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode($stringa)."&langpair=".$from."|".$to);
        return $stringa;
    }

    function stampa_accessi(){
        $prima_chiave= genera_chiave();
        $nome_file= strtolower("../FILE/".$_SESSION['nome'].".json");
        $flag= false;
        $stringa= '<td class="storicotd">';
        $cont=0;
        if(is_file($nome_file)){
            $f= fopen($nome_file, 'r') or die ("Location: ./registrazione.php?Messaggio=Errore+durante+l'apertura+del+file+per+l'aggiunta+utente");
            if(filesize($nome_file)!= 0){
                $lista_accessi= fread($f, filesize($nome_file));
                $lista_accessi= json_decode($lista_accessi, true);
                foreach($lista_accessi as $punt => $contenitore){
                    if($cont<12){
                        foreach($contenitore as $singolo => $contenuto){
                            if($singolo==='time'){
                                echo '<tr> <td class="storicoorario">'.openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()).'</td><td>';
                            }
                            if($singolo==='coutry' && strlen(openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()))>0 || $singolo==='region' && strlen(openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()))>0 || $singolo==='city' && strlen(openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()))>0 || $singolo==='browser' && strlen(openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()))>0)
                                    $stringa= $stringa. openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()) .', ';
                            if($singolo==='OS' && strlen(openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()))>0)
                            $stringa= $stringa. openssl_decrypt($contenuto, "AES-128-CBC", genera_chiave()) ;
                        }
                        $stringa= traduci($stringa, 'en', 'it');
                        echo $stringa.'</td>'; 
                        $stringa= '<td class="storicotd">';
                        $cont++;
                    }
                }
            }
            fclose($f);
        }
    }

    ?>