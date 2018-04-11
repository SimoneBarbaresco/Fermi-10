<?php
    require_once('funzioni.php');
    session_start();

    function verifica_dati(){
        if(!empty($_SESSION['nome1']) && !empty($_SESSION['cognome1']) && !empty($_SESSION['username1']) && !empty($_SESSION['email1']) && !empty($_SESSION['risposta1']))
            return true;
        else
            return false;
    }

    function migra_dati_accesso(){
        $nome_file_vecchio= "../FILE/".$_SESSION['utente_corrente'].".json";
        $nome_file_nuovo= "../FILE/".$_SESSION['username1'].".json";
        $f= fopen($nome_file_vecchio, 'r');
        $lista_accessi= fread($f, filesize($nome_file_vecchio));
        fclose($f);
        $f= fopen($nome_file_nuovo, 'w');
        fwrite($f, $lista_accessi);
        fclose($f);
        unlink($nome_file_vecchio);
    }

    function controlla_password(){
        if($_SESSION['password1']== $_SESSION['password2']){
            $nome= $_SESSION['utente_corrente'];
            $prima_lettera= $nome[0];
            $nome_file= strtolower("../FILE/".$prima_lettera.".json");
            if(is_file($nome_file)){
                $f= fopen($nome_file, 'r') or die ("Location: ./registrazione.php?Messaggio=Errore+durante+l'apertura+del+file+per+l'aggiunta+utente");
                if(filesize($nome_file)!= 0){
                    $lista_utenti_registrati= fread($f, filesize($nome_file));
                    $lista_utenti_registrati= json_decode($lista_utenti_registrati, true);
                }
                fclose($f);
                $arriva_utente= false;
                $password_verificata= false;
                $cont=-1;
                foreach($lista_utenti_registrati as $puntatore_contenitore => $contenitore){
                    if(!$arriva_utente){
                        $cont++;
                        foreach($contenitore as $campo => $contenuto){
                            if($campo==='username' && $contenuto===$_SESSION['utente_corrente'])
                                $arriva_utente= true;
                            if($campo==='password' && $contenuto==$_SESSION['password1'])
                                $password_verificata= true;
                            if($arriva_utente && $campo==='avatar')
                                $_SESSION['avatar']= $contenuto;
                            if($arriva_utente && $campo==='codice')
                                $_SESSION['codice']= $contenuto;
                        }
                    }
                }
                array_splice($lista_utenti_registrati, $cont, 1);
                $f= fopen($nome_file, 'w');
                fwrite($f, json_encode($lista_utenti_registrati, JSON_PRETTY_PRINT));
                fclose($f);
                //registrazione nuovo utente
                migra_dati_accesso();
                if($_SESSION['username1']!== $_SESSION['utente_corrente']){
                    echo "entrato";
                    $nome= $_SESSION['username1'];
                    $prima_lettera= $nome[0];
                    $nome_file= strtolower("../FILE/".$prima_lettera.".json");
                    unset($lista_utenti);
                    if(!is_file($nome_file)){
                        echo "entrato di nuovo";
                        $lista_utenti[]=[
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
                    else{
                        $f= fopen($nome_file, 'r');
                        $lista_utenti= fread($f, filesize($nome_file));
                        fclose($f);
                        $lista_utenti= json_decode($lista_utenti, true);
                    }
                    $lista_utenti[]=[
                        "username" => $_SESSION['username1'],
                        "name" => $_SESSION['nome1'],
                        "cognome" => $_SESSION['cognome1'],
                        "avatar" => $_SESSION['avatar'],
                        "link" => $_SESSION['link1'],
                        "email" => $_SESSION['email1'],
                        "codice" => $_SESSION['codice'],
                        "password" => $_SESSION['password1'],
                        "domanda" => $_SESSION['domanda1'],
                        "risposta" => $_SESSION['risposta1'],
                        "orario" => $_SESSION['username1'].".json"  
                    ];
                    $f= fopen($nome_file, 'w');
                    $lista_utenti= json_encode($lista_utenti, JSON_PRETTY_PRINT);
                    fwrite($f, $lista_utenti);
                    fclose($f);
                }
                else{
                    $nome= $_SESSION['username1'];
                    $prima_lettera= $nome[0];
                    $nome_file= strtolower("../FILE/".$prima_lettera.".json");
                    
                    $lista_utenti_registrati[]=[
                        "username" => $_SESSION['username1'],
                        "name" => $_SESSION['nome1'],
                        "cognome" => $_SESSION['cognome1'],
                        "avatar" => $_SESSION['avatar'],
                        "link" => $_SESSION['link1'],
                        "email" => $_SESSION['email1'],
                        "codice" => $_SESSION['codice'],
                        "password" => $_SESSION['password1'],
                        "domanda" => $_SESSION['domanda1'],
                        "risposta" => $_SESSION['risposta1'],
                        "orario" => $_SESSION['username1'].".json" 
                    ];
                    usort($lista_utenti_registrati, 
                        function($ind1, $ind2){
                            return $ind1['user'] <=> $ind2['user'];
                    });
                    $lista_utenti_registrati= json_encode($lista_utenti_registrati, JSON_PRETTY_PRINT);
                    $f= fopen($nome_file, 'w');
                    fwrite($f, $lista_utenti_registrati);
                    fclose($f);
                }
                return true;
            }
            else
                return false;
        }
        else 
            return false;
    }

    function controlla_presenza_utente(){
        $nome= $_SESSION['username1'];
        $prima_lettera= $nome[0];
        $nome_file= strtolower("../FILE/".$prima_lettera.".json");
        var_dump($nome_file);
        if(is_file($nome_file)){
            $flag= false;
            if(filesize($nome_file)>0){
                $f= fopen($nome_file, 'r') or die ("Location: ./registrazione.php?Messaggio=Errore+durante+il+controllo+presenza");
                $lista_utenti_registrati= fread($f, filesize($nome_file));
                $lista_utenti_registrati= json_decode($lista_utenti_registrati, true);
                foreach($lista_utenti_registrati as $contenitore_dati_utente => $campo){
                    foreach($campo as $singolo_carattere => $contenuto){
                        if($singolo_carattere== "username" && $contenuto === $_SESSION['username1']){ 
                            echo "primo";
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

    $_SESSION['utente_corrente']= $_SESSION['nome'];
    $_SESSION['nome1']= $_POST['nome'];
    $_SESSION['cognome1']= $_POST['cognome'];
    $_SESSION['username1']= $_POST['username'];
    $_SESSION['link1']= $_POST['link'];
    $_SESSION['email1']= $_POST['email'];
    $_SESSION['password1']= hash("sha512", hash("md5", $_POST['password1']));
    $_SESSION['password2']= hash("sha512", hash("md5", $_POST['password2']));
    $_SESSION['domanda1']= hash("sha512", hash("md5", $_POST['domanda']));
    $_SESSION['risposta1']= hash("sha512", hash("md5", $_POST['risposta']));

    if(verifica_dati()){
        $_SESSION['nome1']= openssl_encrypt($_SESSION['nome1'], "AES-128-CBC", genera_chiave1($_SESSION['username1']));
        $_SESSION['cognome1']= openssl_encrypt($_SESSION['cognome1'], "AES-128-CBC", genera_chiave1($_SESSION['username1']));
        $_SESSION['email1']= openssl_encrypt($_SESSION['email1'], "AES-128-CBC", genera_chiave1($_SESSION['username1']));
        if(controlla_presenza_utente()){
            if(controlla_password()){
                $_SESSION['nome']= $_SESSION['username1'];
                carica_dati();
                $_SESSION['log']= false;
                header("Location: ./index.php");
            }
            else
                header("Location: ./profilo.php?Messaggio=Password+non+corrispondenti");
        }
        else
            header("Location: ./profilo.php?Messaggio=Utente+già+registrato");
    }
    else
        header("Location: ./profilo.php?Messaggio=Errore+nell'inserimento+dati");
?>