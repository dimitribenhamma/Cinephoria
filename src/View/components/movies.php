<!-- La page du site movies.php (texte pur HTML & PHP dynamique) : Style K&R , indentation Ok -->
<?php

    // Ce code initialise une session unique et empêche d'être appelée plusieurs fois
    if (session_status() === PHP_SESSION_NONE) {
        session_start() ;
      }

    include_once ROOT_PATH . $moviesData_path ; 
    include_once ROOT_PATH . $moviesClass_path ;
    include_once ROOT_PATH . $pagination_path ;

// Page courante
$currentPage = isset($_GET['index']) ? (int)$_GET['index'] : 1 ;
$currentPage = max($currentPage, 1) ; // min = 1

// Nombre total de films
$totalMovies = count($films) ;

$title = "Toutes les nouveautés" ;
// Nombre de films par page
$persPage = 6 ;

$perPage = (int) $persPage ;
if ($perPage <= 0) { $perPage = $persPage; }

// Nombre total de pages
$totalPages = ceil($totalMovies / $perPage) ; // division entière
 
// Index de départ
$start = ($currentPage - 1) * $perPage ;

// Découpe des films à afficher
$pile = array_reverse($films) ;

// Création de l’objet Movies
$moviesObj = new Movies($pile, $perPage) ;

// Partie centrale de l'application
?>
<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
<main style="width:100%;text-align:center;flex:0 0 80%;margin:auto;">
    
    <div class="gallery" style="gap:20px; margin-top:20px;">
         
        <?php
        $searchQuery = $_POST['search'] ?? '' ;

        if ($searchQuery !== '') {
            // Affiche les résultats de recherche
            echo $moviesObj->renderSearchResults($searchQuery) ;
        } else {
            // Affiche la page classique           
            echo $moviesObj->renderMoviesPage($currentPage) ;
        }
        ?>

    </div>
    <!-- Pagination -->
    <?php if ($searchQuery === ''): ?>
    <div>
        <div class="pagination" style="text-align:center;font-weight: bold">
            <?php pagination($totalPages, $currentPage) ; ?>
        </div>
    </div>
    <?php endif ; ?>        
</main>