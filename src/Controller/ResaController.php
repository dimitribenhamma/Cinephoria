<!-- ResaController.php : style K&R , indentation Ok -->
<?php 
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if (!isset($_SESSION['role'])) {
			$_SESSION['role'] = 'Client';
		}
		if (!isset($_SESSION['id'])) {
			header("Location: index.php?page=login");
			exit;
		}
		
		/* Fichiers à inclure */
					include_once ROOT_PATH . "/src/View/components/IP.php" ;
					$currentLang = language_nav() ;
					include_once ROOT_PATH . "/lang/$currentLang.php" ;
					$appName = 'app' ;
					$app_path = "/config/$appName.php" ;
					include_once ROOT_PATH . $app_path ;
					$paths_path = "/config/paths.php" ;
					include_once ROOT_PATH . $paths_path ;
					include_once ROOT_PATH . $exceptionHandle_path;
					include_once ROOT_PATH . $sql_path;
		
		// Normalise la donnée (supprime les espaces)
			$creditCard = trim($_POST['creditCard'] ?? '');
			$cryptogram = trim($_POST['cryptogram'] ?? '');
			$nameCard   = trim($_POST['nameCard'] ?? '');			
		
	
		$errorReservePage = 'payment';

		// Messages clairs pour la gestion des erreurs/succès		
		$formIncomplete = "[Paiement] Le formulaire est incomplet ! (IP : " . getUserIP() . ")";
		$emailError     = "[Erreur Fatale] L'E-mail n'existe pas (IP : " . getUserIP() . ")";			


		try {	

			/* Attention aux erreurs de logique */
			

					/* Le contexte vérifie des données d’un formulaire */
					if ($creditCard !== '' && $cryptogram !== '' && $nameCard !== '') {
				
						/* Vérifie les informations avec la banque */																			
								// ...
								// SYSTEMPAY
								// ...
						/* Fin des vérifications avec la banque */			
										$pdo = new PDO(
											"mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
											$_ENV['DB_USER'],
											$_ENV['DB_PASS'],
											[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
										);										

										$stmt = $pdo->prepare($Resa);
										$stmt->execute([
											':client_id' => $_SESSION['id'],
											':movie_id' => $_SESSION['movie_id'],
											':seats' => $_SESSION['selected_seats'],
											':sum' => $_SESSION['sum'],
											':horaire' => $_SESSION['horaire'],
											':date_reservation' => date_fr()
										]);

										// Succès !
										header("Location: index.php?page=$confirmReservePage");
										exit("Vous êtes redirigés vers la page de confirmation");										
									}															
							else 
								{						    									
									error_log($formIncomplete);
									if(isset($emailError)){
										error_log($emailError);
									}
									$_SESSION['errorReservation'] = true;
									header("Location: index.php?page=$errorReservePage");
									exit("Le formulaire est incomplet !");
								} 	
				}	

				  catch (Exception $e) {
					/* Exception : attrape Exception et ses sous-classes (ici PHP) */
					ExceptionHandle($e, "Exception PHP");
				}	
				  catch (PDOException $e) {
					ExceptionHandle($e, "Erreur SQL");
				}	
				 catch (Throwable $e) {
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					ExceptionHandle($e, "Erreur Fatale");
				}

?>