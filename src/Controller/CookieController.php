-<!-- La page CookieController.php (gestion PHP + requêtes SQL) style K&R , indentation Ok -->
<?php
		// Ce code initialise une session unique et empêche d'être appelée plusieurs fois
		if (session_status() === PHP_SESSION_NONE) {
				session_start() ;
			}	

				/* Fichiers à inclure */
				$currentLang = language_nav() ;
				include_once ROOT_PATH . "/lang/$currentLang.php" ;
				include_once ROOT_PATH . "/config/paths.php" ;

				$sql= "/config/sql.php" ;
				include_once ROOT_PATH . $sql ;

		try {
			/* Attention aux erreurs de logique */
	
				
				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */	
				$conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS) ;
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
																					
					// Sécurité contre injections SQL ; on traite comme du texte les données de $tableau
					
					if (isset($_SESSION['id'])) {
							$std = $conn->prepare($deleteCookie);
							$std->execute([':id' => $_SESSION['id']]);
						}

					$sth = $conn->prepare($cookies) ; 

					// On veut l'enregistrer en base de données
											$sth->execute([
												':Client_cookies_id' => $tableau[$labelClientCookiesId],
												':Consent' => $tableau[$labelConsent],
												':Cookie_name' => $tableau[$labelCookieName],
												':Username' => $tableau[$labelUserName],
												':Device' => $tableau[$labelDevice],
												':Platform' => $tableau[$labelPlatform],
												':Browser' => $tableau[$labelBrowser],
												':BrowserVersion' => $tableau[$labelBrowserVersion],
												':Language' => $tableau[$labelLanguage],
												':Timezone' => $tableau[$labelTimezone],
												':Country' => $tableau[$labelCountry],
												':City' => $tableau[$labelCity],
												':Isp' => $tableau[$labelIsp],
												':Latitude' => $tableau[$labelLatitude],
												':Longitude' => $tableau[$labelLongitude],
												':Ip' => $tableau[$labelIp],
												':Events' => json_encode($tableau[$labelEvents]),
												':Visits' => $tableau[$labelVisits],
												':Role' => $tableau[$labelRole],
												':Cookie_date' => $tableau[$labelCookieDate]
											]) ;
					include_once ROOT_PATH . '/src/View/components/cookie_output.php' ;
				}										

				catch (PDOException $e) {					
					/* PDOException : attrape uniquement les erreurs de base de données (ici MySQL) */			
					error_log(ExceptionHandle($e, "$textErrorPDO")) ; // journal de log Apache
					?>
						<script>
							// Exception Cookie (en console)
							console.log(<?= json_encode(ExceptionHandle($e, "$textErrorPDO"), JSON_UNESCAPED_UNICODE) ?>) ;
						</script>
					<?php
				} 
				catch (Exception $e) {
					/* Exception : attrape Exception et ses sous-classes (ici PHP) */
					error_log(ExceptionHandle($e, "$textExceptionPHP")) ; // journal de log Apache
					?>
						<script>
							// Exception Cookie (en console)
							console.log(<?= json_encode(ExceptionHandle($e, "$textExceptionPHP"), JSON_UNESCAPED_UNICODE) ?>) ;
						</script>
					<?php
				} 
				catch (Throwable $e) {
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					error_log(ExceptionHandle($e, "$textFatalError")) ; // journal de log Apache
					?>
						<script>
							// Exception Cookie (en console)
							console.log(<?= json_encode(ExceptionHandle($e, "$textFatalError"), JSON_UNESCAPED_UNICODE) ?>) ;
						</script>
					<?php
				} ?>

				<script>
							console.log("<?= $textDatabaseSuccess ?>") ;
							// Obtenir le Cookie de données encodé Javascript (en console)
                window.cinephoria = <?= json_encode(
                    array_merge($tableau, ['consent' => ($valueCookie === $accept)]),
                    JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                ); ?>;

                // Confirmation en console
                console.log(
                    <?= json_encode(
                        ($valueCookie === $accept) ? (COOKIE_NAME . " : " . $acceptCookieTxt) : (COOKIE_NAME . " : " . $refuseCookieTxt),
                        JSON_UNESCAPED_UNICODE
                    ); ?>,
                    window.cinephoria
                );

                // Recharger pour l'affichage (côté console)
                        if (!sessionStorage.getItem('cookie_reloaded')) {
                            // Flag pour marquer qu'on a déjà fait un reload
                            sessionStorage.setItem('cookie_reloaded', 'true') ;
                            // Pour que le Cookie de window soit pris en compte
                            window.location.reload();
                        } else {
                            // Nettoie le flag pour les futurs choix de Cookie
                            sessionStorage.removeItem('cookie_reloaded') ;
                        }
						</script>