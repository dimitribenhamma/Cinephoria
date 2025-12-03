<!-- order.php -->
<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

	$titleProfil = "Mon Espace";
	$titleIdentity = "Mes identifiants" ;
	$titleOrders = "Mes Commandes" ;
	$titleSuppress = "Supprimer ce Compte" ;
	$titleLogout = "Se Déconnecter" ;
?>
<!DOCTYPE html> 
<html lang="fr">
  	<head>
			<title>Mes Commandes</title>
	<style>
		.title-left {
  list-style: none;
  text-decoration:none;
}

a.title-left:hover{
  color:black;
	font-weight: bold;
}	

a.title-left:visited{
	font-weight: normal;
}	

a.title-left:active{
  color:black;
	font-weight: bold;
}
	</style>
	</head>
	<body> 	
	<?php		    	  		
        	// le header et le menu-admin sont à inclure sur chaque page
        	include_once ROOT_PATH . $header_path ;                   		  			
		  	
        if (!$roleCustomer) {		  			
            include_once ROOT_PATH . $menu_admin_path ;
		}
	?>


<div class="title-register"><?= $titleProfil ?></div>

	<div style="display:flex;flex-direction:row;">
	<aside>
		<ul class="left">
			<li style="list-style: none;"><a class="title-left" href="#"><?= $titleIdentity ?></a></li>
			<li style="list-style: none;"><a class="title-left" href="#"><?= $titleOrders ?></a></li>
			<li style="list-style: none;"><a class="title-left" href="#"><?= $titleSuppress ?></a></li>
			<li style="list-style: none;"><a class="title-left" href="#"><?= $titleLogout ?></a></li>
	</ul>	
  	</aside>
	<main style="flex:1; display:flex; justify-content:center; align-items:center;">
		<div class="center" style="margin-left:-18%;">			
			<div ><?= isset($payment) ? "Vous avez des réservations en cours." : "Pas de réservation en cours." ?></div>
			<div><button class="button buttons-text" style="cursor: pointer;" onclick="window.location.href='index.php?page=<?= $profil ; ?>'"><?= $text_button ?></button></div>
		</div>
	</main>
	</div>	


	<!-- Partie php du pied de page en bas -->
      		<footer class="under" style="margin-top:auto">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
	<!-- Partie php du bandeau noir en bas -->					
				<?php include_once ROOT_PATH . $footer_path ; ?>
	<script>
		const links = document.querySelectorAll('.title-left');

		links.forEach(link => {
		link.addEventListener('click', function(e) {
			links.forEach(l => l.classList.remove('active')); // enlever l'ancien
			this.classList.add('active'); // mettre à jour le nouveau
  });
});
	</script>
  </body>
</html>