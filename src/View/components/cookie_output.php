<!-- La page du cookie à insérer cookie_output.php : Style K&R , indentation Ok -->
<?php

$sth = $conn->prepare($cookie_output) ;

$sth->execute([':id' => $_SESSION['id']]) ;

$cookieData = $sth->fetch(PDO::FETCH_ASSOC) ;

if ($cookieData) {

		// Décodage JSON
		if (isset($cookieData)) {

		// Décodage colonne JSON
		if (!empty($cookieData['Events'])) {
				$cookieData['Events'] = json_decode($cookieData['Events'], true) ;
			}

		// Génération du contenu PHP
		$content = "<?php\n\nreturn " . var_export($cookieData, true) . " ;\n" ;

		// Écriture dans le fichier
		file_put_contents(ROOT_PATH . '/src/Model/data/cookies.php', $content) ;
		}
	}
?>