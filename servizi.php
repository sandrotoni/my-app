<!DOCTYPE html>
		<?php

			include("admin/config.php");
		
			include("admin/connessione_db.php"); 			

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

					mysql_select_db("$db_name",$connessione);
					
					$attivo = 0;

					$sql = "UPDATE utenti SET
					
					attivo = '$attivo'
					
					WHERE id = $user
					";
				}
		
		}
		 
		?>

		
		
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
        <meta name="apple-mobile-web-app-capable" content="yes" /> 
        <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
        <title>
		My App <? print $user ;?> -Servizi-
        </title>
		
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
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
		<!-- Servizi -->
		
        <section id="servizi" data-role="page" data-theme="b">
            <header data-role="header">
			
                <h1>
                    My App <?php if ($number >= 1) { print $user ; } else { print "*** Utente non inserito nel Database ***"; } ?> -Servizi-
                </h1>
            </header>
            <div data-role="content" class="content">
			
				<?php
				$table = "servizi";
				
				mysql_connect($host,$db_user,$db_psw) or die("Impossibile collegarsi al server");
				@mysql_select_db("$db_name") or die("Impossibile connettersi al database $db_name");
				
				$sqlquery = "SELECT * FROM $table WHERE utente = $utente";
				$result = mysql_query($sqlquery);
				$number = mysql_numrows($result);
				
				$i = 0;
				
				if ($number < 1) {

				print "<center><p>Non hai ancora inserito nessuna Pagina dei Servizi</p></center>";
				}

				else {

				while ($number > $i) {

				$servizi = mysql_result($result,$i,"servizi");
				echo "<DIV STYLE='position:relative;padding-top:10px;padding-left:10px;padding-right:10px;'> $servizi ";
					if ($attivo < 1) 
					{
					echo "<div id='utente_attivo'><center><h1>UTENTE NON ATTIVO</h1></center></div>";
					}
					
				echo "</div>";
				$i++;
				}

				}
				 
				?>

            </div>
            <footer data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="index.php" data-icon="home">Home</a></li>
						<li><a href="#" class="ui-btn-active ui-state-persist" data-icon="check">Servizi</a></li>
						<li><a href="galleria.php" data-icon="grid">Galleria</a></li>
						<li><a href="contatti.php" data-icon="star">Contatti</a></li>
					</ul>
				</div><!-- /navbar -->
                <h2>
                    <a href="http://www.etronic.org" target="_blank">Etronic.org &copy 2013</a>
                </h2>
            </footer>
        </section>
		<!-- FINE Servizi -->

	</body>
</html>
