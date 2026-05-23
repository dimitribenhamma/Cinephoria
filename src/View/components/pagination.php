<?php

    if (!defined('ROOT_PATH')) {
		die('Accès direct interdit 🚫') ; 
	}
    
 // L'index des pages.
function pagination($totalPages,$currentPage = 1) {	
	
	$index = isset($_GET['index']) ? (int)$_GET['index'] : 1 ;    

    $page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'films' ;

        echo '<ul style="gap:10px;display:flex;justify-content:center;list-style:none;padding:0;">' ;
        for ($i = 1; $i <= $totalPages; $i++) {
            $class = ($i === $currentPage) ? 'active' : 'non-active' ;
            $href  = "index.php?page=$page&index=$i" ;
            echo "<li><a class='$class' href='$href'>$i</a></li>" ;
        }
        echo '</ul>';
    }

?>