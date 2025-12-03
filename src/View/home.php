  <!-- la page d'accueil par défaut du site
	-- On met nos blocs réutilisables ici -->
		
<!-- On y inclu les metas essentielles -->
<?php 	
		$meta_path = '/src/View/components/meta.php';
  		$cookies_path = '/src/View/components/cookies-banner.php';
  		$title = "Cinéphoria : réservez vos places de cinéma";
		$enter = "Entrer sur le site";
  		$text = "Nous utilisons des cookies pour améliorer votre expérience. Acceptez-vous l'utilisation de cookies ?";
  		
		$cover_path = "img/cover/cover.png";
		$cover_mobile_path = "img/cover/cover-mobile.png";

		include_once ROOT_PATH . $meta_path;
		include_once ROOT_PATH . $cookies_path;
		
?>

<html lang="fr">
	<head>
		<style>
			/* Style des Cookies */
				#cookie-banner {
				position: absolute;
				font-size:0.9rem;
				bottom: 0;
				left: 0;
				width: 100%;
				background-color: rgba(0, 0, 0, 0.8);
				color: white;    
				text-align: center;
				display: none;
				z-index: 1000;        
				}
		</style>		
			<title><?= $_ENV["APP_NAME"] . " : réservez vos places de cinémas"; ?></title>
	</head>
	<body> 	
<!-- Partie Javascript -->		
		<script>
window.addEventListener('load', () => {
		    const splash = document.getElementById('splash');
		    const cookieBanner = document.getElementById('cookie-banner');

		    // Vérifie si le splash a déjà été vu
		    if (sessionStorage.getItem("splashSeen")) {
		        splash.style.display = 'none'; // le cacher immédiatement
		        <?php if (!($cookies_accepted || $cookies_refused)) : ?>
		            if (cookieBanner) {
		                cookieBanner.style.display = 'block';
		            }
		        <?php endif; ?>
		    } else {
		        // Première visite → afficher le splash pendant 4000ms
		        setTimeout(() => {
		            splash.style.display = 'none';
		            <?php if (!($cookies_accepted || $cookies_refused)) : ?>
		                if (cookieBanner) {
		                    cookieBanner.style.display = 'block';
		                }
		            <?php endif; ?>
		            // On enregistre que le splash a été vu
		            sessionStorage.setItem("splashSeen", "true");
		        }, 4000); // durée du splash
		    }
		});

</script>	
			<div id="splash">
				<img src="<?= $wireframe_film ?>" alt="Wireframe" />
		 	</div> 

		<header>
				<div class="home-page">
					<span><?= $title ?></span>
				</div>
		</header>
		<section class="hero-cover">
				<img class="cover" src="<?= $cover_path ?>" alt="image par défaut" />
				<img class="cover-mobile" src="<?= $cover_mobile_path ?>" alt="image mobile first" />
				<a href="index.php?page=films">
					<button class="btn-enter-overlay"><?= $enter ?></button>
				</a>
				<?php 	  // Dans le cas où l'on se déconnecte , on détruit la session 'user'
				if((isset($_COOKIE['cinephoria']))){					
					setcookie('cinephoria',$tableau, time() - 3600,'/', "", false, true);}
				?>
			   <!-- Bannière de consentement RGPD pour les cookies -->
			<div id="cookie-banner">
				<p><?= $text ?></p>
				<form method="POST" style="display: inline-block;">
					<label for="accept"></label><input type="submit" id="accept" name="accept_cookies" value="Accepter" class="cookies-style" style="margin-right: 10px;" />
					<label for="refuse"></label><input type="submit" id="refuse" name="refuse_cookies" value="Refuser" class="cookies-style" />
				</form>
			</div>					
		</section>
	
	<script>console.log("bienvenue sur le site des cinémas Cinéphoria !");</script>		
	</body>
</html>