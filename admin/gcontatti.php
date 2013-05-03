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
        <!-- Gestione Contatti -->
		
		<?php

			include("config.php");
		
			include("connessione_db.php"); 
			
		?>
		
        <section id="gcontatti" data-role="page" data-theme="b">
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
				$usermail = mysql_result($result,$i,"mail");
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
				<h3>Gestione Contatti</h3>
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
						Crea o modifica il contenuto della Pagina dei Contatti della tua Applicazione.<br/>
						Una volta inseriti i valori cliccare sul pulsante "Invia" che si trova a fondo pagina.
                    </li>
				</ul>

				<?php
						$table_contatti = "contatti";
						
						mysql_connect($host,$db_user,$db_psw) or die("Impossibile collegarsi al server");
						@mysql_select_db("$db_name") or die("Impossibile connettersi al database $db_name");
						
						$sqlquery = "SELECT * FROM $table_contatti WHERE utente = $utente";
						$result = mysql_query($sqlquery);
						$contatore = mysql_numrows($result);
				?>
				<?php if (isset($_POST['indirizzo'])) : 
				 
				mysql_select_db("$db_name",$connessione); 
				 

					$indirizzo = mysql_real_escape_string($_POST['indirizzo']);
					$telefono = mysql_real_escape_string($_POST['telefono']);
					$cellulare = mysql_real_escape_string($_POST['cellulare']);
					$sitoweb = mysql_real_escape_string($_POST['sitoweb']);
					$paginafb = mysql_real_escape_string($_POST['paginafb']);
					$paginatw = mysql_real_escape_string($_POST['paginatw']);
					$paginagplus = mysql_real_escape_string($_POST['paginagplus']);

					if ($contatore < 1) {
					
						$sql = "INSERT INTO contatti (utente, indirizzo, telefono, cellulare, sitoweb, paginafb, paginatw, paginagplus)
						
						VALUES ('$userid','$indirizzo','$telefono','$cellulare','$sitoweb','$paginafb','$paginatw','$paginagplus')
						";
						
						}
						
						else {
						
						$sql = "UPDATE contatti SET
				 
						indirizzo = '$indirizzo',
						telefono = '$telefono',
						cellulare = '$cellulare',
						sitoweb = '$sitoweb',
						paginafb = '$paginafb',
						paginatw = '$paginatw',
						paginagplus = '$paginagplus'
						
						WHERE id = $userid
						";
						
						}
				 
					if (@mysql_query($sql)) 
				 
					    {
				 
					    echo '<p><center><h1>Pagina dei Contatti modificata con successo</h1></center></p>';
				 
					    }
				 
					    else {
				 
						echo 'errore '. mysql_error().' ';
				 
						    }
				 ?>
				<?php else: ?>
				<center>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

					<?php
						$table_contatti = "contatti";
						
						mysql_connect($host,$db_user,$db_psw) or die("Impossibile collegarsi al server");
						@mysql_select_db("$db_name") or die("Impossibile connettersi al database $db_name");
						
						$sqlquery = "SELECT * FROM $table_contatti WHERE utente = $utente";
						$result = mysql_query($sqlquery);
						$contatore = mysql_numrows($result);
						
						$i = 0;
						
						if ($contatore < 1) {

						print "Non hai ancora inserito nessuna Pagina dei Contatti.";
						}

						else {

						while ($contatore > $i) {

						$indirizzo = mysql_result($result,$i,"indirizzo");
						$telefono = mysql_result($result,$i,"telefono");
						$cellulare = mysql_result($result,$i,"cellulare");
						$sitoweb = mysql_result($result,$i,"sitoweb");
						$paginafb = mysql_result($result,$i,"paginafb");
						$paginatw = mysql_result($result,$i,"paginatw");
						$paginagplus = mysql_result($result,$i,"paginagplus");
						
						$i++;
						}

						}
					?>
					<? echo "<div STYLE='position:relative;'>"; ?>
					<ul data-role="listview" data-inset="true" data-theme="c">
						<li>
							ID Utente : <? print $userid ?><br/>
						</li>
						<li>
							None utente : <? print $user ?><br/>
						</li>
						<li>
							Indirizzo e-mail : <? print $usermail ?><br/>
						</li>
						<li>
							Inserisci il tuo indirizzo completo ( es. Piazza Mazzini, 15 73100 Lecce (LE) )
							<input type="text" name="indirizzo" id="indirizzo"  placeholder="Inserisci il tuo indirizzo completo" value="<? print $indirizzo ?>"/>
						</li>
						<li>
							Inserisci il tuo telefono ( es. 0832 123456 )
							<input type="text" name="telefono" id="telefono"  placeholder="Inserisci il tuo telefono" value="<? print $telefono ?>"/>
						</li>
						<li>
							Inserisci il tuo cellulare ( es. +39 123 4567890 )
							<input type="text" name="cellulare" id="cellulare"  placeholder="Inserisci il tuo cellulare" value="<? print $cellulare ?>"/>
						</li>
						<li>
							Inserisci il tuo sitoweb ( es. http://www.etronic.org )
							<input type="text" name="sitoweb" id="sitoweb"  placeholder="Inserisci il tuo sitoweb" value="<? print $sitoweb ?>"/>
						</li>
						<li>
							Inserisci il tuo indirizzo Facebook ( es. Se la pagina e' https://www.facebook.com/Etronic.org va inserito Etronic.org)
							<input type="text" name="paginafb" id="paginafb"  placeholder="Inserisci il tuo indirizzo Facebook" value="<? print $paginafb ?>"/>
						</li>
						<li>
							Inserisci il tuo indirizzo Twitter ( es. Se la pagina e' https://twitter.com/etronic_org va inserito etronic_org)
							<input type="text" name="paginatw" id="paginatw"  placeholder="Inserisci il tuo indirizzo Twitter" value="<? print $paginatw ?>"/>
						</li>
						<li>
							Inserisci il tuo indirizzo Google+ ( es. Se la pagina e' https://plus.google.com/123456789012345/posts va inserito 123456789012345)
							<input type="text" name="paginagplus" id="paginagplus"  placeholder="Inserisci il tuo indirizzo Google+" value="<? print $paginagplus ?>"/>
						</li>
					</ul>
					<input type="submit" data-theme="e" value="Invia">
					<? if ($attivo < 1) 
					{
					echo "<div id='utente_attivo'><center><h1>UTENTE NON ATTIVO</h1></center></div>";
					} ?>
				<? echo "</div>"; ?>
				
				</form>
				</center>
				<?php  endif; ?>
				
            </div>
            <footer data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="webapp.php" data-icon="info">Gestione My App</a></li>
						<li><a href="ghome.php" data-icon="home">Gestione Home</a></li>
						<li><a href="gservizi.php" data-icon="check">Gestione Servizi</a></li>
						<li><a href="ggalleria.php" data-icon="grid">Gestione Galleria</a></li>
						<li><a href="#" class="ui-btn-active ui-state-persist" data-icon="star">Gestione Contatti</a></li>
					</ul>
				</div><!-- /navbar -->
                <h2>
                    Etronic.org &copy 2013
                </h2>
            </footer>
        </section>
		<!-- FINE Gestione Contatti -->

	</body>
</html>
