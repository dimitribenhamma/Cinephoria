<!-- la page paths.php : style K&R , Indentation Ok -->
<?php

	// Environnement
	$appName = "app" ;
	$app_path = "/config/$appName.php" ;
	

	/* Fichier à inclure */
	include_once ROOT_PATH . "/src/View/components/IP.php" ;
	$currentLang = language_nav() ;
	include_once ROOT_PATH . "/lang/$currentLang.php" ;
	
	include_once ROOT_PATH . $app_path ;

/* Nos chemins de ressources */


	// Test
	$tests = "tests" ;

	// Images
	$cover = "cover.png" ;
	$coverMobile = "cover-mobile.png" ;
	$slide = "banner.png" ;

	// Controller
	$registrationControllerName = 'RegistrationController' ;
	$loginControllerName = 'LoginController' ;
	$passwordControllerName = 'PasswordController' ;
	$resaControllerName = 'ResaController' ;
	$cookieControllerName = 'CookieController';
	$actionPage = "manage-products-handler" ;
	$errorLoginPage = $catchPage = "login" ; // Assignation en chaîne

	// Model
	$headerClassName = 'Header' ;
	$moviesClassName = 'Movies' ;
	$cinemaClassName = 'Cinema' ;
	$formFieldName = 'FormField' ;
	$formLoginName = 'LoginForm' ;
	$filmFormName = 'FilmForm' ;
	$registrationFormName = 'RegistrationForm' ;
	$contactFormName = 'ContactForm' ;
	$moviesDataName = 'movies' ;
	$cinemasDataName = 'cinemas' ;
	$roomsDataName = 'rooms' ;
	$cinemaFormName = 'CinemaForm' ;
	$cinemaSelectorName = 'CinemaSelector' ;
	$paymentFormName = 'PaymentForm' ;
	$ipName = 'IP' ;
	$genre = 'genre' ;
	
	// View / components / admin
	$cookiesName ='cookies' ;	
	$confirmReserveName = 'confirm-reserve' ;
	$confirmLoginName = 'confirmation-login' ;
	$successContact = 'confirm-contact' ;
	$successContactPage = 'confirmation-contact' ;
	$confirmRegistrationName = 'confirmation-registration' ;
	$loginName = 'login' ;
	$passwordName = 'password' ;
	$registrationName = 'registration' ;
	$tmdbName = 'films-tmdb' ;
	$reservationsName = $reservationsPage = 'reservations' ;
	$reserveName = 'show' ;
	$filmsName = 'films' ;
	$detailsName = 'details';
	$nosCinemasName = 'nos-cinemas' ;
	$error404 = 'error_404' ;
	$registrationName = 'registration' ;
	$homeName = 'home' ;
	$paymentName = 'payment' ;
	$ordersName = 'orders' ;
	$profilName = 'profil' ;
	$identityName = 'identity' ;
	$suppressName = 'suppress' ;
	
	$logoutName = 'logout' ;

	$exceptionHandleName = 'ExceptionHandle' ;
	$metaName = 'meta' ;
	$headerName = 'header' ;
	$cookiesBannerName = 'cookies-banner';
	$moviesName = 'movies' ;
	$paginationName = 'pagination' ;
	$bottomName = 'bottom' ;
	$footerName = 'footer' ;
	$tmdbDataName = 'tmdb';
	$tmdbMainName = 'tmdb-main' ;
	$menuProfilName = 'menu-profil';

	$menuAdminName = 'menu-admin' ;
	$manageProductsName = 'manage-products' ;
	$manageUsersName = 'manage-users';
	$logoutAdminName = 'logout' ;

	$IdLabel = "id" ;


	// Pages front-controller	
	$confirmPage = $filmsPage = $confirmLogoutPage = "films" ;
	$loginPage = "login" ;
	$labelRegistration = "Inscription" ;
	$registrationPage = "registration" ;
	$tmdbPage = "films-tmdb" ;	
	$profilPage = $confirmRegisteredPage = "profil" ;
	$actionLoginPage = "login-controller" ;
	$successLoginPage = "confirmation-login" ;
	$registrationController = "registration-controller" ;
	$successRegistrationPage = "confirmation-registration" ;
	$confirmEmail = "confirm-email" ;
	$confirmEmailPage = "confirmation-email" ;
	$confirmContactPage = "confirm-contact" ;
	$confirmReservePage = "confirmation-reserve" ;
	$passwordPage = "password" ;
	$actionPayment = "payment-controller" ;
	$identityPage = "identity" ;
	$ordersPage = "orders" ;
	$suppressPage = "suppress" ;	
	$manageProductsPage = "manage-products" ;
	$logoutPage = "logout" ;
	
	// Données publiques public / css / img / js
	$logo_path = "img/$logo" ;
	$slide_path = "img/banner/$slide" ;
	$iconLogout_path = "img/icons/$iconLogout" ;
	$img_cinephoria = "img/nos-cinemas/$banner" ;
	$img_cinephoria_small = "img/nos-cinemas/$bannerSmall" ;
	$menu_icon_path = "img/icons/$menuIcon" ;
	$success_img_path = "img/icons/$success" ;
	$ring_img_path = "img/icons/$iconLogout" ;
	$wireframe_film = "img/wireframes/$wireframeHome" ;
	$cover_path = "img/cover/$cover" ;
	$cover_mobile_path = "img/cover/$coverMobile" ;

	// SQL, Css et Javascript
	$sqlName = "sql" ;
	$cssBase = "style" ;
	$cssPhonePortrait = "style-mobile" ;
	$cssPhoneLandscape = "style-landscape" ;
	$filmsJs = "films" ;
	$formJs = "form" ;
	$splash = "spalsh" ;

	$cssBase_path = "css/$cssBase.css" ;
	$cssPhonePortrait_path = "css/$cssPhonePortrait.css" ;
	$cssPhoneLandscape_path = "css/$cssPhoneLandscape.css" ;
	$splash_js = "js/$splash.js" ;
	$form_js = "js/$formJs.js" ;
	$films_js = "js/$filmsJs.js" ;

	// Nos chemins d'URI tests
	$tests_path = "/tests/$tests.php" ;

	// Nos chemins d'URI src->Controller
	$registrationController_path = "/src/Controller/$registrationControllerName.php" ;
	$loginController_path = "/src/Controller/$loginControllerName.php" ;
	$passwordController_path = "/src/Controller/$passwordControllerName.php" ;
	$resaController_path = "/src/Controller/$resaControllerName.php" ;
	$cookieController_path = "/src/Controller/$cookieControllerName.php";

	// Nos chemins d'URI src->Model	
	$headerClass_path = "/src/Model/class/$headerClassName.php" ;
	$moviesClass_path = "/src/Model/class/$moviesClassName.php" ;
	$cinemaClass_path = "/src/Model/class/$cinemaClassName.php" ;
	$genre_path = "/src/Model/data/$genre.php" ;
	$formField_path = "/src/Model/class/$formFieldName.php" ;
	$formLogin_path = "/src/Model/class/$formLoginName.php" ;
	$filmForm_path = "/src/Model/class/$filmFormName.php" ;
	$registrationForm_path = "/src/Model/class/$registrationFormName.php" ;
	$contactForm_path = "/src/Model/class/$contactFormName.php" ;
	$moviesData_path = "/src/Model/data/$moviesName.php" ;
	$cinemasData_path = "/src/Model/data/$cinemasDataName.php" ; 
	$roomsData_path = "/src/Model/data/$roomsDataName.php" ;
	$cinemaForm_path = "/src/Model/class/$cinemaFormName.php" ;
	$cinemaSelector_path = "/src/Model/class/$cinemaSelectorName.php" ;
	$paymentForm_path = "/src/Model/class/$paymentFormName.php" ;
	
	// Nos chemins d'URI src->View / components / admin	
	$confirmEmail_path = "/src/View/$confirmEmail.php" ;	
	$login_path = "/src/View/$loginName.php" ;
	$password_path = "/src/View/$passwordName.php" ;
	$confirmEmailPage_path = "/src/View/$confirmEmailPage" ;
	$successContactPage_path = "/src/View/$successContactPage" ;
	$successContact_path = "/src/View/$successContact" ;
	$registration_path = "/src/View/$registrationName.php" ;
	$tmdb_path = "/src/View/$tmdbName.php" ;
	$reservations_path = "/src/View/$reservationsName.php" ;
	$reserve_path = "/src/View/$reservationsName.php" ;
	$confirmReserve_path = "/src/View/$confirmReservePage.php" ;
	$films_path = "/src/View/$filmsName.php" ;
	$details_path = "/src/View/$detailsName.php" ;
	$nosCinemas_path = "/src/View/$nosCinemasName.php" ;
	$error404_path = "/src/View/$error404.php" ;
	$registration_path = "/src/View/$registrationName.php" ;
	$confirmRegistration_path = "/src/View/$confirmRegistrationName.php" ;
	$confirmLogin_path = "/src/View/$confirmLoginName.php" ;
	$home_path = "/src/View/$homeName.php" ;
	$payment_path = "/src/View/$paymentName.php" ;
	$orders_path = "/src/View/$ordersName.php" ;
	$profil_path = "/src/View/$profilName.php" ;
	$identity_path = "/src/View/$identityName.php" ;
	$suppress_path = "/src/View/$suppressName.php" ;
	$logout_path = "/src/View/$logoutName.php" ;

	$exceptionHandle_path = "/src/View/components/$exceptionHandleName.php" ;	
	$meta_path = "/src/View/components/$metaName.php" ;    	
	$header_path = "/src/View/components/$headerName.php" ;
	$cookiesBanner_path = "/src/View/components/$cookiesBannerName.php" ;
	$movies_path = "/src/View/components/$moviesName.php" ;
	$pagination_path = "/src/View/components/$paginationName.php" ;
	$bottom_path = "/src/View/components/$bottomName.php" ;
	$footer_path = "/src/View/components/$footerName.php" ;
	$tmdbMain_path = "/src/View/components/$tmdbMainName.php" ;
	$menuProfil_path = "/src/View/components/$menuProfilName.php" ;

	$menuAdmin_path = "/src/View/admin/$menuAdminName.php" ;
	$manageProducts_path = "/src/View/admin/$manageProductsName.php" ;
	$manageUsers_path = "/src/View/admin/$manageUsersName.php" ;
	$logoutAdmin_path = "/src/View/admin/$logoutAdminName.php" ;

	// Nos chemins d'URL src->Model	
	$tmdbData = "/src/Model/data/$tmdbDataName.php" ;
	$cookiesData = "/src/Model/data/$cookiesName.php" ;

	// Nos chemin d'URL de requêtes SQL
	$sql_path = "/config/$sqlName.php" ;

	// Fonctions PHP
	$ipName_path = "/src/View/components/$ipName.php" ;
	$tracker_path = "/includes/tracker.php" ;

	// Données des Cookies
	$visits = isset($visits) ? ($visits++) : 1 ;
	$platform = getOS() ;
	$device = getDeviceType() ;
	$resolution = getResolution() ;
	$successCookiePage = $errorCookiePage = $catchPage = $_GET['page'] ?? 'home' ;	
	$duration_cookie = 365 * 24 * 3600 ; // Vaudra 1 an (RGPD)
	$port_https = 443 ; // Le port standard pour HTTPS sur les serveurs web.
	$browser = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown' ;
	$browserInfo = getBrowserInfo() ;
	$langue = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? "$unknown", 0, 2) ;
	$country = isset($geo['country']) ? ($geo['country'] ?? 'API#ERROR') : null ;
	$date = date("Y-m-d H:i:s") ; // La date+temps actuels
	$current_date = date_fr() ;

	// Données label Cookies
	$labelClientCookiesId = 'Client_cookies_id' ;
	$labelConsent = 'Consent' ;
	$labelCookieName = 'Cookie_name' ;
	$labelTimezone = 'Timezone' ;
	$labelUserName = "Username" ;	
    $labelBrowser = "Browser" ;
	$labelBrowserVersion = "BrowserVersion" ;
    $labelLanguage = "Language" ;
    $labelCountry = "Country" ;
    $labelCity = "City" ;
    $labelIsp = "Isp" ;
    $labelLatitude = "Latitude" ;
    $labelLongitude = "Longitude" ;
    $labelCookieDate = "Cookie_date" ;
    $labelIp = "Ip" ;
	$labelEvents = "Events" ;
	$labelVisits = "Visits" ;
    $labelRole = "Role" ;
	$labelPlatform = "Platform" ;
	$labelDevice = "Device" ;	

	/* Obtenir le Fuseau horaire */


?>