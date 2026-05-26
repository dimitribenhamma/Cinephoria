<!-- La page index.php dans tests.local.cinephoria -->
<?php
    define('ROOT_PATH', dirname(__DIR__)) ;

	// Charge avant tout les infos sensibles du .env correctement (en front controller)
	include_once ROOT_PATH . '/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH) ;
	$dotenv->load() ; 

	// Constantes globales à tout le script et tous les sous-fichiers inclus (en front controller)
	define('COOKIE_NAME', $_ENV['COOKIE_NAME']) ;

    require 'tests.php' ;
?>    