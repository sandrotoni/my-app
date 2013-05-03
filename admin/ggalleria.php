<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
        <meta name="apple-mobile-web-app-capable" content="yes" /> 
        <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
        <title>
		Gestione My App
        </title>
		
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script src="js/jquery-migrate-1.1.1.min.js"></script>
 		<link rel="stylesheet" href="css/jquery.mobile-1.3.0.css" />
		<script type="text/javascript" src="js/jquery.mobile-1.3.0.min.js"></script>

        <!-- User-generated js -->

		<style>
			#utente_attivo {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background-color: #FFFFFF;
				opacity:0.95;
				filter:alpha(opacity=95); /* For IE8 and earlier */
				z-index: 9999; /* o cmq il numero più alto tra quelli degli altri z-index presenti */
			}
		</style>
		
    </head>
	<body>
        <!-- Gestione Galleria -->
		
		<?php

			include("config.php");
		
			include("connessione_db.php"); 
			
		?>
		
        <section id="ggalleria" data-role="page" data-theme="b">
            <header data-role="header">
			
				<?php
				$table_user = "utenti";
				
				mysql_connect($host,$db_user,$db_psw) or die("Impossibile collegarsi al server");
				@mysql_select_db("$db_name") or die("Impossibile connettersi al database $db_name");
				
				$sqlquery = "SELECT * FROM $table_user WHERE id = $utente";
				$result = mysql_query($sqlquery);
				$number = mysql_numrows($result);
				
				$i = 0;
				
				if ($number < 1) {

				print "<center><p>La ricerca non ha prodotto nessun risultato</p></center>";
				}

				else {

				while ($number > $i) {

				$user = mysql_result($result,$i,"utente");
				$attivo = mysql_result($result,$i,"attivo");
				$data_inizio = mysql_result($result,$i,"data_inizio");

				$data1 = date('Y-m-d');
				$data2 = $data_inizio;
			
					$a_1 = explode('-',$data1);
					$a_2 = explode('-',$data2);
					$mktime1 = mktime(0, 0, 0, $a_1[1], $a_1[2], $a_1[0]);
					$mktime2 = mktime(0, 0, 0, $a_2[1], $a_2[2], $a_2[0]);
					$secondi = $mktime1 - $mktime2;
					$giorni = intval($secondi / 86400); /*ovvero (24ore*60minuti*60seconi)*/
					$giorniresidui = (365 - $giorni);
				
				$i++;
				}

				if ($giorniresidui < 1) {

					$attivo = 0;

				}
				
				}
				 
				?>
			
                <h1>
                    Gestione My App  <? print $user ?>
                </h1>
            </header>
            <div data-role="content" class="content">
				<center>
				<h3>Gestione Galleria</h3>
				</center>
				<?php
				if ($giorniresidui < '31') {
				echo "
                <ul data-role='listview' data-inset='true' data-theme='e'>
					<li>
						La tua licenza scade tra $giorniresidui giorni.
                    </li>
				</ul>";
				}
				?>
                <ul data-role="listview" data-inset="true" data-theme="c">
					<li>
						Crea o modifica il contenuto della Galleria della tua Applicazione.
                    </li>
					<li>
						<i>Da questa pagina e' possibile caricare le immagini che faranno parte della Galleria.<br/>Prima di effettuare il caricamento assicurarsi che:<br/>
						1. ogni file sia in formato e con estensione jpg (minuscolo),<br/>
						2. la dimensione del file sia inferiore a 1048576 byte (1 Mb circa),<br/>
						3. le dimensioni (larghezza x altezza) dell'immagine abbiano un rapporto di 4x3 (es. 400x300 oppure 800x600 oppure 200x150) per avere una corretta visualizzazione,<br/>
						4. i file siano stati salvati con i seguenti nomi (1.jpg, 2.jpg, 3.jpg, 4,jpg, 5.jpg).<br/><br/>
						</i>IMPORTANTE: <i>I file caricati sovrascriveranno automaticamente quelli gia' presenti sul server, quindi prestare molta attenzione in quanto i precedenti non saranno recuperabili.<br/>
						Una volta che i file soddisfano i requisiti richiesti in precedenza si puo' procedere al caricamento.<br/><br/>
						</i>Caricamento: <i>Cliccare su "Upload Immagini" e poi sul tasto "Sfoglia", quindi selezionare il file o i files (massimo 5) da caricare.</i>
                    </li>
				</ul>

				<? echo "<div STYLE='position:relative;'>"; ?>
				
				<div data-role="collapsible" data-theme="e" data-content-theme="d" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u">
					<h4>Upload Immagini</h4>
					<ul data-role="listview" data-inset="false">
						<li>
							<input type="file" name="fileUpload2" id="fileUpload2" class="fileUpload" multiple="multiple" />

							<div id="response"></div>
							<div id="details"></div>

							<script type="text/javascript" src="js/jquery.liteuploader.min.js"></script>
							<script type="text/javascript">

								$(document).ready(function ()
								{
									$('.fileUpload').liteUploader(
									{
										script: 'upload.php',
										allowedFileTypes: 'image/jpeg',
										maxSizeInBytes: 1048576,
										typeMessage: '<br/>Tipo di file non corretto (image/jpeg) o dimensioni superiori al massimo consentito (1048576 byte). Controllare e riprovare.',
										before: function ()
										{
											$('#details').html('');
											$('#response').html('Caricamento...');
										},
										each: function (file, errors)
										{
											var i, errorsDisp = '';

											if (errors.length > 0)
											{
												$('#response').html('***** Uno o piu\'\ file non sono corretti *****');

												for (i = 0; i < errors.length; i++)
												{
													errorsDisp += '<br />' + errors[i].message;
												}
											}

											$('#details').append('<p><b>Nome:</b> ' + file.name + ' - <b>Tipo:</b> ' + file.type + ' - <b>Dimensioni:</b> ' + file.size + ' byte' + errorsDisp + '</p>');
										},
										success: function (response)
										{
											$('#response').html(response);
										}
									});
								});

							</script>
						</li>
					</ul>
				</div>
				
				<? if ($attivo < 1) 
				{
				echo "<div id='utente_attivo'><center><h1>UTENTE NON ATTIVO</h1></center></div>";
				} ?>
				<? echo "</div>"; ?>
				
			</div>
            <footer data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="webapp.php" data-icon="info">Gestione My App</a></li>
						<li><a href="ghome.php" data-icon="home">Gestione Home</a></li>
						<li><a href="gservizi.php" data-icon="check">Gestione Servizi</a></li>
						<li><a href="#" class="ui-btn-active ui-state-persist" data-icon="grid">Gestione Galleria</a></li>
						<li><a href="gcontatti.php" data-icon="star">Gestione Contatti</a></li>
					</ul>
				</div><!-- /navbar -->
                <h2>
                    Etronic.org &copy 2013
                </h2>
            </footer>
        </section>
		<!-- FINE Gestione Galleria -->

	</body>
</html>
