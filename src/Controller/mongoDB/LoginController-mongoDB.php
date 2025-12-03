<!-- LoginController.php -->
<?php
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}	
		
		$ip_path = '/src/View/components/IP.php';
		$email = isset($_POST['email']) ? trim($_POST['email']) : null;

		include_once ROOT_PATH . $ip_path;	

		// Définit nos variables messages clairs pour la gestion des erreurs/succès 
		$member = "Erreur Connexion $email : les données ne correspondent pas à un membre ! IP : " . getUserIP() ;	
		$success_page = "confirmation-login";
		$login_page = "login";
		$catch_message = "Erreur Connexion $email : Problème ";
		
		// On essaie de se connecter en base
		try {		 
				require 'vendor/autoload.php'; // Charge le driver MongoDB via Composer		
				// Connexion à MongoDB
    			$client = new MongoDB\Client("mongodb://{$_ENV['DB_USER']}:{$_ENV['DB_PASS']}@{$_ENV['DB_HOST']}/{$_ENV['DB_NAME']}");                
                // Sélection de la base de données
    			$db = $client->selectDatabase($_ENV['DB_NAME']);
				$collection = $db->membres;
						
				if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){									
					$password = isset($_POST['password']) ? trim($_POST['password']) : null;								

					// Vérifie si le user existe déjà
        			$resultat = $collection->findOne(['email' => $email],['projection' => ['_id' => 1, 'password' => 1, 'email' => 1, 'role' => 1]]); // on récupère juste l'id MongoDB					

					/* cas avec succès */
					
					
					// password_verify entre clair et haché : 
					// 1. le résultat est différent car un "salt" aléatoire (pas à chaque fois) est ajouté 
					// 2. le hash change à chaque password_hash()
					if ($resultat && isset($resultat['password']) && password_verify($password, $resultat['password'])){	
						// rôles valides
						$_SESSION['user'] = $resultat['email'] ?? '';						
						$_SESSION['id'] = (string)$resultat['_id'];
						// vérification de rôle
						$role = $resultat['role'] ?? 'client';
						$_SESSION['role'] = $role;									           
						header("Location: index.php?page=$success_page");
						exit();
					} else {											
						error_log($member);
						$_SESSION['error'] = true;   																
						header("Location: index.php?page=$login_page");
						exit();
					}
				}
		}

		catch(Exception $e){
			error_log($catch_message . $e->getMessage());		
			}