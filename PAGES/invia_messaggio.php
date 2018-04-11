<?php
    require_once('funzioni.php');
    require_once('BotAi.php');
    session_start();
    function controlla($string){
        if(isset($_GET[$string]) && !empty(trim($_GET[$string])))
            return trim($_GET[$string]);
        else
            return false;
    }
    
    $destinatario= controlla('destinatario');
    $contenutomessaggio= controlla('contenutomessaggio');
    $primofile= '../FILE/'.$_SESSION['nome'].'-'.$destinatario.'.json';
    $secondofile= '../FILE/'.$destinatario.'-'.$_SESSION['nome'].'.json';

    if($destinatario!= false && $contenutomessaggio!=false){
        if(is_file($primofile)){
            $f= fopen($primofile, 'r');
            $lista_messaggi= fread($f,filesize($primofile));
            $lista_messaggi= openssl_decrypt($lista_messaggi, "AES-128-CBC", $primofile);
            $lista_messaggi= json_decode($lista_messaggi, true);
            fclose($f);
            $lista_messaggi[]=[
                'mittentemessaggio'=> $_SESSION['nome'],
                'orariomessaggio' => date('d/m/Y h:i:s', time()),
                'minutimessaggio' => date('i'),
                'contenutomessaggio' => $contenutomessaggio
            ];

            if($destinatario==='FermiBot'){
                $lista_messaggi[]=[
                    'mittentemessaggio'=> 'FermiBot',
                    'orariomessaggio' => date('d/m/Y h:i:s', time()),
                    'minutimessaggio' => date('i'),
                    'contenutomessaggio' => get_bot_message($contenutomessaggio, 1)
                ];
            }
            $f= fopen($primofile, 'w');
            $lista_messaggi= openssl_encrypt(json_encode($lista_messaggi, JSON_PRETTY_PRINT), "AES-128-CBC", $primofile);
            fwrite($f, $lista_messaggi);
            fclose($f);
            echo true;
        }
        else {
            if(is_file($secondofile)){
                $primofile= $secondofile;
                $f= fopen($primofile, 'r');
                $lista_messaggi= fread($f,filesize($primofile));
                $lista_messaggi= openssl_decrypt($lista_messaggi, "AES-128-CBC", $primofile);
                $lista_messaggi= json_decode($lista_messaggi, true);
                fclose($f);
                $lista_messaggi[]=[
                    'mittentemessaggio'=> $_SESSION['nome'],
                    'orariomessaggio' => date('d/m/Y h:i:s', time()),
                    'minutimessaggio' => date('i'),
                    'contenutomessaggio' => $contenutomessaggio
                ];
                $f= fopen($primofile, 'w');
                $lista_messaggi= openssl_encrypt(json_encode($lista_messaggi, JSON_PRETTY_PRINT), "AES-128-CBC", $primofile);
                fwrite($f, $lista_messaggi);
                fclose($f);
                echo true;
            }
            else{
                $f= fopen($primofile, 'w');
                $lista_messaggi[]= [
                    'mittentemessaggio'=> $_SESSION['nome'],
                    'orariomessaggio' => date('d/m/Y h:i:s', time()),
                    'minutimessaggio' => date('i'),
                    'contenutomessaggio' => $contenutomessaggio, 
                ];
                $lista_messaggi= json_encode($lista_messaggi, JSON_PRETTY_PRINT);
                $lista_messaggi= openssl_encrypt($lista_messaggi, "AES-128-CBC", $primofile);
                fwrite($f, $lista_messaggi);
                fclose($f);

                if($destinatario==='FermiBot'){
                    $f= fopen($primofile, 'r');
                    $lista_messaggi= fread($f,filesize($primofile));
                    $lista_messaggi= openssl_decrypt($lista_messaggi, "AES-128-CBC", $primofile);
                    $lista_messaggi= json_decode($lista_messaggi, true);
                    fclose($f);
                    $lista_messaggi[]=[
                        'mittentemessaggio'=> 'FermiBot',
                        'orariomessaggio' => date('d/m/Y h:i:s', time()),
                        'minutimessaggio' => date('i'),
                        'contenutomessaggio' => get_bot_message($contenutomessaggio, 1)
                    ];
                    $f= fopen($primofile, 'w');
                    $lista_messaggi= json_encode($lista_messaggi, JSON_PRETTY_PRINT);
                    $lista_messaggi= openssl_encrypt($lista_messaggi, "AES-128-CBC", $primofile);
                    fwrite($f, $lista_messaggi);
                    fclose($f);
                }
                echo true;
            }
        }
}
?>