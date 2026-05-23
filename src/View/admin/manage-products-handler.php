<!-- La page UI du site manage-products-handler.php : Style K&R , indentation Ok -->
<?php

	    if (session_status() === PHP_SESSION_NONE) {
    	  	session_start() ;}

            /* Fichier à inclure */
            include_once ROOT_PATH . $movies_data_path; // DataFile films
            include_once ROOT_PATH . $ip_path ; // La date en français


    try {                                         

        /*  */
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['titre'],$_POST['description'],$_POST['auteur'],$_POST['duree'],$_FILES['pochette'],$_POST['movie_release_date'],$_POST['cinema']) && !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['auteur']) && !empty($_POST['duree']) && ($_FILES['pochette']['error'] === 0) && !empty($_POST['movie_release_date']) && !empty($_POST['cinema'])) {    

            // Récupération des données du formulaire
            $title = $_POST['titre'];
            $subtitle = $_POST['subtitle'] ?? "null";   
            $description = $_POST['description'];
            $movie_release_date = $_POST['movie_release_date'];
            $duree = $_POST['duree'];
            $auteur = $_POST['auteur'];
            $pochette = $_FILES['pochette'] ?? '❌';
            $forbidden = $_POST['age'];
            $version = $_POST['version'];
            $genre = $_POST['genre'];
   
        /* On sépare la logique ici */

            /* Traitement de l'image (pochette) */

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

                // Détecter le vrai type du fichier
                $fileTmp = $_FILES['pochette']['tmp_name'];
                $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $fileMime = mime_content_type($fileTmp);

                // L'upload n'est pas dans la liste autorisée des types MIME
                if (!in_array($fileMime, $allowedMimeTypes)) {
                    $_SESSION['ErrorForm'] = "<span class='error'>$textErrorMimeFile</span><br><br>";
                    header("Location: $manageProductsPage.php");
                    exit('Type de fichier non autorisé.');
                }

                // L'Upload est dans la liste autorisée des types extensions
                if (in_array($fileExtension, $allowedExtensions)) {

                        // L'image dépasse la taille maximum (2Mo)
                        if ($_FILES['pochette']['size'] > $maxSize) {
                            ?>
                                <script>console.log("Film ajouté avec succès!");</script>
                            <?php
                            $_SESSION['ErrorForm'] = "<p style='color:red'>$errorSizeFile</p>";
                            header("Location: $manageProductsPage.php");
                            exit("Taille maximum (2Mo) dépassée.");
                        }

                        // Déplacer l'image (pochette) vers le dossier "uploads"
                        elseif (move_uploaded_file($fileTmp, $uploadFile)) {

            /* Insérer le nouveau tableau ajouté dans le DataFile */

                            $nouvelleLigne = ["id" => count($films) + 1, "titre" => $_POST['titre'], 'subtitle' => $_POST['subtitle'], "description" => $_POST['description'], "auteur" => $_POST['auteur'], "duree" => $_POST['duree'], 'version' => $version, 'interdit' => $forbidden, 'genre' => $genre, "created_at" => date_fr(), "date_de_sortie" => date_movie_release($movie_release_date), "pochette" => $uploadFile];

                            // Ajouter la ligne au tableau 2D
                            $films[] = $nouvelleLigne;

                            // Convertir en code PHP
                            $contenu = "<?php\n\n\$films = " . var_export($films, true) . ";\n";

                            // Réécrire le DataFile nouvelle version
                            file_put_contents('../data/movies.php', $contenu);   
                            
            /* Messages en console */
                        ?>
                            <script>console.log("<?= $textSuccessFilm ; ?>");</script>
                        <?php
                    $_SESSION['ErrorForm'] = "<span class='success'>$textSuccessFilm</span><br><br>";
                    $_SESSION['console'] = "<script>console.log('$textSuccessFilm');</script>";

                    
                            }
                        // Erreur lors de l'ajout du film
                        else {
                        ?>
                            <script>console.log("<?= $textErrorMoveUploads ; ?>");</script>
                        <?php
                    $_SESSION['ErrorForm'] = "<span class='error'>$textErrorMoveUploads</span><br><br>";
                    // $_SESSION['console'] = "<script>console.log('$textErrorMoveUploads');</script>";
                        }
                    }
                
                // L'Upload n'est pas dans la liste autorisée des types extensions MIME
                else {
                        ?>
                        <script>console.log("<?= $textErrorMimeFile ; ?>");</script>
                    <?php
                $_SESSION['ErrorForm'] = "<span class='error'>$textErrorMimeFile</span><br><br>";
                // $_SESSION['console'] = "<script>console.log('$textErrorMimeFile');</script>";
                }
                }
            // Format d'image non autorisé
            else {
                    ?>
                        <script>console.log("<?= $textErrorExtensionFile ; ?>");</script>
                    <?php
                $_SESSION['ErrorForm'] = "<span class='error'>$textErrorExtensionFile</span><br><br>";
                // $_SESSION['console'] = "<script>console.log('$textErrorExtension');</script>";
            }
            } 
        // Sélectionner des données complètes.
        else {
                ?>
                    <script>console.log("<?= $textMissingInputFilm ; ?>");</script>
                <?php
                $_SESSION['ErrorForm'] = "<span class='error'>$textMissingInputFilm</span><br><br>";
                // $_SESSION['console'] = "<script>console.log('$textMissingInputFilm');</script>";
        }
    }

    catch (PDOException $e) {
        error_log("[$manageProductsPage] $manageProductsException : " . $e->getMessage());
        $_SESSION['ErrorForm'] = "<span class='error'>$manageProductsException : </span>" . $e->getMessage();
        // $_SESSION['console'] = "<script>console.log('$manageProductsException');</script>";
    }   


    finally {
        header("Location: index.php?page=$manageProductsPage");
    }


?>
