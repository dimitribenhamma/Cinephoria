<!-- La page d'UI du site logout.php : Style K&R , indentation ok -->
<?php
	    if (session_status() === PHP_SESSION_NONE) {
    	  	session_start() ;
        }    

        /* Donnée de départ */
        $id_path = '/src/View/components/identifiants.php' ;

        /* Fichier à inclure */
        include_once ROOT_PATH . $id_path ; // Obtenir les données pré-initialisées


        /* On détruit toutes la session */
        session_destroy() ;

        /* On détruit le(s) cookie(s) */
        setcookie($_ENV['COOKIE_NAME'], '', time() - $duration_cookie) ;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= $_ENV["APP_NAME"] ; ?></title>
  <script>
      // Supprimer l'entrée 'lienActif' dans le localStorage
      localStorage.removeItem('lienActif') ;
          // Rediriger après un court délai pour laisser le temps au JS de s'exécuter
          setTimeout(() => {
            window.location.href = 'index.php?page=' . $confirmLogout ;
          }, 4000) ;  
      localStorage.removeItem('lienActif') ;  
  </script>
</head>
<body>
    <div style="text-align:center;margin-top:300px">
        <span style="margin-bottom:10px;display:block"><?= $titleLogout ; ?></span>
        <img src="img/icons/ring.gif" alt="<?= $titleLogout ; ?>" width="30px" height="30px" />
    </div>
</body>
</html>
