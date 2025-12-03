<!-- manage-products-handler.php -->
<!-- Gestion pour l'ajout ou pour modifier un film (movies.php) -->

<?php 
if (session_status() === PHP_SESSION_NONE) {
    	  session_start();}
    include_once ROOT_PATH . $movies_data_path;

    // libre à vous de rajouter des conditions
    function date_fr(){
			$date = new DateTime();
			$formatter = new IntlDateFormatter(
				'fr_FR', 
				IntlDateFormatter::FULL, 
				IntlDateFormatter::NONE,
				'Europe/Paris',
				IntlDateFormatter::GREGORIAN,
				"EEEE d MMMM y"
			);
			return ucfirst($formatter->format($date));
		}

try {                                         
/* Connexion à notre DataFile PHP.
   Vérification si le formulaire est soumis,
   si un champ est NULL, on affiche un message d'erreur dans le log. */

if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['titre'],$_POST['description'],$_POST['auteur'],$_POST['duree'],$_FILES['pochette'],$_POST['movie_release_date'],$_POST['cinema']) && !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['auteur']) && !empty($_POST['duree']) && ($_FILES['pochette']['error'] === 0) && !empty($_POST['movie_release_date']) && !empty($_POST['cinema'])) {    

    // Récupération des données du formulaire
    $title = $_POST['titre'];
    $subtitle = $_POST['subtitle'] ?? "null";   
    $description = $_POST['description'];
    $movie_release_date = $_POST['movie_release_date'];
    $duree = $_POST['duree'];
    $auteur = $_POST['auteur'];
    $pochette = $_FILES['pochette'] ?? 'img/uploads/fallback.jpg';
    $forbidden = $_POST['age'];
    $version = $_POST['version'];
    $genre = $_POST['genre'];
   
/* On sépare la logique ici */

    // Traitement de l'image (pochette)
    if ($_FILES['pochette']['error'] == 0) {

        // On définit le répertoire où stocker les images
        $uploadDir = 'uploads/';
        
        // Générer un nom unique
        $fileName = basename($_FILES['pochette']['name']);
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('film_', true) . "." . $ext;

        // Déplacer le fichier uploadé
        $uploadFile = $uploadDir . $newFileName; 

        // Vérification de l'extension de l'image
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'heic', 'svg'];
        $allowedMimeTypes = ['image/jpg','image/jpeg','image/png','image/gif','image/webp','image/avif','image/heic','image/svg'];

        $fileExtension = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        // Vérification taille
        $maxSize = 2 * 1024 * 1024; // 2 Mo


        $fileTmp = $_FILES['pochette']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileMime = mime_content_type($fileTmp);

        if (!in_array($fileMime, $allowedMimeTypes)) {
        die('Type de fichier non autorisé.');
        }

        if (in_array($fileExtension, $allowedExtensions)) {
            if ($_FILES['pochette']['size'] > $maxSize) {
                $_SESSION['message'] = "<p style='color:red'>L’image dépasse la taille maximum (2Mo).</p>";
                header("Location: manage-products.php");
                die('L’image dépasse la taille maximum (2Mo)');
            }

            // Déplacer l'image vers le dossier uploads
            else if (move_uploaded_file($fileTmp, $uploadFile)) {

                // Gérer le nouveau contenu PHP
                // Réécrire le DataFile avec le nouveau tableau
                // Nouvelle ligne à ajouter                

                $nouvelleLigne = ["id" => count($films) + 1, "titre" => $_POST['titre'], 'subtitle' => $_POST['subtitle'], "description" => $_POST['description'], "auteur" => $_POST['auteur'], "duree" => $_POST['duree'], 'version' => $version, 'interdit' => $forbidden, 'genre' => $genre, "created_at" => date_fr(), "date_de_sortie" => date_movie_release($movie_release_date), "pochette" => $uploadFile];


                // Ajouter la ligne au tableau 2D
                $films[] = $nouvelleLigne;

                // Convertir en code PHP
                $contenu = "<?php\n\n\$films = " . var_export($films, true) . ";\n";

                // Réécrire le DataFile nouvelle version
                file_put_contents('../data/movies.php', $contenu);                                          
            ?>
                <script>console.log("Film ajouté avec succès!");</script>
            <?php
        $_SESSION['message'] = "<span class='success'>Film ajouté avec succès!</span><br><br>";
        $_SESSION['console'] = "<script>console.log('Film ajouté avec succès!');</script>";

        
                } else {
             ?>
                <script>console.log("Erreur lors de l'ajout du film.");</script>
             <?php
        $_SESSION['message'] = "<span class='error'>Erreur lors de l'ajout du film.</span><br><br>";
        $_SESSION['console'] = "<script>console.log('Erreur lors de l'ajout du film.');</script>";
            }
            } else {
                ?>
                <script>console.log("Erreur lors du téléchargement de la pochette.");</script>
            <?php
        $_SESSION['message'] = "<span class='error'>Erreur lors du téléchargement de la pochette.</span><br><br>";
        $_SESSION['console'] = "<script>console.log('Erreur lors du téléchargement de la pochette.');</script>";
        }
        } else {
            ?>
                <script>console.log("Format d'image non autorisé. Seuls les formats jpg, jpeg, png et gif sont autorisés.");</script>
            <?php
        $_SESSION['message'] = "<span class='error'>Format d'image non autorisé. Seuls les formats jpg, jpeg, png et gif sont autorisés.</span><br><br>";
        $_SESSION['console'] = "<script>console.log('Format d'image non autorisé. Seuls les formats jpg, jpeg, png et gif sont autorisés.');</script>";
    }
    } else {
        ?>
            <script>console.log("Veuillez sélectionner une pochette.");</script>
        <?php
        $_SESSION['message'] = "<span class='error'>Veuillez sélectionner une pochette.</span><br><br>";
        $_SESSION['console'] = "<script>console.log('Veuillez sélectionner une pochette.');</script>";
    }
}


catch (PDOException $e) {
    error_log("Erreur de connexion (gestion des produits) : " . $e->getMessage());
    $_SESSION['message'] = "<span class='error'>Erreur de connexion : </span>" . $e->getMessage();
    $_SESSION['console'] = "<script>console.log('Erreur de connexion');</script>";
}   

finally {
    header('Location: manage-products.php');
}


?>
