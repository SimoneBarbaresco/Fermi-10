<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FERMI 10 - Registrazione</title>
        <link href="../CSS/menu-intestazione-pie.css"  style="text/css" rel="stylesheet"/>
        <link href="../CSS/registrazione.css"  style="text/css" rel="stylesheet"/>
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
        session_start();
        if(isset($_SESSION['nome']) && $_SESSION['log'])
            header('Location: ./panoramica.php');
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
                <h4>AREA PERSONALE</h4>
                <ul>
                    <li class="lista" id="Accedi" onmouseover="cambia_sfondo(1, 'Accedi');" onmouseleave="cambia_sfondo(2, 'Accedi');"><a  href="index.php">Accedi</a></li>
                    <li class="lista" style="background-color: #269e84;" id="Registrati"><a style="color: white;" href="registrazione.php">Registrati</a></li>
                </ul>
            </div>
        </div>

        <div class="corpo_principale">
            <div class="blur"></div>
            <div class="black"></div>
            <div class="contenuto">
                <form method="POST" action="aggiungi_utente.php">
                    <span class="nome1">Nome:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input1" type="text" name="nome_utente">
                    <span class="cognome">Cognome:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input1" type="text" name="cognome_utente">
                    <span class="username">Username:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input5" type="text" name="username_utente"><br><br>
                    <span class="avatar">Scegli un'avatar:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar1"><img width="6%" height="6%" src="../IMAGES/avatar1.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar1"><img width="6%" height="6%" src="../IMAGES/avatar2.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar3"><img width="6%" height="6%" src="../IMAGES/avatar3.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar4"><img width="6%" height="6%" src="../IMAGES/avatar4.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar5"><img width="6%" height="6%" src="../IMAGES/avatar5.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar6"><img width="6%" height="6%" src="../IMAGES/avatar6.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar7"><img width="6%" height="6%" src="../IMAGES/avatar7.png">
                    <input onkeypress="content_password(0);" onclick="control_send();" type="radio" name="avatar" value="avatar8"><img width="6%" height="6%" src="../IMAGES/avatar8.png"><br><br><br>
                    <span class="link">O in alternativa inserisci il link a un'immagine:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input3" type="text" name="link_immagine"><br><br><br>
                    <span class="email">E-mail:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input2" type="text" name="email_utente">
                    <span class="codice">Codice:</span>
                    <input value="12345678" onkeypress="content_password(0);" onclick="control_send();" class="input4" type="text" name="codice_utente"><br><br><br>
                    <span class="password1">Password:</span>
                    <input id="password" class="input5" type="password" name="password1_utente" onclick="content_password(1);"  onkeypress="content_password(1);control_send()">
                    <label id="minime" class="minime">La password deve contenere minimo 8 caratteri: minimo 2 numeri, 1 carattere minuscolo e 1 maiuscolo e un carattere speciale.</label><br><br>
                    <span class="password1">Reinserisci password:</span>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input5" type="password" name="password2_utente"><br><br><br>
                    <span class="domanda">Scegli la domanda di sicurezza:</span><br><br>
                    <select onkeypress="content_password(0);" onclick="control_send();" name="domanda">
                        <option value="animale_domestico">Qual è il nome del tuo animale domestico?</option>
                        <option value="citta_natale">Qual è il nome della città in cui sei nato?</option>
                        <option value="piatto_preferito">Qual è il tuo piatto preferito?</option>
                        <option value="film_preferito">Qual è il tuo film prefito?</option>
                        <option value="prima_macchina">Qual è stata la prima macchina che hai avuto?</option>
                        <option value="primo_lavoro">Qual è stato il tuo primo lavoro?</option>
                        <option value="film_preferito">Qual'è il nome del tuo libro preferito?</option>
                    </select>
                    <input onkeypress="content_password(0);" onclick="control_send();" class="input5" type="text" name="domanda_sicurezza"><br><br>
                    <p><img src="./captcha.php" /></p>
                    <span class="email">Captcha: <input class="input4" type="text" name="captcha" /></span><br><br>
                    <input class="registrati" type="submit" value="REGISTRATI" name="submit" id="submit">
                    
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