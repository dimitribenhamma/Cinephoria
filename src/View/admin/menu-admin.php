<?php	
if (session_status() === PHP_SESSION_NONE) {
    session_start();}

    $title = "Bienvenue dans l'espace administrateur";
    $menu = ['films' => ['label' => 'Tableau de bord', 'data' => 'tableau'],
            'manage-users' => ['label' => 'Gérer les utilisateurs', 'data' => 'users'],
            'manage-cinemas' => ['label' => 'Gérer les cinémas', 'data' => 'cinemas'],
            'manage-products' => ['label' => 'Gérer les produits', 'data' => 'products'],
            'rooms' => ['label' => 'Gérer les salles', 'data' => 'rooms'],
            'logout' => ['label' => 'Se déconnecter', 'data' => 'logout'],
            ];
    

        include_once ROOT_PATH . $meta_path;
        $page = $_GET['page'] ?? 'films'; // page courante (par défaut : films)		
        		          

        // Vérification si l'utilisateur est employé ou administrateur
        if (isset($_SESSION['role']) && (($_SESSION['role'] === "employe") || ($_SESSION['role'] === "admin"))){	
        ?>

        <!-- Code HTML pour afficher le menu administrateur -->		
        <nav class="admin">
            <h1><?= $_ENV["APP_NAME"]; ?></h1>
            <ul> <!-- data-id pour Javascript -->
                <?php foreach ($menu as $key => $item): ?>
        <li>
            <a class="link <?= ($page === $key) ? 'actif' : '' ?>" 
               href="index.php?page=<?= htmlspecialchars($key) ?>" 
               data-id="<?= htmlspecialchars($item['data']) ?>">
               <?= htmlspecialchars($item['label']) ?>
            </a>
        </li>
    <?php endforeach; ?>
        	<!-- Le bouton "Déconnexion" permet de supprimer la session et les cookies -->
            </ul>
        </nav>
        <?php } else { echo ''; }  
?>	
	  <script>console.log("Menu admin");</script> 
        