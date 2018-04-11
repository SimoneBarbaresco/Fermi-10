<?php
    require_once('funzioni.php');

    function crea_chiave($caso){
        switch($caso){
            case 1:
                $stringa_risultante= "";
                $stringa_normale= $_SESSION['nome_utente'];
                $stringa_inversa = strrev($_SESSION['nome_utente']);
                for($i=0; $i< strlen($_SESSION['nome_utente']); $i++)
                    if($i%2==0) 
                        $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
                    else
                        $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
                return $stringa_risultante.strrev($_SESSION['nome_utente']);
            break;

            case 2:
                $stringa_risultante= "";
                $stringa_normale= $_SESSION['nome_utente'];
                $stringa_inversa = strrev($_SESSION['nome_utente']);
                for($i=0; $i< strlen($_SESSION['nome_utente']); $i++)
                    if($i%2==0) 
                        $stringa_risultante= $stringa_risultante.$stringa_inversa[$i];
                    else
                        $stringa_risultante= $stringa_risultante.$stringa_normale[$i];
                return strrev($_SESSION['nome_utente']).$stringa_risultante;
            break;
        }
    }

    function controlla_dati_inseriti(){
        if(isset($_SESSION['nome']) && !empty($_SESSION['nome']) && isset($_SESSION['password']) && !empty($_SESSION['password'])){
            $_SESSION['password']= hash("sha512", hash("md5", $_POST['password_utente']));
            return 1;
        }
        else{
            if(isset($_SESSION['nome']) && !empty($_SESSION['nome']) && isset($_SESSION['domanda'])  &&  isset($_SESSION['risposta']) && !empty($_SESSION['risposta'])){
                $_SESSION['password']= hash("sha512", hash("md5", $_POST['password_utente']));
                $_SESSION['domanda']= hash("sha512", hash("md5", $_SESSION['domanda']));
                $_SESSION['risposta']= hash("sha512", hash("md5", $_SESSION['risposta']));
                return 2;
            }
            else
                return 3;
        }
    }

    function verifica_utente_password(){
        $nome= $_SESSION['nome'];
        $prima_lettera= $nome[0];
        $nome_file= "../FILE/".strtolower($prima_lettera).".json";
        $flag=false;
        if(is_file($nome_file)){
            $f= fopen($nome_file, 'r');
            $lista_utenti= fread($f, filesize($nome_file));
            $lista_utenti= json_decode($lista_utenti, true);
            foreach($lista_utenti as $contenitore_utente => $campo)
                foreach($campo as $singolo_carattere => $contenuto){
                    if($singolo_carattere==='username' && $contenuto===$_SESSION['nome']){
                        $flag= $campo;
                    }
                    if($flag==$campo && $singolo_carattere==='password' && $contenuto===$_SESSION['password'])
                        return true;
                }
        }
        else
            return false;
    }

    function verifica_utente_senza_password(){
        $nome= $_SESSION['nome'];
        $prima_lettera= $nome[0];
        $nome_file= "../FILE/".strtolower($prima_lettera).".json";
        $flag=false; $flag1=true; $flag2= true;
        if(is_file($nome_file)){
            $f= fopen($nome_file, 'r');
            $lista_utenti= fread($f, filesize($nome_file));
            $lista_utenti= json_decode($lista_utenti, true);
            foreach($lista_utenti as $contenitore_utente => $campo)
                foreach($campo as $singolo_carattere => $contenuto){
                    if($singolo_carattere==='username' && $contenuto===$_SESSION['nome']){
                        $flag= $campo;
                    } 
                    if($flag1 && $flag==$campo && $singolo_carattere==='domanda' && $contenuto==$_SESSION['domanda']){
                        $flag2= true;
                    }
                    if($flag1 && $flag2 && $flag==$campo && $singolo_carattere==='risposta' && $contenuto===$_SESSION['risposta'])
                        return true;
                }
            return false;
        }
        else
            return false;
    }

    session_destroy();
    session_start();
    $_SESSION['nome']= trim($_POST['id_utente']);
    $_SESSION['password']= $_POST['password_utente'];
    $_SESSION['domanda']= $_POST['domanda'];
    $_SESSION['risposta']= trim($_POST['risposta']);
    $_SESSION['orario_accesso']= date('d/m/Y h:i:s', time());
    $_SESSION['log']= false;

    switch(controlla_dati_inseriti()){
        case 1:
            if(verifica_utente_password()){
                $_SESSION['log']= true;
                carica_dati();
                header("Location: ./registra_accesso1.php");//header("Location: ./panoramica.php");
            }
            else{
                header("Location: ./?Messaggio=Utente+non+registrato");
            }
        break;

        case 2:
            if(verifica_utente_senza_password()){
                $_SESSION['log']= true;
                carica_dati();
                header("Location: ./registra_accesso.php");//header("Location: ./profilo.php");
            }
            else{
                header("Location: ./?Messaggio=Utente+non+registrato");
            }
        break;

        default:
            header("Location: ./?Messaggio=Campi+vuoti");
        break;
    }
?>