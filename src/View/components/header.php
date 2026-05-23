<!-- La page d'UI du site header.php (bandeau menu) : Style K&R , Indentation OK -->
<?php

    if (session_status() == PHP_SESSION_NONE){
        session_start() ;
    }

    // Sécurité contre accès direct aux fichiers internes
    if (!defined('ROOT_PATH')) {
		die('Accès direct interdit 🚫') ;
	}

    include_once ROOT_PATH . $genre_path ;
    $paths_path = "/config/paths.php" ;
    include_once ROOT_PATH . $paths_path ;
    include_once ROOT_PATH . $headerClass_path ;

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- On y inclu les metas essentielles -->
		    <?php 
                include_once ROOT_PATH . $meta_path ; 
            ?>
        <title><?= $_ENV["APP_NAME"] ; ?></title>

        <!-- Partie Javascript -->
        <script>
            function hamburger(dividmenu) {
                const menu = document.getElementById(dividmenu) ;
                if (menu.style.display === 'none' || menu.style.display === "") {
                    menu.style.display = 'block' ;
                } else {
                    menu.style.display = 'none' ;
                }
            }
        </script>
    </head>
    <body>
        <?php
                        // --- Utilisation de nos Classes ---

                        $menu = new Menu() ;
                       // Evite le DRY (Don't repeat yourself)
                       foreach ($menu_header as $label => $page) {
                            $menu->addItem($label, "index.php?page=$page", $page) ;
                        }

                        $register = new Register();
                       // Evite le DRY (Don't repeat yourself)                         
                       foreach ($register_header as $label => $page) {
                            $register->addItem($label, "index.php?page=$page") ;
                        }
        ?>

        <!-- En-tête dynamique , menu du site Cinéphoria -->
            
        <header class="header-content">
            <!-- La bannière du site (logo + menu + compte utilisateur) -->
            <div class="header-banner">
                        <div>
                            <!-- Le logo -->
                            <a href="index.php?page=<?= $filmsPage ; ?>">
                                <img src="<?= $logo_path ; ?>" alt="<?= $logo ?>" class="logo" />
                            </a>
                        </div>  
                        <div class="nav-center">
                            <!-- Le menu dynamique -->
                            <?php $menu->menu() ; ?>
                        </div>                 
                        <div>         
                            <?php
                            // Teste si une session utilisateur existe
                            if (isset($_SESSION['id']))
                                {
                                    ?>
                                    <div class="nav-right">
                                        <?php echo "<span class='welcome'>" . $welcome . ' ' . htmlspecialchars($_SESSION['user']) . "</span>" ; ?>
                                        <img class="menu-hamburger" src=<?= $menu_icon_path ?> />
                                    </div>
                                    <?php
                                }
                            // L'utilisateur n'est pas connecté
                            else 
                                {
                                ?>
                                <div class="nav-right"><?php $register->register() ;?></div>
                                <!-- Menu hamburger (mobile) -->
                                <div class="nav-right-mobile">
                                    <span style="transform:translateY(-30%)">Menu</span>
                                    <a href="javascript:hamburger('dividmenu')">
                                        <img style="cursor: pointer" src=<?= $menu_icon_path ?> alt="menu" id="hamburger" onclick="hamburger()" />
                                    </a>
                                </div>
                                        <!-- Bouton de menu déroulant sur la droite (caché par défaut) -->   
                                        <div id="dividmenu" style="display: none;position: absolute;left:0;background-color: white;border: 1px solid #ccc;border-radius: 8px;box-shadow: 0 2px 8px rgba(0,0,0,0.2); z-index: 1000;width: 100%;background-color:rgba(0, 0, 0, 0.8);">                                                                                       
    
                                            <ul>                    
                                                <li class="element"><a class="no-decor" href='<?= "index.php?page=$profilName" ; ?>'>Espace perso</a></li>
                                                <li class="element"><a class="no-decor" href='<?= "index.php?page=$filmsName" ; ?>'>Tous les films</a></li>
                                                <li class="element"><a class="no-decor" href='<?= "index.php?page=$reservationsName" ; ?>'>Reservations</a></li>
                                                <?php
                                                if (isset($_SESSION['id'])) { ?>
                                                <li class="element"><a class="no-decor" href="
                                                    <?php	                
                                                    // Déconnexion (PHP + Javascript) : revenir sur la page principale et efface la variable de session
                                                        echo "index.php?page=" . $_GET['page'];
                                                    ?>" onclick=effacerSession()>Se déconnecter</a></li><?php } ?>            
                                            </ul>
                                        </div>
                            <?php
                                }
                            ?>
                        </div>                                     
            </div>
            
        <hr style="height: 20px; color: grey;background-color:white;width:100%;padding:0;margin:0" />
        
        </header>  
        
        

        <?php $isFilmsPage = (isset($_GET['page']) && $_GET['page'] === $filmsPage); ?>

        <?php if ($isFilmsPage === true) { ?>
        
        <div class="tv-frame">

            <!-- Une image de fond -->
            <img src=<?= $slide_path ; ?> alt="<?= $slide ?>">

                <div class="query">
                    <form method="POST" action="index.php?page=films" class="form-query">

                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher un film..."                             
                            value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" 
                        />

                        <select name="category" id="category">
                            <option value="" disabled selected hidden>Catégorie</option>
                            <?php foreach ($genre as $type){
                                echo "<option value='$type'>$type</option>";
                            } ?>
                        </select>

                        <input 
                            type="text" 
                            name="location" 
                            placeholder="Où ?"                             
                        />

                        <button type="submit" class="button">🔍 Rechercher</button>

                    </form>
                </div>

        </div>                                     
            <?php } ?>
                    
        <script>
            document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.querySelector('input[name="search"]');
            const hiddenFields = document.querySelectorAll('.form-query select, .form-query input[name="location"], .form-query button');

            searchInput.addEventListener("focus", function () {
                hiddenFields.forEach(el => {
                el.style.display = "block";
                });
            });
            });
        </script> 
    </body>
</html>