<?php
if (session_status() === PHP_SESSION_NONE) {
			session_start() ;
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
				$sql= "/config/sql.php" ;
				include_once ROOT_PATH . $sql ;
				$ip_path = '/src/View/components/IP.php' ;
				include_once ROOT_PATH . $ip_path ;	
						
		if (!isset($_SESSION['errorLogin'])) {
			$_SESSION['errorLogin'] = false ;
		}

		// Normalise la donnée (supprime les espaces)		
		$email = isset($_POST['email']) ? trim($_POST['email']) : null ;
		// filter_var est une fonction PHP intégrée pour filtrer et valider des données
		$email = filter_var($email, FILTER_VALIDATE_EMAIL) ;
		
				
		if (!$email) {
			// Email invalide : retour à la page login
			$_SESSION['errorLogin'] = true ;
			header("Location: index.php?page=$errorLoginPage") ;
			exit("E-mail invalide") ;
		}		

		// Messages clairs pour la gestion des erreurs/succès
		$errorLoginMember = "[Connexion] L'identifiant ou le mot de passe (ou les deux) ne correspondent pas ! (IP : " . getUserIP() . " ; E-mail : $email)" ;
		$errorLoginFormIncomplete = "[Connexion] Le formulaire est incomplet ! (IP : " . getUserIP()  . " ; E-mail : $email)" ;	
				
		try {
			/* Attention aux erreurs de logique */

				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */	
				$conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS) ;
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
						
				/* Le contexte vérifie des données d’un formulaire via l'existence de $_POST[] */
				if (isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){									
					$password = isset($_POST['password']) ? trim($_POST['password']) : null ;

					// Sécurité contre injections SQL ; on traite comme du texte les données de $_POST[]
					$sth = $conn->prepare($login) ; 
					// On veut la correspondance identifiant et mot de passe		
					$sth->execute([':email' => $email]) ; // PDO gère les quotes automatiquement (simples et doubles)
					
					$resultat = $sth->fetch(PDO::FETCH_ASSOC) ; // Sécurité ici pas de fetchAll

					/* cas avec succès */
										
					// on vérifie la combinaison mot de passe avec password_hash()
					if (isset($resultat['Id']) && password_verify($password, $resultat['Password'])){
						// Session enregistre les données 
						$_SESSION['user'] = $resultat['Username'] ?? '' ;						
						$_SESSION['id'] = $resultat['Id'] ;
						
						switch ((int)$resultat['Role_Id']) {
								case 1:
									$_SESSION['role'] = 'Client';
									break;
								case 2:
									$_SESSION['role'] = 'Employe';
									break;
								case 3:
									$_SESSION['role'] = 'Admin';
									break;
								default:
									$_SESSION['role'] = 'Visitor';
							}						
						
						// Succès !												
						header("Location: index.php?page=$successLoginPage") ;
						exit("Next page") ;
					} 
					
					/* Si les données n'existent pas dans la base de données */					
					else {
						// Affiche le message dans le journal de log Apache						
						error_log($errorLoginMember) ;
						$_SESSION['errorLogin'] = true ;   																
						header("Location: index.php?page=$errorLoginPage") ;
						exit("Wrong ID or Password (or both)") ;
					}
				}
		}

				catch (PDOException $e) {	
					/* PDOException : attrape uniquement les erreurs de base de données (ici MySQL) */			
					ExceptionHandle($e, "Error PDO") ;
				} catch (Exception $e) {
					/* Exception : attrape Exception et ses sous-classes (ici PHP) */
					ExceptionHandle($e, "Exception PHP") ;
				} catch (Throwable $e) {
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					ExceptionHandle($e, "Fatal Error") ;
				}
