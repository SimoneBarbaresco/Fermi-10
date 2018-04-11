<?php
        require_once('funzioni.php');
        session_start();
        if(!isset($_SESSION['nome']) && !$_SESSION['log'])
            header('Location: ./index.php');
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FERMI 10 - Chat</title>
        <link href="../CSS/chat.css"  style="text/css" rel="stylesheet"/>
        <link href="../CSS/menu-intestazione-pie.css"  style="text/css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
    </head>

    <script language="javascript">
        var is_block=1;

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

        function showMessages(){
            let nome_destinatario= encodeURIComponent(document.getElementById('destinatario').value);
            let servizio_traduzione= 'deepl';

            if(nome_destinatario.length>0){
                let xhr= new XMLHttpRequest();
                xhr.onreadystatechange= function() {
                    if (this.readyState==4 && this.status==200) {
                        let lista_messaggi = JSON.parse(this.responseText);
                        let stringa_stampare = '<table class="tabellamessaggi">';
                        if(lista_messaggi.length > 0) {
                            let orprec= 0;
                            let contatore=0;
                            let contatoredispari= 1;
                            for(let i = 0; i < lista_messaggi.length; i++) {
                                contatore++;
                                if(lista_messaggi[i].minutimessaggio!=orprec){
                                    stringa_stampare+= `<tr><td colspan="2" class="cellaorario">  <p style="font-size=0.5vw; text-align= center;" class="orario" id="orario">${lista_messaggi[i].orariomessaggio}</p> </td></tr>`;
                                }
                                if(lista_messaggi[i].mittentemessaggio !== document.getElementById("destinatario").value){
                                    stringa_stampare+= `<tr><td class="cellasinistra">&nbsp</td>  <td class="celladestra"><div class="inviatodautenteloggato" id="${contatore}" onclick="translate(this.id)" onmouseover="blockSmoothToBottom(2)" onmouseleave="blockSmoothToBottom(1)">${lista_messaggi[i].contenutomessaggio}</div></td></tr>`;
                                }
                                if(lista_messaggi[i].mittentemessaggio === document.getElementById("destinatario").value){
                                    stringa_stampare+= `<tr><td class="cellasinistra"><div class="inviatodadestinatario" id="${contatore}" onclick="translate(this.id)" onmouseover="blockSmoothToBottom(2)" onmouseleave="blockSmoothToBottom(1)">${lista_messaggi[i].contenutomessaggio}</div></td>  <td class="celladestra">&nbsp</tr></td>`;
                                }   
                                    
                                orprec= lista_messaggi[i].minutimessaggio;
                            }                  
                            if(is_block==1){
                                document.getElementById("spazio_messaggi").innerHTML = stringa_stampare+"</table>";
                                scrollSmoothToBottom("spazio_messaggi");
                            }
                        }
                        else{
                            document.getElementById("spazio_messaggi").innerHTML = '';
                        }
                    }

                };
                xhr.open(
                    "GET",
                    `carica_messaggi.php?destinatario=${nome_destinatario}&serviziotraduzione=${servizio_traduzione}`,
                    true);
                
                xhr.send();
            }
            else{
                document.getElementById("spazio_messaggi").innerHTML = '  ';
                return;
            }
            setTimeout(showMessages, 3000);
        }

        function sendMessage(){
            let nome_destinatario= encodeURIComponent(document.getElementById('destinatario').value);
            let messaggio= document.getElementById('textarea').value;
            if(nome_destinatario.length>0){
                let xhr= new XMLHttpRequest();

                xhr.onreadystatechange= function() {
                    if (this.readyState==4 && this.status==200) {
                            let risposta = this.responseText;
                            document.getElementById("textarea").value = ' ';
                    }

                };
                xhr.open("GET", `invia_messaggio.php?destinatario=${nome_destinatario}&contenutomessaggio=${messaggio}`, true);
                xhr.send();
                showMessages();
            }
        }
        function blockSmoothToBottom(n){
            is_block=n;
        }

        function scrollSmoothToBottom (id) {
            var div = document.getElementById(id);
            $('#spazio_messaggi').animate({
                    scrollTop: div.scrollHeight - div.clientHeight
            }, 150);
        }

        function translate(id){
            let servizio_traduzione= document.getElementById('servizio_traduzione').value;
            let messaggio= document.getElementById(id).innerHTML;
            if(messaggio.length>0){
                let xhr= new XMLHttpRequest();

                xhr.onreadystatechange= function() {
                    if (this.readyState==4 && this.status==200) {
                            document.getElementById(id).innerHTML = this.responseText;
                    }
                };
                xhr.open("GET", `translate.php?messaggio=${messaggio}&servizio_traduzione=${servizio_traduzione}`, true);
                xhr.send();
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
                    <li class="lista" style="background-color: #269e84;" id="Chat" ><a style="color: white;" href="chat.php">Invia Ricevi Chat</a></li>
                    <li class="lista" id="Carte" onmouseover="cambia_sfondo(1, 'Carte');" onmouseleave="cambia_sfondo(2, 'Carte');"><a href="carte.php">Carte</a></li>
                    <li class="lista" id="Investimenti" onmouseover="cambia_sfondo(1, 'Investimenti');" onmouseleave="cambia_sfondo(2, 'Investimenti');"><a href="investimenti.php">Investimenti</a></li>
                    <li class="lista" id="Profilo" onmouseover="cambia_sfondo(1, 'Profilo');" onmouseleave="cambia_sfondo(2, 'Profilo');"><a href="profilo.php">Profilo</a></li>
                </ul>
            </div>
        </div>

        <div class="corpo_principale">
            <div class="blur" id="blur"></div>
            <div class="black" id="black"></div>
            <div class="contenuto" id="contenuto">

                <div class="cella_messaggio">
                        <div class="intestazione">
                            <form>
                                <input type="text" class="destinatario" id="destinatario" onkeyup="showMessages()"/>
                                <select id="servizio_traduzione" class="servizio_traduzione" onchange="showMessages()">
                                    <option name="Bing">Bing</option>
                                    <option name="DeepL">DeepL</option>
                                </select>
                                </form>
                        </div>
                        <div class="spazio_messaggi" id="spazio_messaggi" onmouseover="blockSmoothToBottom(2)" onmouseleave="blockSmoothToBottom(1)"></div>
                        <div class="nuovo_messaggio">
                            <form>
                                <textarea name="textarea" class="spazio_messaggio" id="textarea"></textarea>
                                <img class="pulsante_invia" src="../IMAGES/Immagine1.png" onclick="sendMessage()">
                            </form>
                        </div>
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