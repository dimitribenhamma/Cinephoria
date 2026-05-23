<!-- Le fichier d'Exceptions personnalisées, mode dynamique PHP-->
<?php
		

		// Il faudrait des logs (en console)
        function ExceptionHandle(Throwable $e, $pageMessage) {		

			/* Journalisation (Logging) */

							$catchPage = $_GET['page'] ?? 'home' ;
							// Marque une exception qui est levée
							error_log("[$pageMessage] Erreur Serveur") ;
							error_log("[$pageMessage] " .$e->getMessage()." dans ".$e->getFile()." , ligne ".$e->getLine()) ;

							// Si les en-têtes http sont déjà envoyés
							if (headers_sent($file, $line)) {
									error_log("[HEADERS ERROR] En-têtes déjà envoyés dans $file à la ligne $line") ;
									exit ("Erreur Header") ;
								}

							// Redirection PHP (si les en-têtes http ne sont pas déjà envoyés)
								error_log("[$pageMessage] Rediraction vers 'catchPage' $catchPage") ;
								error_log("[$pageMessage] Fin Erreur Serveur") ;
								header("Location: index.php?page=$catchPage") ;
								exit ("Fin Erreur Serveur") ;

					}

?>