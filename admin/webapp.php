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
 		<link rel="stylesheet" href="css/jquery.mobile-1.3.0.css" />
		<script type="text/javascript" src="js/jquery.mobile-1.3.0.min.js"></script>

        <!-- User-generated js -->		

    </head>
	<body>

        <!-- Gestione WebApp -->
		
		<?php

			include("config.php");
		
			include("connessione_db.php"); 
				 
		?>
		
        <section id="home" data-role="page" data-theme="b">
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

				}
				 
				?>
			
                <h1>
                    Gestione My App <? print $user ?>
                </h1>
            </header>
            <div data-role="content" class="content">
				<center>
				<h3>Gestione My App</h3>
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
				<li data-role="divider" data-theme="b">Informazioni My App</li>
					<li>
						Utente: <? print $user ?>. Data Installazione My App <? print $data2 ?>. Scadenza My App tra <? print $giorniresidui ?> giorni.
                    </li>
					 <? if ($giorniresidui < 1) {
						echo "<li data-theme='e'><center><h1>Licenza Scaduta</h1></center></li>"; } ?>
				</ul>
                <ul data-role="listview" data-inset="true" data-theme="c">
					<li>
						Da qui sarai in grado di poter modificare i contenuti della tua My APP. Utilizzando i link in basso potrai editare direttamente tutte le pagine che compongono la tua Applicazione.
                    </li>
				</ul>
                <ul data-role="listview" data-inset="true" data-theme="c">
                    <li data-role="divider" data-theme="b">Gestione Home</li>
					<li>
						Crea o modifica il contenuto della Home della tua Applicazione.
                    </li>
                    <li data-role="divider" data-theme="b">Gestione Galleria</li>
					<li>
						Crea o modifica il contenuto della Galleria Fotografica della tua Applicazione.
                    </li>
                    <li data-role="divider" data-theme="b">Gestione Servizi</li>
					<li>
						Crea o modifica il contenuto della Pagina Servizi della tua Applicazione.
                    </li>
                    <li data-role="divider" data-theme="b">Gestione Contatti</li>
					<li>
						Crea o modifica il contenuto della pagina Contatti della tua Applicazione.
                    </li>
				</ul>
            </div>
			<? print $global ?>
            <footer data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="#" class="ui-btn-active ui-state-persist" data-icon="info">Gestione My App</a></li>
						<li><a href="ghome.php" data-icon="home">Gestione Home</a></li>
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
		<!-- FINE Gestione WebApp -->

	</body>
</html>
