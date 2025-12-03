<?php
	include_once ROOT_PATH . '/src/View/components/pagination.php';

global $data;
global $title;

$servername = '127.0.0.1';
$username = 'root';
$password = 'admin';
			
$total_pages = 5;
$results_per_page = 12;
$current_page = 1;
$apiKey = '5c8b3c5250ee6f24237790aba7efde44';
$url_recent_movies = "https://api.themoviedb.org/3/movie/now_playing?language=fr&api_key=$apiKey";
$imageBaseUrl = "https://image.tmdb.org/t/p/w500";


// Faire une requête à l'API TMDb
		$response = file_get_contents($url_recent_movies);
		$data = json_decode($response, true);
?>