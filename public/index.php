<!-- Style K&R , indentation Ok
  - la page contrôleur du site -->
<?php
define('ROOT_PATH', dirname(__DIR__));
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$id_path = '/src/View/components/identifiants.php';
include_once ROOT_PATH . $id_path;

error_reporting(E_ALL); 
session_start();
?>

<!DOCTYPE html>
	<?php	
		
			// Sécurité contre accès direct aux fichiers internes
			if (!defined('ROOT_PATH')) {
				die('Accès direct interdit 🚫');
			}
			
			// Charge la config .env correctement (en front controller)
			    include_once ROOT_PATH . '/vendor/autoload.php';
				$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/..');
				$dotenv->load();

			// Notre routeur ici est la page
				$page = $_GET['page'] ?? 'home';
				
			// --- Handlers (login, registration...) ---					

			switch ($page) {	
				case 'home':
					include_once ROOT_PATH . $home_path;
					break;						
				case 'login':
					include_once ROOT_PATH . $login_path;
					break;				
				case 'login-controller':
					include_once ROOT_PATH . $loginController_path;
					break;								
				case 'password':
					include_once ROOT_PATH . $password_path;
					break;		
				case 'password-controller':
					include_once ROOT_PATH . $passwordController_path;
				break;							
				case 'registration':
					include_once ROOT_PATH . $registration_path;
					break;
				case 'registration-controller' :
					include_once ROOT_PATH . $registrationController_path;
					break;
				case 'confirmation-registration' :
					include_once ROOT_PATH . $confirmRegistration_path;
					break;		
				case 'confirm-login' :
					include_once ROOT_PATH . $confirmLogin_path;
					break;		
				case 'confirm-email' :
					include_once ROOT_PATH . $confirmEmail_path;
					break;							
				case 'films-tmdb':
					include_once ROOT_PATH . $tmdb_path;
					break;					
				case 'reservation':
					include_once ROOT_PATH . $reservation_path;
				break;	
				case 'show':
					include_once ROOT_PATH . $reserve_path;
				break;				
				case 'confirm-reserve':
					include_once ROOT_PATH . $confirmReserve_path;
				break;		
				case 'payment':
					include_once ROOT_PATH . $payment_path;
				break;
				case 'orders':
					include_once ROOT_PATH . $order_path;
					break;
				case 'profil':
					include_once ROOT_PATH . $profil_path;
					break;														
				case 'films':
					include_once ROOT_PATH . $films_path;
				break;
				case 'details':
					include_once ROOT_PATH . $details_path;
					break;
				case 'nos-cinemas':					
					include_once ROOT_PATH . $nos_cinemas_path;
					break;
				case 'error_404':	
					include_once ROOT_PATH . $error_page;
					break;
				case 'manage-products':
					include_once ROOT_PATH . $manage_products_path;
					break;	
				case 'manage-users':
					include_once ROOT_PATH . $manage_users_path;
					break;
				case 'logout':
					include_once ROOT_PATH . $films_path;
					break;			
				default: 
					// Si la page n’existe pas, on redirige vers l’erreur 404
					include_once ROOT_PATH . $error_path;
					exit;				
				}
	?>
