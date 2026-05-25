<!-- la page fr.php : style K&R , Indentation Ok -->
<?php

/* Nos ressources */

	$customer = 'client' ;


	/* Fichiers à inclure */
	$app = getenv('APP_NAME') ;
	$appName = 'app' ;
	$app_path = "/config/$appName.php" ;
	include_once ROOT_PATH . $app_path ;
	$paths_path = "/config/paths.php" ;
	include_once ROOT_PATH . $paths_path ;

	// Données pratiques
	$tmdbDataName = 'tmdb';
	$ipName = 'IP' ;

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

	$ourCinemas = "Nos Cinemas" ;
	$labelLogin = "Connexion" ;    	
	$titleUsers = "Tous les utilisateurs" ;

	// Données textuelles des Cookies (pour langue : français)
	$cookieName = "cinephoria" ; 
	$accept = "accepter" ;
	$valueCookieAccepted = "cinephoria" ;
	$refuse = "refuser" ;
	$valueCookieRefused = "cinephoria" ;	
	$textUser = 'Visiteur' ;
	$unknown = "unknown" ;
	$textBanner = "Nous utilisons des cookies pour améliorer votre expérience. Acceptez-vous l'utilisation de cookies ?" ;
	$acceptCookieTxt = $refuseCookieTxt = "le Cookie 'cinephoria' a bien été déposé sur la machine ET en base de données" ;
	$nullCookieText = "Le Cookie 'cinephoria' n'a pas encore été déposé sur la machine de l'utilisateur" ;
	$textCookieException = "Impossible de déchiffrer le cookie" ;
	$textDecryptException = "Déchiffrement échoué" ;
	$textInvalidException = "Cookie falsifié ou invalide" ;
	$textDatabaseSuccess = "L'insertion en base de données est un succès !" ;
	$successCookieText = "Le Cookie a été enregistré en base de données" ;
	

	// Home Page
  	$homeTitle = "Cinéphoria : réservez vos places de cinéma" ;
	$actionHomeEnter = "Entrer sur le site" ;	

	// Données pour le login
	$labelEmail = $emailPlaceholder = "Email" ;
	$labelPassword = $passwordPlaceholder = 'Mot de passe' ;
	$emailText = "Veuillez saisir une adresse email valide (ex: nom@domaine.com)" ;
	$passwordText = "8 à 20 caractères, avec au moins une majuscule, une minuscule et un chiffre" ;
	$consoleLogin = "Cinéphoria : log-in" ;
	$consoleRegistration = "Cinéphoria : inscription" ;

	// Données pour l'Inscription
	$fieldValid = "Entre 2 et 20 caractères" ;
	$passwordValid = '5 à 20 caractères, avec uniquement lettres et chiffres' ;
	$emailValid = 'Veuillez saisir une adresse email valide (ex: nom@domaine.com)' ;
	$dateValid = 'Veuillez saisir une date valide' ;
	$fieldSend = 'Envoyer' ;

	$dateRegisterLabel = "Date d'inscription" ;

	// Données pour le header
	$logo = "Logo Cinéphoria" ;
	$welcome = "Bienvenue" ;
	$ReservationsPage = 'Reservations' ;
    $menu_header = ["Réservations" => "reservations", "Films" => "films", "Nos Cinémas" => "nos-cinemas"] ;
    $register_header = ["Connexion" => "login", "Inscription" => "registration"] ;
	$slide = "slide" ;

	// Données de réservation
	$messageReservation = 'Vous pouvez maintenant réserver des séances' ;
	$labelChoose = "Choisir" ;
	$projectedAt = "Films projetés à" ;
	$pleaseLogin = "Connectez-vous pour réserver" ;
	$labelHeart = "Label coup de coeur" ;
	$duration = "Durée" ;
	$numberRoom = "Numéro de salle" ;
	$genre = "Genre" ;
	$realisator = "Réalisateur" ;
	$hours = "Horaires" ;
	$reduce = "Diminuer le nombre de places" ;
	$increase = "Augmenter le nombre de places" ;
	$alertShow = 'Le nombre demandé dépasse les places disponibles.' ;
	$anyResults = "Aucun résultat en ce moment" ;
	$reservations = "Cinéphoria : page de réservation" ;

	// Données d'Administration (manage-products.php)
	$action = 'Action' ;
	$animation = 'Animation' ;
	$adventure = 'Aventure' ;
	$biopic = 'Biopic' ;
	$comedy = 'Comédie' ;
	$documentary = 'Documentaire' ;
	$drama = 'Drame' ;
	$family = 'Famille' ;
	$fantasy = 'Fantastique' ;
	$historical = 'Historique' ;
	$horror = 'Horreur' ;
	$musical = 'Musical' ;
	$crime = 'Policier' ;
	$romance = 'Romance' ;
	$scienceFiction = 'Science-Fiction' ;
	$thriller = 'Thriller' ;
	$western = 'Western';
	$allGenres = [$action, $animation, $adventure, $biopic, $comedy, $documentary, $drama, $family, $fantasy, $historical, $horror, $musical, $crime, $romance, $scienceFiction, $thriller, $western] ;
	
	$years = '$years' ;
	$allpublic = 'tout public' ;
	$allAges = [$allpublic,"-10 $years", "-12 $years", "-14 $years", "-16 $years", "-18 $years"] ;
	$original = 'VO' ;
	$original_subtitle = 'VOST' ;
	$second = 'VF' ;
	$second_subtitle = 'VSTFR' ;
	$allVersions = [$original, $original_subtitle, $second, $second_subtitle] ; 
	
	$labelTitle = 'Titre du film' ;
	$labelImage = "Image" ;
	$labelAuthor = "Auteur" ;
	$labelReleaseDate = "Date de sortie" ;
	$labelDuration = "Durée (HH:MM)" ;
	$labelDescription = "Description" ;
	$labelType = "Genre(s)" ;
	$labelVersion = "Version" ;
	$labelForbidden = "Interdit (âge légal)" ;
	$placeholderDuration = 'Exemple: 1h23' ;
	$titleManageProducts = "Liste des films" ;	
	$titleManageList = isset($id) ? "Modifier un film" : "Ajouter un film" ;
	$option = "Choisir le Film à modifier" ;		  
	$subtitle_reset = "Effacer le formulaire" ;
	$subtitle_delete = "Effacer l’image" ;		
	$wednesday = "Le formulaire n'est accessible que le mercredi." ;
	$current_day = (int)date('w') ; // 0 (dimanche) à 6 (samedi) avant l'affichage HTML

	// Données de bas de page (bottom.php)
	$informations = "Informations" ;
	$findUs = "Retrouvez-nous" ;
	$title_column = [$app, $informations, $findUs] ;
	
	$social_item = ["Facebook", "Instagram", "Tmdb"] ;
	$social_item_link = ["#", "#", "./index.php?page=$tmdbDataName"] ;
	$social_item_img = ["img/social/facebook.png", "img/social/instagram.png", "img/social/$tmdbDataName.png"] ;

	$contactUs = "Contact" ;
	$contactSub = strtolower($contactUs)	;
	$mentions = "Mentions Légales" ;
	$condtions = "Conditions générales" ;
	$info_item = [$contactUs, $mentions, $condtions] ;
	$info_item_link = ["./$contactSub.php", "#", "#"] ;

	/* Nos Cinemas */
	$titleCinemas = "Nos cinémas" ;
	$AddressAlert = "Adresse non trouvée" ;

	/* Contact */
	$successContact = "Le formulaire a été envoyé avec succès !" ;

	$_SESSION['seats'] = (int)($_POST['seats'] ?? 0) ;
	$titleContact = "Réservation de" . " " . $_SESSION['seats'] . " " . "place" . (($_SESSION['seats'] > 1) ? "s" : "") ;

	/* Email */
	$emailSend = "L'email a bien été envoyé !" ;
	
    /* Réservation */  
    $initialForm = "Choisir le cinéma" ;
    $actionPageReserve = "show" ;
    $actionPageLogin = "login" ;	

	// Données textuelles du Contrôleur de formulaire Admin (manage-products-handler.php)	
	$errorSizeFile = "Taille maximum (2Mo) dépassée." ;
	$textSuccessFilm = "Film ajouté avec succès!" ;
	$textErrorForm = "Erreur lors de l'ajout du film." ;
	$textErrorFile = "Erreur lors du téléchargement de la pochette." ;
	$textErrorMimeFile = "Format de fichier Mime non autorisé." ;
	$textErrorExtensionFile = "Format d'image non autorisé. Seuls les formats jpg, jpeg, png et gif sont autorisés." ;
	$textErrorMoveUploads = "Impossible de déplacer l'image dans le dossier uploads" ;
	$textMissingInputFilm = "Veuillez sélectionner des données complètes." ;
	

	// Données textuelles pour les utilisateurs "membres" (manage-users.php)
	$titleUsers = "Liste des Membres";
	$IdLabel = "id" ;
	$nameLabel = "nom" ;
	$surnameLabel = "prénom" ;
	$usernameLabel = "nom d'utilisateur" ;
	$passwordLabel = "mot de passe" ;
	$usernLabel = "user" ;
	$emailLabel = "email" ;
	$dateLabel = "date" ;
	$dateBirthLabel = "Date de naissance" ;
	$emptyUserDatabase = "Erreur (Bdd) : pas de résultats d'utilisateurs dans la base" ;

	// Menu administrateur (menu-admin.php)
	$pageAdmin = $_GET['page'] ?? 'films'; // page courante (par défaut : films)		
	$titleMenuAdmin = "Bienvenue dans l'espace administrateur";
	

	$dashboard = "Tableau de bord" ;
	$table = "tableau" ;
	$ManageUsers = "Gérer les utilisateurs" ;
	$ManageCinemas = "Gérer les cinémas" ;
	$cinemas = "cinemas" ;
	$ManageProducts = "Gérer les produits" ;
	$products = "products" ;
	$rooms = "rooms" ;
	$tests = "Voir les tests" ;
	$ManageRooms = "Gérer les salles" ;
	$logout = "Se déconnecter" ;
    $menuAdminItems = ['Dashboard' => ['label' => $dashboard, 'data' => $table],
					'manage-users' => ['label' => $ManageUsers, 'data' => 'users'],
					'manage-cinemas' => ['label' => $ManageCinemas, 'data' => $cinemas],
					'manage-products' => ['label' => $ManageProducts, 'data' => $products],
					'rooms' => ['label' => $ManageRooms, 'data' => $rooms],
					'tests' => ['label' => $tests, 'data' => 'tests'],
					'logout' => ['label' => $logout, 'data' => 'logout']
				];
	$textAdmin = "Menu admin" ;
	
	// Données textuelles pour la déconnexion (logout.php)
	$titleLogout = "Déconnexion en cours" ;

	// Données de la page 404
	$mainTitle404 = "404" ;
  	$title404 = "Désolé, page introuvable" ;
  	$subtitle404 = "La bobine est introuvable" ;
  	$text404 = "Retour au menu" ;
	$titleError404 = "chocolat" ;
	$nosCinemasName = 'nos-cinemas' ;
 	$img404 = "./img/$nosCinemasName/$titleError404.png" ;
	$altImg404 = "Personnage" ;

	// Données textuelles d'Exceptions (langue : français)
	$textErrorPDO = "Erreur PDO" ;
	$textExceptionPHP = "Exception PHP" ;
	$textFatalError = "Erreur Fatale" ;
	$manageProductsException = "Erreur de connexion" ;

	// Référencement
	$descriptionMeta = "Réservez vos places de cinéma. Venez découvrir nos établissements à Toulouse, Paris, Lille, Bordeaux et Nantes ainsi qu'en Belgique à Charleroi et Liège." ;
	$referencementTitle = "Exemple de Page SEO - Cinéphoria" ;
	$referencementProperty	= "Page bien optimisée pour le SEO et les réseaux sociaux." ;
	$referencementType = "bienvenue" ;
	
?>