<?php 		

    if (session_status() === PHP_SESSION_NONE) {
   	  	session_start() ;}

        /* Fichiers à inclure */
                include_once ROOT_PATH . "/src/View/components/IP.php" ;
				$currentLang = language_nav() ;
				include_once ROOT_PATH . "/lang/$currentLang.php" ;

    // Vérification si l'utilisateur est employé ou administrateur
    if (isset($_SESSION['role']) && (($_SESSION['role'] === "employe") || ($_SESSION['role'] === "admin"))) {	
?>
        <!-- Code HTML pour afficher le menu administrateur -->		
        <nav class="admin">
            <h1><?= $textAdmin ; ?></h1>
            <ul> 
                <?php foreach ($menuAdmin as $key => $item): ?>
                        <li>
                            <a class="link <?= ($page === $key) ? 'actif' : '' ?>" 
                            href="index.php?page=<?= htmlspecialchars($key) ?>" 
                            data-id="<?= htmlspecialchars($item['data']) ?>"> <!-- data-id pour Javascript -->
                            <?= htmlspecialchars($item['label']) ?>
                            </a>
                        </li>
                <?php endforeach; ?>
            </ul>
        </nav>
<?php 
      } 
    else { 
            // Sinon on laisse le script s'éxécuter normalement
            echo '' ; 
      }  
?>	
	  <script>console.log($textAdmin);</script> 
        