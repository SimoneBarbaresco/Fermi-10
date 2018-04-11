<?php
        session_start();
        if(isset($_SESSION['nome']) && $_SESSION['log'])
            header('Location: ./panoramica.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FERMI 10 - Accesso</title>
        <link href="../CSS/corpo-centrale.css"  style="text/css" rel="stylesheet"/>
        <link href="../CSS/menu-intestazione-pie.css"  style="text/css" rel="stylesheet"/
    </head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script language="javascript">
        function cambia_sfondo(n, nomeId){
            switch(n){
                case 1:
                    document.getElementById(nomeId).style.backgroundColor= "#191b1d";
                break;

                case 2:
                    document.getElementById(nomeId).style.backgroundColor= "#33363B";
                break;
            }
        }
        var password_state=0;
        function vedi_password(){
            if(password_state==0){
                document.getElementById("accedi").style.top= "101%";
                document.getElementById("password_dimenticata").style.zIndex= "5";
                document.getElementById("copertura").style.zIndex= "-1";
                document.getElementById("domande").style.zIndex= "5";
                document.getElementById("password_dimenticata").style.opacity= "1";
                document.getElementById("domande").style.opacity= "1";
                document.getElementById("copertura").style.opacity= "0";
                document.getElementById("contenuto").style.height= "33%";
                document.getElementById("black").style.height= "43%";
                document.getElementById("blur").style.height= "43%";
                password_state= 1;
            }
            else{
                document.getElementById("accedi").style.top= "83%";
                document.getElementById("password_dimenticata").style.zIndex= "1";
                document.getElementById("copertura").style.zIndex= "2";
                document.getElementById("domande").style.zIndex= "0";
                document.getElementById("password_dimenticata").style.opacity= "0";
                document.getElementById("domande").style.opacity= "0";
                document.getElementById("copertura").style.opacity= "0";
                document.getElementById("contenuto").style.height= "32%";
                document.getElementById("black").style.height= "37.5%";
                document.getElementById("blur").style.height= "37.5%";
                password_state= 0;
            }
        }


    </script>

    <body>
        <div class="menu_laterale">
            <div class="nome"><h1>FERMI 10</h1></div>
            <div class="opzioni">
                <h4>SITO</h4>
                <ul>
                    <li class="lista" id="Homepage" onmouseover="cambia_sfondo(1, 'Homepage');" onmouseleave="cambia_sfondo(2, 'Homepage');"><a href="">Homepage</a></li>
                    <li class="lista" id="Privati" onmouseover="cambia_sfondo(1,'Privati');" onmouseleave="cambia_sfondo(2, 'Privati');"><a href="">Privati</a></li>
                    <li class="lista" id="Imprese" onmouseover="cambia_sfondo(1, 'Imprese');" onmouseleave="cambia_sfondo(2, 'Imprese');"><a href="">Imprese</a></li>
                    <li class="lista" id="Gruppo" onmouseover="cambia_sfondo(1, 'Gruppo');" onmouseleave="cambia_sfondo(2, 'Gruppo');"><a href="">Gruppo</a></li>
                </ul>
            </div>
            <div class="area_personale">
                <h4>AREA PERSONALE</h4>
                <ul>
                    <li class="lista" style="background-color: #269e84;" id="Accedi" ><a style="color: white;" href="index.php">Accedi</a></li>
                    <li class="lista" id="Registrati" onmouseover="cambia_sfondo(1, 'Registrati');" onmouseleave="cambia_sfondo(2, 'Registrati');"><a href="registrazione.php">Registrati</a></li>
                </ul>
            </div>
        </div>

        <div class="corpo_principale">
            <div class="blur" id="blur"></div>
            <div class="black" id="black"></div>
            <div class="contenuto" id="contenuto">
                <form method="POST" action="login.php">
                    <p class="titoli">Nome Utente:</p>
                    <input type="text" id="id_utente" name="id_utente" class="input-login">
                    <p class="titoli">Password:</p>
                    <input type="password" id="password_utente" name="password_utente" class="input-login"><br><br>
                    <p class="password" onclick="vedi_password();">Password dimenticata</p>
                    <div class="copertura" id="copertura">&nbsp</div>
                    <select name="domanda" class="domande" id="domande">
                        <option value="animale_domestico">Qual è il nome del tuo animale domestico?</option>
                        <option value="citta_natale">Qual è il nome della città in cui sei nato?</option>
                        <option value="piatto_preferito">Qual è il tuo piatto preferito?</option>
                        <option value="film_preferito">Qual è il tuo film prefito?</option>
                        <option value="prima_macchina">Qual è stata la prima macchina che hai avuto?</option>
                        <option value="primo_lavoro">Qual è stato il tuo primo lavoro?</option>
                        <option value="film_preferito">Qual'è il nome del tuo libro preferito?</option>
                    </select>
                    <input type="text" name="risposta" class="input-login2" id="password_dimenticata">
                    <input class="accedi" id="accedi" type="submit" value="ACCEDI">
                    <?php
                        if(isset($_REQUEST['Messaggio']) && !empty(trim($_REQUEST['Messaggio']))){
                            echo '<p class="messaggio">'. $_REQUEST['Messaggio'] .'</p>';
                            unset($_REQUEST);
                        }
                    ?>
                </form>
            </div>
        </div>

        <div class="pie_pagina">
            <ul>
                <li class="lista" id="Contatti" onmouseover="cambia_sfondo(1, 'Contatti');" onmouseleave="cambia_sfondo(2, 'Contatti');"><a href="">Contatti</a></li>
                <li class="lista" id="FAQ" onmouseover="cambia_sfondo(1, 'FAQ');" onmouseleave="cambia_sfondo(2, 'FAQ');"><a href="">FAQ</a></li>
                <li class="lista" style="padding-bottom: 2%;" id="Assistenza" onmouseover="cambia_sfondo(1, 'Assistenza');" onmouseleave="cambia_sfondo(2, 'Assistenza');"><a href="">Assistenza</a></li>
            </ul>
            <p class="timbro">&copy;Copyright - All right reserved - Feb 2018<br>Fermi-10: a project created and developed by Simone Barbaresco<br><br></p>
        </div>
    </body>
</html>