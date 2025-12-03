<!-- LoginController.php (gestion PHP + requêtes SQL) style K&R , indentation Ok -->
<?php
		// en-tête HTTP
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}	
		
		if (!isset($_SESSION['errorLogin'])) {
			$_SESSION['errorLogin'] = false;
		}

		// Fichiers "include"
		$ip_path = '/src/View/components/IP.php';
		include_once ROOT_PATH . $ip_path;	

		// Normalise la donnée (supprime les espaces)		
		$email = isset($_POST['email']) ? trim($_POST['email']) : null;
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		// Assignation en chaîne
		$errorLoginPage = $catchPage = "login" ;

		if (!$email) {
			// Email invalide : retour à la page login
			$_SESSION['error'] = "E-mail invalide";
			header("Location: index.php?page=login");
			exit("E-mail invalide");
		}		

		// Messages clairs pour la gestion des erreurs/succès
		$errorLoginMember = "[Connexion] L'identifiant ou le mot de passe (ou les deux) ne correspondent pas ! (IP : " . getUserIP() . " ; e-mail : $email)";
		$errorLoginFormIncomplete = "[Connexion] Le formulaire est incomplet ! (IP : " . getUserIP()  . " ; e-mail : $email)" ;	
				
		try {		 
			/* Attention aux erreurs de logique */

				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */	
				$conn = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
				/* Le contexte vérifie des données d’un formulaire via l'existence de $_POST[] */
				if (isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){									
					$password = isset($_POST['password']) ? trim($_POST['password']) : null;								

					// Sécurité contre injections SQL ; on traite comme du texte les données de $_POST[]
					$sth = $conn->prepare($sql); 
					// On veut la correspondance identifiant et mot de passe		
					$sth->execute([':email' => $email]);
					
					$resultat = $sth->fetch(PDO::FETCH_ASSOC);

					/* cas avec succès */
										
					// on vérifie la combinaison mot de passe avec password_hash()
					if (isset($resultat['id']) && password_verify($password, $resultat['password'])){	
						// Session enregistre les données 
						$_SESSION['user'] = $resultat['user'] ?? '';						
						$_SESSION['id'] = $resultat['id'];
						$_SESSION['role'] = $resultat['role'] ?? 'client';
						unset($_SESSION['errorLogin']);
						
						// Succès !
						header("Location: index.php?page=$successPage");
						exit("Vous êtes redirigés vers la page suivante");
					} 
					
					/* Si les données n'existent pas dans la base de données */					
					else {
						// Affiche le message dans le journal de log Apache						
						error_log($errorLoginMember);
						$_SESSION['errorLogin'] = true;   																
						header("Location: index.php?page=$errorLoginPage");
						exit("L'identifiant ou le mot de passe (ou les deux) ne correspondent pas");
					}
				}
		}

		catch (PDOException $e) {	
					/* PDOException : attrape uniquement les erreurs de base de données (ici MySQL) */			
					ExceptionHandle($e, "Erreur PDO");
				} catch (Exception $e) {
					/* Exception : attrape Exception et ses sous-classes (ici PHP) */
					ExceptionHandle($e, "Exception PHP");
				} catch (Throwable $e) {
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					ExceptionHandle($e, "Erreur Fatale");
				}