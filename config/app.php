<!-- la page fr-FR.php : style K&R , Indentation Ok -->
<?php
/* Nos ressources */

	$PRICE_SEAT = $priceSeat = 14 ;

	// Nos titres d'images
	$logoTitle = "logo-cinéphoria" ;
	$bannerCinephoriaTitle = "bannière-coté" ;
	$bannerCinephoriaSmallTitle = "bannière-coté-petit" ;
	$wireframeHomeTitle = "home" ;
	$menuIconTitle = "menu_icon" ;
	$successTitle = "success" ;
	$iconLogoutTitle = "ring" ;	
	
	// Nos images
	$logo = "$logoTitle.svg" ;
	$banner = "$bannerCinephoriaTitle.png" ;
	$bannerSmall = "$bannerCinephoriaSmallTitle.png" ;
	$wireframeHome = "$wireframeHomeTitle.png" ;
	$menuIcon = "$menuIconTitle.png" ;
	$success = "$successTitle.jpg" ;
	$iconLogout = "$iconLogoutTitle.gif" ;
	
	// Référencement validateur pour le w3c
	$API_KEY="AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao";
	$googleapis = "https://maps.googleapis.com/maps/api/js?key=$API_KEY&callback=initMap" ;
	$referencementImage = "https://www.cinephoria.com/image.jpg" ;
	$referencementProperty = "https://www.cinephoria.com/" ;

	// Données Admin
	$visitor = 'Visitor' ;
	$customer = 'Client' ;
	$roleCustomer = $_SESSION['role'] ?? $visitor ;

	// Fonctions
	$ipName = 'IP' ;

	// Css et Javascript
	$css = "style" ;
	$splash = "spalsh" ;
	$formJs = "form" ;
	
?>