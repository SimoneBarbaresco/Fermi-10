<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FERMI 10 - Panoramica</title>
        <link href="../CSS/panoramica.css"  style="text/css" rel="stylesheet"/>
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
    <!--regregv -->
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
                    <li class="lista" style="background-color: #269e84;" id="Panoramica" ><a style="color: white;" href="panoramica.php">Panoramica</a></li>
                    <li class="lista" id="Chat" onmouseover="cambia_sfondo(1, 'Chat');" onmouseleave="cambia_sfondo(2, 'Chat');"><a href="chat.php">Invia Ricevi Chat</a></li>
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

<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript">
	AmCharts.makeChart("grafico_riepilogo",
		{
			"type": "pie",
			"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
			"innerRadius": "40%",
			"colors": [
				"#2980b9",
				"#c0392b",
				"#f39c12"
			],
			"outlineThickness": 0,
			"pullOutEffect": "elastic",
			"startEffect": "easeOutSine",
			"titleField": "category",
			"valueField": "column-1",
			"color": "#FFFFFF",
			"decimalSeparator": ",",
			"fontFamily": "Open Sans",
			"fontSize": 16,
			"handDrawScatter": 1,
			"percentPrecision": 1,
			"theme": "default",
			"thousandsSeparator": ".",
			"allLabels": [],
			"balloon": {},
			"legend": {
				"enabled": true,
				"align": "center",
				"color": "#FFFFFF",
				"fontSize": 12,
				"markerType": "circle",
				"tabIndex": -6
			},
			"titles": [],
			"dataProvider": [
				{
					"category": "Entrate",
					"column-1": "100000"
				},
				{
					"category": "Uscite",
					"column-1": "89000"
				},
				{
					"category": "In Conto",
					"column-1": "10000"
				}
			]
		}
	);

	AmCharts.makeChart("chartdiv",
				{
					"type": "serial",
					"categoryField": "date",
					"dataDateFormat": "YYYY-MM",
					"colors": [
						"#2980b9",
						"#c0392b",
						"#27ae60"
					],
					"color": "#FFFFFF",
					"decimalSeparator": ",",
					"fontSize": 12,
					"theme": "default",
					"thousandsSeparator": ".",
					"categoryAxis": {
						"minPeriod": "MM",
						"parseDates": true
					},
					"chartCursor": {
						"enabled": true,
						"categoryBalloonDateFormat": "MMM YYYY"
					},
					"trendLines": [],
					"graphs": [
						{
							"fixedColumnWidth": -11,
							"id": "Entrate",
							"lineThickness": 2,
							"title": "Entrate",
							"valueField": "Entrate"
						},
						{
							"fixedColumnWidth": -3,
							"id": "Uscite",
							"lineThickness": 2,
							"title": "Uscite",
							"valueField": "Uscite"
						},
						{
							"columnWidth": 0.01,
							"fontSize": -9,
							"id": "In Conto",
							"lineThickness": 2,
							"title": "In Conto",
							"valueField": "In Conto"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": ""
						}
					],
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"tabIndex": -9,
						"useGraphSettings": true
					},
					"titles": [
						{
							"id": "Storico",
							"size": 15,
							"text": ""
						}
					],
					"dataProvider": [
						{
							"date": "2017-04",
							"Entrate": "103000",
							"Uscite": "130000",
							"In Conto": "15000"
						},
						{
							"date": "2017-05",
							"Entrate": "156000",
							"Uscite": "110500",
							"In Conto": "17000"
						},
						{
							"date": "2017-06",
							"Entrate": "90104",
							"Uscite": "90000",
							"In Conto": "17500"
						},
						{
							"date": "2017-07",
							"Entrate": "128903",
							"Uscite": "45000",
							"In Conto": "19000"
						},
						{
							"date": "2017-08",
							"Entrate": "129500",
							"Uscite": "45000",
							"In Conto": "19500"
						},
						{
							"date": "2017-09",
							"Entrate": "140560",
							"Uscite": "50000",
							"In Conto": "19000"
						},
						{
							"date": "2017-10",
							"Entrate": "167000",
							"Uscite": "190000",
							"In Conto": "5000"
						},
						{
							"date": "2017-11",
							"Entrate": "159050",
							"Uscite": "180000",
							"In Conto": "8000"
						},
						{
							"date": "2017-12",
							"Entrate": "170000",
							"Uscite": "190000",
							"In Conto": "11000"
						},
						{
							"date": "2018-01",
							"Entrate": "120000",
							"Uscite": "200000",
							"In Conto": "14000"
						},
						{
							"date": "2018-02",
							"Entrate": "90000",
							"Uscite": "39900",
							"In Conto": "17000"
						},
						{
							"date": "2018-03",
							"Entrate": "100000",
							"Uscite": "89000",
							"In Conto": "10000"
						}
					]
				}
			);
</script>
