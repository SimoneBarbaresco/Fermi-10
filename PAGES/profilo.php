<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FERMI 10 - Profilo</title>
        <link href="../CSS/profilo.css"  style="text/css" rel="stylesheet"/>
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

        function content_password(n){
            if(n==1)
                document.getElementById('minime').style.opacity= 1;
            else
                document.getElementById('minime').style.opacity= 0;
        }

        function blocca(){
            document.getElementById("submit").disabled = true;
        }

        function control_send(){
            password=document.getElementById('password').value;
            cont_maiu= 0;
            cont_minu= 0
            cont_numb= 0;
            cont_spec= 0;
            for(i=0;i<password.length;i++){
                vari = password[i].charCodeAt(0);
                if(vari>64 && vari<91){
                    cont_maiu++;
                }
                if(vari>32 && vari<48){
                    cont_spec++;
                }
                if(vari>57 && vari<65){
                    cont_spec++;
                }
                if(vari>47 && vari<58){
                    cont_numb++;
                }
                if(vari>96 && vari<123)
                    cont_minu++;
            }
            if(cont_maiu>1 && cont_numb>2 && cont_spec>1 && cont_minu>1 && password.length>6){
                document.getElementById("minime").style.borderBottom= "solid #269e84 4px";
            }
            else{
                if(cont_maiu>0 && cont_numb>1 && cont_spec>0 && password.length>6 && cont_minu>0){
                    document.getElementById("minime").style.borderBottom= "solid #f1c40f 4px";
                }
                else{
                    document.getElementById("minime").style.borderBottom= "solid #c0392b 4px";
                }
            }
            
            if(cont_maiu>0 && cont_numb>1 && cont_spec>0 && password.length>6 && cont_minu>0)
                document.getElementById("submit").disabled = false;
            else
                document.getElementById("submit").disabled = true;
            setTimeout(control_send, 500);
        }
    </script>

    <?php
        require_once('funzioni.php');
        session_start();
        if(!isset($_SESSION['nome']) || !$_SESSION['log'])
            header('Location: ./index.php');
    ?>

    <body onload="blocca();">
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
                    <li class="lista" id="Carte" onmouseover="cambia_sfondo(1, 'Carte');" onmouseleave="cambia_sfondo(2, 'Carte');"><a href="carte.php">Carte</a></li>
                    <li class="lista" id="Investimenti" onmouseover="cambia_sfondo(1, 'Investimenti');" onmouseleave="cambia_sfondo(2, 'Investimenti');"><a href="investimenti.php">Investimenti</a></li>
                    <li class="lista" style="background-color: #269e84;" id="Profilo" ><a style="color: white;" href="profilo.php">Profilo</a></li>
                </ul>
            </div>
        </div>

        <div class="corpo_principale">
            <div class="blur" id="blur"></div>
            <div class="black" id="black"></div>
            <div class="contenuto" id="contenuto">
                <div class="riassunto_profilo">
                    <form action="cambia_dati.php" method="POST">
                        <table>
                            <tr>
                                <td rowspan="3" class="contenitore_immagine"><?php 
                                    if(!empty($_SESSION['link']))
                                        echo '<img src="'. $_SESSION['link'] .'" class="immagine_utente"/>';
                                    else
                                        echo '<img src="../IMAGES/'. $_SESSION['avatar'] .'.png" class="immagine_utente"/>';
                                    ?></td>
                                <td><input onkeypress="content_password(0);" onclick="control_send();" type="text" name="nome" class="nome1" value=<?php echo '"'. openssl_decrypt($_SESSION['name'], "AES-128-CBC", genera_chiave()).'"'?>/></td>
                            </tr>
                            <tr colspan="2">
                                <td><input onkeypress="content_password(0);" onclick="control_send();" type="text" name="cognome" class="cognome" value=<?php echo '"'. openssl_decrypt($_SESSION['cognome'], "AES-128-CBC", genera_chiave()).'"'?>/></td>
                            </tr>
                            <tr colspan="2">
                                <td><input onkeypress="content_password(0);" onclick="control_send();" type="text" name="username" class="username" value=<?php echo '"'.$_SESSION['nome'].'"'?>/></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input onkeypress="content_password(0);" onclick="control_send();" type="text" name="link" class="link" value=<?php echo '"'. $_SESSION['link'].'"'?>/></td>
                            </tr>
                        </table>

                        <span>E-Mail: </span><input onkeypress="content_password(0);" onclick="control_send();" type="text" name="email" class="email" value=<?php echo '"'. openssl_decrypt($_SESSION['email'], "AES-128-CBC", genera_chiave()).'"'?>/>
                        <br><span>Password: </span><input  onclick="content_password(1);"  onkeypress="content_password(1);control_send()" type="password" name="password1" class="password3" id="password" value=<?php echo '"P4ssword"'?>/>
                        <br><span>Reinserisci Password: </span><input onkeypress="content_password(0);" onclick="control_send();" type="password" name="password2" class="password4" value=<?php echo '"P4ssword"'?>/>
                        <br><span>Domanda di sicurezza: </span><br><select onkeypress="content_password(0);" onclick="control_send();" name="domanda" class=domanda >
                            <option value="animale_domestico">Qual è il nome del tuo animale domestico?</option>
                            <option value="citta_natale">Qual è il nome della città in cui sei nato?</option>
                            <option value="piatto_preferito">Qual è il tuo piatto preferito?</option>
                            <option value="film_preferito">Qual è il tuo film prefito?</option>
                            <option value="prima_macchina">Qual è stata la prima macchina che hai avuto?</option>
                            <option value="primo_lavoro">Qual è stato il tuo primo lavoro?</option>
                            <option value="film_preferito">Qual'è il nome del tuo libro preferito?</option>
                        </select>
                        <br><input onkeypress="content_password(0);" onclick="control_send();" type="text" name="risposta" class="risposta" value=<?php echo '"Risposta"'?>/>
                        <br><input type="submit" class="invia" name="submit" value="INVIA MODIFICHE" id="submit">
                        <?php
                        if(isset($_REQUEST['Messaggio']) && !empty(trim($_REQUEST['Messaggio']))){
                            echo '<p class="messaggio">'. $_REQUEST['Messaggio'] .'</p>';
                            unset($_REQUEST);
                        }
                    ?>
                    </table>
                    </form>
                    <label id="minime" class="minime">La password deve contenere minimo 8 caratteri: minimo 2 numeri, 1 carattere minuscolo e 1 maiuscolo e un carattere speciale.</label><br><br>
                </div>
                <div class="storia_accessi">
                    <table class="storico">
                        <th class="storicoth">STORICO ACCESSI: </th>
                        <?php
                            stampa_accessi();
                        ?>
                    </table>
                </div>
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