<?php

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

		if (!isset($_SESSION['role'])) {
			$_SESSION['role'] = 'Client';
		}	
		
		if (!isset($_SESSION['errorRegistration'])) {
		$_SESSION['errorRegistration'] = false;
		}	


		include_once ROOT_PATH . $exceptionHandle_path;
		
		// Normalise la donnée du formulaire de $_POST[] (supprime les espaces)	
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$surname = isset($_POST['surname']) ? trim($_POST['surname']) : null;
		$user = isset($_POST['user']) ? trim($_POST['user']) : null;
		$email = isset($_POST['email']) ? trim($_POST['email']) : null;
		$password = isset($_POST['password']) ? trim($_POST['password']) : null;
		
	
		// Assignation en chaîne
		$errorMemberPage = $errorFormPage = $catchPage = "registration";
		
		// Messages clairs pour la gestion des erreurs/succès
		$registrationMember = "[Inscription] L'Ee-mail d'inscription appartient déjà à un membre ! (IP : " . getUserIP() . " ; E-mail : $email)";
		$registrationFormIncomplete = "[Inscription] Le formulaire est incomplet ! (IP : " . getUserIP()  . " ; E-mail : $email)" ;				


		try {	

			/* Attention aux erreurs de logique */

				/* On veut se connecter au SGBD MySQL avec le mode d'erreur sur 'PDO Exception' */			
				$conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS) ;
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;              
					
				/* Le contexte vérifie des données d’un formulaire via l'existence de $_POST[] */
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {

					if (isset($name, $surname, $user, $password, $email) && !empty($name) && !empty($surname) && !empty($user) && !empty($password) && !empty($email)) {
								
						/* Vérifie si l'utilisateur existe déjà */																			
								$sth = $conn->prepare($registered);
								$sth->execute([':username' => $user, ':email' => $email]);
								$result = $sth->fetch(PDO::FETCH_ASSOC);

																									
														
							/* Si l'email de l'utilisateur n'existe pas encore */
								if ($result === false) {

									/* Le mot de passe est crypté par l'algorithme BCRYPT (60 octets) */
										$hashedPassword = password_hash($password, PASSWORD_BCRYPT);										
														
										// Sécurité contre injections SQL ; on traite comme du texte les données de $_POST[] 
										$st = $conn->prepare($registrationController);
												// On veut l'enregistrer en base de données
											$st->execute([
												':name' => $name,
												':surname' => $surname,
												':username' => $user,
												':password' => $hashedPassword,
												':email' => $email,
												':date_registration' => $date,								
												':role_id' => 1 // 'client'
											]);
				
										// Session enregistre les données 
										 $_SESSION['user'] = $user;
           								 $_SESSION['role'] = 'Client';										 
										 unset($_SESSION['errorRegistration']);
										 
										// Succès !
										
										header("Location: index.php?page=confirmation-registration");
										exit("OK");
									}

							/* Si l'Utilisateur existe déjà dans la base de données */
									else 
										{
										// Affiche le message dans le journal de log Apache	
											error_log($registrationMember);
											$_SESSION['errorRegistration'] = true;									
											//header("Location: index.php?page=$errorMemberPage");
											exit("L'E-mail d'inscription appartient déjà à un membre !");
										}
								}
								
							/* Si le formulaire est incomplet */
							else 
								{						    									
									error_log($registrationFormIncomplete);
									$_SESSION['errorRegistration'] = true;
									
									header("Location: index.php?page=$errorFormPage");
									exit("Le formulaire est incomplet !");
								}
				} }
					catch (Throwable $e)
				{	
					/* Throwable : attrape tout (les erreurs fatales, les erreurs de type, d’appel de fonction inexistante, etc.) */
					ExceptionHandle($e, "Erreur Fatale");
				}
?>
