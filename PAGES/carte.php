<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FERMI 10 - Carte</title>
        <link href="../CSS/corpo-centrale.css"  style="text/css" rel="stylesheet"/>
        <link href="../CSS/menu-intestazione-pie.css"  style="text/css" rel="stylesheet"/>
    </head>

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
                document.getElementById("codice").style.zIndex= "5";
                document.getElementById("copertura").style.zIndex= "-1";
                document.getElementById("domande").style.zIndex= "5";
                document.getElementById("password_dimenticata").style.opacity= "1";
                document.getElementById("codice").style.opacity= "1";
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
                document.getElementById("codice").style.zIndex= "1";
                document.getElementById("copertura").style.zIndex= "2";
                document.getElementById("domande").style.zIndex= "0";
                document.getElementById("password_dimenticata").style.opacity= "0";
                document.getElementById("codice").style.opacity= "0";
                document.getElementById("domande").style.opacity= "0";
                document.getElementById("copertura").style.opacity= "0";
                document.getElementById("contenuto").style.height= "32%";
                document.getElementById("black").style.height= "37.5%";
                document.getElementById("blur").style.height= "37.5%";
                password_state= 0;
            }
        }
    </script>

    <?php
        require_once('funzioni.php');
        session_start();
        if(!isset($_SESSION['nome']) || !$_SESSION['log'])
            header('Location: ./index.php');
    ?>

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
            <div class="area_utente">
                <table class="tabella">
                        <tr>
                            <td class="colonna_1"><?php echo openssl_decrypt($_SESSION['name'], "AES-128-CBC", genera_chiave()). " ". openssl_decrypt($_SESSION['cognome'], "AES-128-CBC", genera_chiave());?></td>
                            <td rowspan="2" class="colonna_2"><?php 
                                if(!empty($_SESSION['link']))
                                    echo '<span><img src="'. $_SESSION['link'] .'" class="immagine_utente"/></span>';
                                else
                                    echo '<span><img src="../IMAGES/'. $_SESSION['avatar'] .'.png" class="immagine_utente"/></span>';
                            ?></td>
                        </tr>
                        <tr>
                            <td><a style="color: #2980b9;" href="logout.php">Esci</a></form></td>
                        </tr>
                    </table>
                </div>
                <ul>
                    <li class="lista" onmouseover="cambia_sfondo(1, 'Panoramica');" onmouseleave="cambia_sfondo(2, 'Panoramica');" id="Panoramica" ><a href="panoramica.php">Panoramica</a></li>
                    <li class="lista" id="Chat" onmouseover="cambia_sfondo(1, 'Chat');" onmouseleave="cambia_sfondo(2, 'Chat');"><a href="chat.php">Invia Ricevi Chat</a></li>
                    <li class="lista" style="background-color: #269e84;" id="Carte"><a style="color: white;" href="carte.php">Carte</a></li>
                    <li class="lista" id="Investimenti" onmouseover="cambia_sfondo(1, 'Investimenti');" onmouseleave="cambia_sfondo(2, 'Investimenti');"><a href="investimenti.php">Investimenti</a></li>
                    <li class="lista" id="Profilo" onmouseover="cambia_sfondo(1, 'Profilo');" onmouseleave="cambia_sfondo(2, 'Profilo');"><a href="profilo.php">Profilo</a></li>
                </ul>
            </div>
        </div>

        <div class="corpo_principale">
            <div class="blur" id="blur"></div>
            <div class="black" id="black"></div>
            <div class="contenuto" id="contenuto">
                
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