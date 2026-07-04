<?php
if (session_status() === PHP_SESSION_NONE) {
				session_start() ;
			  } 

			define('ROOT_PATH', dirname(__DIR__)) ;
		
			// Charge avant tout les infos sensibles du .env correctement (en front controller)
				include_once ROOT_PATH . '/vendor/autoload.php';
				$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH) ;
				$dotenv->load() ; 

			// Constantes globales à tout le script et tous les sous-fichiers inclus (en front controller)
			define('COOKIE_NAME', $_ENV['COOKIE_NAME']) ;
			define('DB_HOST', $_ENV['DB_HOST']) ;
			define('DB_PORT', $_ENV['DB_PORT']) ;
			define('DB_NAME', $_ENV['DB_NAME']) ;
			define('DB_USER', $_ENV['DB_USER']) ;
			define('DB_PASS', $_ENV['DB_PASS']) ;


				/* Fichiers à inclure */
					include_once ROOT_PATH . "/src/View/components/IP.php" ;
					$currentLang = language_nav() ;
					include_once ROOT_PATH . "/lang/$currentLang.php" ;
					$appName = 'app' ;
					$app_path = "/config/$appName.php" ;
					include_once ROOT_PATH . $app_path ;
					$paths_path = "/config/paths.php" ;
					include_once ROOT_PATH . $paths_path ;

			// Notre routeur ici est la page
			$page = $_GET['page'] ?? 'home' ;



				
			// Affiche les erreurs mais doit être journalisé (et a enlever en prod)
			error_reporting(E_ALL) ; 
			ini_set('display_errors', 1) ;
			ini_set('display_startup_errors', 1) ;

			// Sécurité contre accès direct aux fichiers internes
			if (!defined('ROOT_PATH')) {
				die('Accès direct interdit 🚫') ;
			  }

			/* Compteur de session */
			if (!isset($_SESSION['visits'])) {
				$_SESSION['visits'] = 1 ;
				$visits = $_SESSION['visits'] ;
			  } 
			else {
				$_SESSION['visits']++ ;
				$visits = $_SESSION['visits'] ;
			  }

			
			// --- Handlers (login, registration ...) ---					

			switch ($page) {
				case 'home':
					include_once ROOT_PATH . $home_path ;
					break ;
				case 'cookie-controller':
					include_once ROOT_PATH . $cookieController_path ;
					break ;
				case 'login':
					include_once ROOT_PATH . $login_path ;
					break ;				
				case 'login-controller':
					include_once ROOT_PATH . $loginController_path ; 
					break ;							
				case 'password':
					include_once ROOT_PATH . $password_path ;
					break ;	
				case 'password-controller':
					include_once ROOT_PATH . $passwordController_path ;
					break ;						
				case 'registration':
					include_once ROOT_PATH . $registration_path ;
					break ;
				case 'registration-controller' :
					include_once ROOT_PATH . $registrationController_path ;
					break ;
				case 'confirmation-registration' :
					include_once ROOT_PATH . $confirmRegistration_path ;
					break ;		
				case 'confirmation-login' :
					include_once ROOT_PATH . $confirmLogin_path ;
					break ;
				case 'confirm-email' :
					include_once ROOT_PATH . $confirmEmail_path ;
					break ;							
				case 'films-tmdb':
					include_once ROOT_PATH . $tmdb_path ;
					break ;					
				case 'reservations':
					include_once ROOT_PATH . $reservations_path ;
					break ;	
				case 'show':
					include_once ROOT_PATH . $show_path ;
					break ;		
				case 'cart':
					include_once ROOT_PATH . $cart_path ;
					break ;			
				case 'confirmation-reserve':
					include_once ROOT_PATH . $confirmReserve_path ;
					break ;		
				case 'payment':
					include_once ROOT_PATH . $payment_path ;
					break ;
				case 'payment-controller':
					include_once ROOT_PATH . $resaController_path ;
					break ;
				case 'confirmation-reservation':
					include_once ROOT_PATH . $confirmReservation_path ;
					break ;			
				case 'profil':
					include_once ROOT_PATH . $profil_path ;
					break ;
				case 'identity':
					include_once ROOT_PATH . $identity_path ;
					break ;
				case 'orders':
					include_once ROOT_PATH . $order_path ;
					break ;
				case 'suppress':
					include_once ROOT_PATH . $suppress_path ;
					break ;
				case 'logout':
					include_once ROOT_PATH . $logout_path ;
					break ;																				
				case 'films':
					include_once ROOT_PATH . $films_path ;
					break ;
				case 'details':
					include_once ROOT_PATH . $details_path ;
					break ;
				case 'nos-cinemas':					
					include_once ROOT_PATH . $nosCinemas_path ;
					break ;
				case 'error_404':	
					include_once ROOT_PATH . $error_page ;
					break ;
				case 'manage-products':
					include_once ROOT_PATH . $manageProducts_path ;
					break ;	
				case 'manage-users':
					include_once ROOT_PATH . $manageUsers_path ;
					break ;
				case 'tests':
					include_once ROOT_PATH . $tests_path ;
					break ;							
				case 'logout':
					include_once ROOT_PATH . $films_path ;
					break ;			
				default : 
					// Si la page n’existe pas, on redirige vers l’erreur 404
					include_once ROOT_PATH . $error404_path ;
					exit("erreur 404") ;				
				}
?>
