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
	
		<script src="ckeditor/ckeditor.js"></script>

    </head>
	<body>
        <!-- Gestione Home -->
		
		<?php

			include("config.php");
		
			include("connessione_db.php"); 
			
		?>
		
        <section id="ghome" data-role="page" data-theme="b">
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
				$userid = mysql_result($result,$i,"id");
				$attivo = mysql_result($result,$i,"attivo");
				$data_inizio = mysql_result($result,$i,"data_inizio");

				$i++;
				}
				
				$data1 = date('Y-m-d');
				$data2 = $data_inizio;
			
					$a_1 = explode('-',$data1);
					$a_2 = explode('-',$data2);
					$mktime1 = mktime(0, 0, 0, $a_1[1], $a_1[2], $a_1[0]);
					$mktime2 = mktime(0, 0, 0, $a_2[1], $a_2[2], $a_2[0]);
					$secondi = $mktime1 - $mktime2;
					$giorni = intval($secondi / 86400); /*ovvero (24ore*60minuti*60seconi)*/
					$giorniresidui = (365 - $giorni);

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
				<h3>Gestione Home</h3>
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
						Crea o modifica il contenuto della Pagina Home della tua Applicazione.
                    </li>
				</ul>
				<?php
						$table_contatti = "homepage";
						
						mysql_connect($host,$db_user,$db_psw) or die("Impossibile collegarsi al server");
						@mysql_select_db("$db_name") or die("Impossibile connettersi al database $db_name");
						
						$sqlquery = "SELECT * FROM $table_contatti WHERE utente = $utente";
						$result = mysql_query($sqlquery);
						$contatore = mysql_numrows($result);
				?>
				<?php if (isset($_POST['homepagebox'])) : 
				 
				mysql_select_db("$db_name",$connessione); 
				 

					$homepagebox = $_POST['homepagebox'];

					if ($contatore < 1) {
					
						$sql = "INSERT INTO homepage (utente, home)
						
						VALUES ('$userid','$homepagebox')
						";
						
						}
						
						else {

						$sql = "UPDATE homepage SET
				 
						home = '$homepagebox'
						WHERE utente = $userid
						";
						
						}
				 
					if (@mysql_query($sql)) 
				 
					    {
				 
					    echo '<p><center><h1>Pagina Home modificata con successo</h1></center></p>';
				 
					    }
				 
					    else {
				 
						echo 'errore '. mysql_error().' ';
				 
						    }
				 ?>
				<?php else: ?>
				<center>
				
				<? echo "<div STYLE='position:relative;'>"; ?>
				
				<a href="#"id="PageHomeRefresh"  data-role="button" data-icon="gear" data-theme="b">***IMPORTANTE*** Carica l'editor della Pagina Home</a>
					<script type="text/javascript">
						$('#PageHomeRefresh').click(function() {
								  location.reload();
						});
					</script>

					<div data-role="collapsible" data-theme="e" data-content-theme="d" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u">
						<h4>Clicca per caricare un'immagine sul server da inserire nella pagina (formato consentito jpg, dimensioni max 1Mb)</h4>
						<ul data-role="listview" data-inset="false">
							<li>
							
								<?php
									$conflen=strlen('admin');
									$BBB=substr(__FILE__,0,strrpos(__FILE__,'/'));
									$AAA=substr($_SERVER['DOCUMENT_ROOT'], strrpos($_SERVER['DOCUMENT_ROOT'], $_SERVER['PHP_SELF']));
									$CCC=substr($BBB,strlen($AAA));
									$posconf=strlen($CCC)-$conflen-1;
									$DDD=substr($CCC,0,$posconf);
									$hostimage='http://'.$_SERVER['SERVER_NAME'].'/'.$DDD.'/img/';
								?>
							
								<input type="file" name="fileUpload1" id="fileUpload1" class="fileUpload" multiple="multiple" />

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

												$('#details').append('<p><b>Copia e Incolla il testo sottostante per inserire questa immagine nella pagina cliccando sul tasto Immagine:</b><br/> <? print $hostimage; ?>' + file.name + '</p>');
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

				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<label><em>Inserire qui il contenuto della Homepage. Una volta terminato cliccare sul pulsante "SALVA" per salvare i cambiamenti.</em></label>
					<textarea class="ckeditor" name="homepagebox" id="homepagebox" style="width:100%">
					<?php
						$table = "homepage";
						
						mysql_connect($host,$db_user,$db_psw) or die("Impossibile collegarsi al server");
						@mysql_select_db("$db_name") or die("Impossibile connettersi al database $db_name");
						
						$sqlquery = "SELECT * FROM $table WHERE utente = $utente";
						$result = mysql_query($sqlquery);
						$number = mysql_numrows($result);
						
						$i = 0;
						
						if ($number < 1) {

						print "Non hai ancora inserito nessuna Homepage.";
						}

						else {

						while ($number > $i) {

						$homepage = mysql_result($result,$i,"home");
						print $homepage;
						$i++;
						}

						}
					?>
					</textarea>
					
					<input type="submit" data-theme="e" value="Salva">
				</form>
				
				<? if ($attivo < 1) 
				{
				echo "<div id='utente_attivo'><center><h1>UTENTE NON ATTIVO</h1></center></div>";
				} ?>
				<? echo "</div>"; ?>
				
				</center>
				<?php  endif; ?>

            </div>
            <footer data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="webapp.php" data-icon="info">Gestione My App</a></li>
						<li><a href="#" class="ui-btn-active ui-state-persist" data-icon="home">Gestione Home</a></li>
						<li><a href="gservizi.php" data-icon="check">Gestione Servizi</a></li>
						<li><a href="ggalleria.php" data-icon="grid">Gestione Galleria</a></li>
						<li><a href="gcontatti.php" data-icon="star">Gestione Contatti</a></li>
					</ul>
				</div><!-- /navbar -->
                <h2>
                    Etronic.org &copy 2013
                </h2>
            </footer>
        </section>
		<!-- FINE Gestione Home -->

	</body>
</html>
