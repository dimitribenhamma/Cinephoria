<!-- La page des vignettes tmdb-main.php : Style K&R , indentation Ok -->
<?php
	include_once ROOT_PATH . $tmdb_data ;

global $title_name ;
global $title ;

global $datas ;
global $data ;

// Ajout de la logique de pagination	
		if (isset($_GET['index'])) {
			$current_page = $_GET['index'] ;}
		else {
			$current_page = 1 ;}

function limiter_chaine($chaine, $limite){
	$chaine_longue = wordwrap($chaine, $limite, "\n", true) ;
	return $chaine_longue ;
}

function supprimer_caracteres($chaine,$tableau_caracteres_a_supprimer){
	$chaine_sans_caracteres = str_replace($tableau_caracteres_a_supprimer,'',$chaine) ;
	return $chaine_sans_caracteres ;
}




function curl_details(){

// Variables déclarées et accessibles de n'importe où dans le script
	global $total_pages ;
	global $results_per_page ;

	global $url_recent_movies ;
	global $imageBaseUrl ;
	global $current_page ;
	
	
		
// Faire une requête à l'API TMDb
		$response = file_get_contents($url_recent_movies) ;
		$data = json_decode($response, true) ;				
    
	
// Ajout de la logique des résultats
		switch ($current_page){
				case '1' : $datas = array_slice($data['results'], 0, $results_per_page);break ;
				case '2' : $datas = array_slice($data['results'], 12, $results_per_page);break ;
				case '3' : $datas = array_slice($data['results'], 24, $results_per_page);break ;
				case '4' : $datas = array_slice($data['results'], 36, $results_per_page);break ;
				case '5' : $datas = array_slice($data['results'], 48, $results_per_page);break ;}


	
// Vérifier si la réponse contient des films	
		if (isset($datas) && !empty($datas)) {  
			
				foreach ($datas as $movie) {	
			
					if(isset($movie['poster_path']) || isset($movie['backdrop_path'])){
						$id = $movie['id'];
						$posterPath = isset($movie['poster_path']) ? $imageBaseUrl . $movie['poster_path'] : $imageBaseUrl . $movie['backdrop_path'] ;
						
						$title = htmlspecialchars($movie['title']) ;
						$title_before = supprimer_caracteres($title,['-','/','"',':']) ;
						$title_after = limiter_chaine($title_before, 20) ;
						

						$releaseDate = $movie['release_date'] ; 
						
					
				
				
	
// Cartes des films en grille à partir de class="vignette"				
				echo "<div>" ;
				echo "<a class='title' href='details.php?id=$id'>$title_after</a><br/>" ;
				echo "<span class='date'>Date: $releaseDate</span>" ;
				echo "<img src='$posterPath' alt='Poster' $title_after' style='width:200px;' />" ;
				echo "</div>" ;
				
				
			}	else echo 'No films found' ;
			}							
		}
	
			}
	?>			