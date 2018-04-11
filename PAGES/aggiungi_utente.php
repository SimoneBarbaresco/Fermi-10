<?php
        require_once('funzioni.php');

        function crea_chiave($caso){
            switch($caso){
                case 1:
                    $stringa_risultante= "";
                    $stringa_normale= $_SESSION['username_utente'];
                    $stringa_inversa = strrev($_SESSION['username_utente']);
                    for($i=0; $i< strlen($_SESSION['username_utente']); $i++)
                        if($i%2==0) 
                            $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
                        else
                            $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
                    return $stringa_risultante.strrev($_SESSION['username_utente']);
                break;

                case 2:
                    $stringa_risultante= "";
                    $stringa_normale= $_SESSION['username_utente'];
                    $stringa_inversa = strrev($_SESSION['username_utente']);
                    for($i=0; $i< strlen($_SESSION['username_utente']); $i++)
                        if($i%2==0)
                            $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
                        else
                            $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
                    return strrev($_SESSION['username_utente']).$stringa_risultante;
                break;
            }
        }

        function controlla_dati_inseriti(){
            $flag= true;
            if($flag && !isset($_SESSION['nome_utente']) || empty($_SESSION['nome_utente'])){
                $flag= false;
            }
            if($flag &&!isset($_SESSION['cognome_utente']) || empty($_SESSION['cognome_utente']))
                $flag= false;
            if($flag && !isset($_SESSION['username_utente']) || empty($_SESSION['username_utente']))
                $flag= false;
            if($flag && !isset($_SESSION['email']) || empty($_SESSION['email']))
                $flag= false;
            if($flag && !isset($_SESSION['codice']) || empty($_SESSION['codice']) && strlen($_SESSION['codice'])==8)
                $flag= false;
            if($flag && !isset($_SESSION['risposta']) || empty($_SESSION['risposta']))
                $flag= false;
            if($flag && !isset($_SESSION['captcha']) || empty($_SESSION['captcha']))
                $flag= false;
            return $flag;
        }

        function valida_dati(){
            if($_SESSION['captcha']==$_SESSION['captcha_controllo'] && $_SESSION['password1']==$_SESSION['password2'] && filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL))
                return true;
            else
                return false;
        }
        
        function controlla_presenza($chiave, $lunghezza_nome){
            $nome= openssl_decrypt($_SESSION['username_utente'], "AES-128-CBC", $chiave);
            $prima_lettera= $nome[0];
            $nome_file= strtolower("../FILE/".$prima_lettera.".json");
            if(is_file($nome_file)){
                $flag= false;
                    if(filesize($nome_file)>0){
                        $f= fopen($nome_file, 'r') or die ("Location: ./registrazione.php?Messaggio=Errore+durante+il+controllo+presenza");
                        $lista_utenti_registrati= fread($f, filesize($nome_file));
                        $lista_utenti_registrati= json_decode($lista_utenti_registrati, true);
                        foreach($lista_utenti_registrati as $contenitore_dati_utente => $campo){
                            foreach($campo as $singolo_carattere => $contenuto){
                                if($singolo_carattere== "username" && $contenuto === openssl_decrypt($_SESSION['username_utente'], "AES-128-CBC", $chiave)){ 
                                    $flag= true;
                                }
                            }
                        }
                        fclose($f);
                    }
                    return $flag;
            }
            else
                return false;
        }

        function controlla_codice(){
            $flag= false;
            $f= fopen("../FILE/codici.txt", 'r') or die("Location: ./registrazione.php?Messaggio=Errore+durante+il+controllo+codice");
            while(!$flag && $codice= fgets($f)){
                if($codice== $_SESSION['codice'])
                    $flag= true;
            }
            fclose($f);
            return $flag;
        }

        function aggiungi_utente($lunghezza_nome, $prima_chiave){
            if(controlla_codice()){
                $nome= $_SESSION['username_utente'];
                $nome= openssl_decrypt($nome, "AES-128-CBC", $prima_chiave);
                $prima_lettera= $nome[0];
                $nome_file= strtolower("../FILE/".$prima_lettera.".json");
                if(is_file($nome_file)){
                    $f= fopen($nome_file, 'r') or die ("Location: ./registrazione.php?Messaggio=Errore+durante+l'apertura+del+file+per+l'aggiunta+utente");
                    if(filesize($nome_file)!= 0){
                        $lista_utenti_registrati= fread($f, filesize($nome_file));
                        $lista_utenti_registrati= json_decode($lista_utenti_registrati, true);
                    }
                    fclose($f);
                }
                else{
                    $lista_utenti_registrati[]=[
                        "username" => " ",
                        "name" => " ",
                        "cognome" => " ",
                        "avatar" => " ",
                        "link" => " ",
                        "email" => " ",
                        "codice" => " ",
                        "password" => " ",
                        "domanda" => " ",
                        "risposta" => " ",
                        "orario" => " "  
                    ];
                }

                $lista_utenti_registrati[]=[
                    "username" => openssl_decrypt($_SESSION['username_utente'], "AES-128-CBC", $prima_chiave),
                    "name" => $_SESSION['nome_utente'],
                    "cognome" => $_SESSION['cognome_utente'],
                    "avatar" => $_SESSION['avatar'],
                    "link" => $_SESSION['link'],
                    "email" => $_SESSION['email'],
                    "codice" => hash("sha512", $_SESSION['codice']),
                    "password" => $_SESSION['password1'],
                    "domanda" => $_SESSION['domanda'],
                    "risposta" => $_SESSION['risposta'],
                    "orario" => $nome.".json"   
                ];
                usort($lista_utenti_registrati, 
                    function($ind1, $ind2){
                        return $ind1['username'] <=> $ind2['username'];
                });
                $lista_utenti_registrati= json_encode($lista_utenti_registrati, JSON_PRETTY_PRINT);
                $f= fopen($nome_file, 'w');
                fwrite($f, $lista_utenti_registrati);
                fclose($f);
                return true;
            }
            else{
                return false;
            }
        }
        //prove
        
        //recupero dati inseriti e crittografia parziale
        session_start(); 
        $_SESSION['nome_utente']= trim($_POST['nome_utente']);
        $_SESSION['cognome_utente']= trim($_POST['cognome_utente']);
        $_SESSION['username_utente']= trim($_POST['username_utente']);
        $lunghezza_nome= strlen($_SESSION['username_utente']);
        if(strlen($_SESSION['username_utente'])%2==0)
            $prima_chiave= crea_chiave(1);
        else
            $prima_chiave= crea_chiave(2);
        if(isset($_POST['avatar']))
            $_SESSION['avatar']= $_POST['avatar'];
        else
            $_SESSION['avatar']= null;
        $_SESSION['link']= trim($_POST['link_immagine']);
        $_SESSION['email']= strtolower(trim($_POST['email_utente']));
        $_SESSION['codice']= trim($_POST['codice_utente']);
        $_SESSION['password1']= hash("sha512", hash("md5", $_POST['password1_utente']));
        $_SESSION['password2']= hash("sha512", hash("md5", $_POST['password2_utente']));
        $_SESSION['domanda']= hash("sha512", hash("md5", $_POST['domanda']));
        $_SESSION['risposta']= hash("sha512", hash("md5", trim($_POST['domanda_sicurezza'])));
        $_SESSION['captcha']= hash("sha512", trim($_POST['captcha']));
        $_SESSION['orario_accesso']= date('m/d/Y h:i:s', time());

        //controllo dati, crittografia completa e registrazione utente
        if(controlla_dati_inseriti()){
            $_SESSION['nome_utente']= openssl_encrypt($_POST['nome_utente'], "AES-128-CBC", $prima_chiave);
            $_SESSION['cognome_utente']= openssl_encrypt($_POST['cognome_utente'], "AES-128-CBC", $prima_chiave);
            $_SESSION['username_utente']= openssl_encrypt($_POST['username_utente'], "AES-128-CBC", $prima_chiave);
            if(valida_dati()){
                if(!controlla_presenza($prima_chiave, $lunghezza_nome)){
                    $_SESSION['email']= openssl_encrypt($_POST['email_utente'], "AES-128-CBC", $prima_chiave);
                    $flag= aggiungi_utente($lunghezza_nome, $prima_chiave);
                    if($flag){
                        header("Location: ./index.php");
                    }
                    else
                        header("Location: ./registrazione.php?Messaggio=Codice+errato");
                }
                else
                    header("Location: ./registrazione.php?Messaggio=Password+non+corrispondenti");
            }
            else
                header("Location: ./registrazione.php?Messaggio=Utente+già+registrato+o+captcha+errato");
        }
    else
        header("Location: ./registrazione.php?Messaggio=Dati+inseriti+in+modo+errato");
?>