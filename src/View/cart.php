<!-- La Page d'UI cart.php : style K&R , indentation Ok -->
<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	
	include_once ROOT_PATH . $paymentForm_path ;
	include_once ROOT_PATH . $moviesData_path ;
	
		$price_seat = 14;
		$count = 0;
		$selectedSeats = trim(filter_input(INPUT_POST, 'selected_seats', FILTER_UNSAFE_RAW) ?? '');
		$capacity = trim(filter_input(INPUT_POST, 'capacity', FILTER_UNSAFE_RAW) ?? '');

		if ($selectedSeats !== '') {
			$array = explode(',', $selectedSeats);
			$count = count($array);
		}
		else {
			error_log("Aucun siège dans le panier actif : " . getUserIP());
			header("Location: index.php?page=$showName");
			exit("Aucun siège séléctionnés dans le panier");
		}

		if ($count !== ($_SESSION['sum'] / $price_seat)) {				
			error_log("Le prix n'est pas respecté au nombre de sièges : " . getUserIP());
			header("Location: index.php?page=$showName");
			exit("Aucun siège séléctionnés dans le panier");
		}

		$selectedSeatsArray = array_map('intval', explode(',', $selectedSeats));

		if (($count < 1) || ($count > $capacity)) {
			error_log("Nombre de sièges incohérent : " . getUserIP());
			header("Location: index.php?page=$showName");
			exit("Nombre de sièges incohérent");
		}

		$_SESSION['selected_seats_array'] = $selectedSeatsArray;
		$_SESSION['selected_seats'] = implode(' - ', $selectedSeatsArray);

	$cartPayment = $cartPayment ?? [];
	$cartCurrent = array("sum" => $_SESSION['sum'], "seats" => $count, 'movie_id' => $_SESSION['movie_id'], 
	"selected_seats" => $_SESSION['selected_seats'], "cinema" => $_SESSION['cinema'], "room" => $_SESSION['salle'], 
	"time" => $_SESSION['horaire']);

	$cartPayment[] = $cartCurrent;

?>
<!DOCTYPE html> 
<html lang="fr">
  	<head>
			<title><?= $_ENV["APP_NAME"]; ?></title>			
	</head>
	<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if ($roleCustomer) {		  			
              include_once ROOT_PATH . $menuAdmin_path ;
          }		
	
			/* On inclus les scripts nécéssaires */
			include_once ROOT_PATH . $paymentForm_path ;
	?>	
<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
<main style="display:flex;flex:1;width:100%;margin-bottom:80px;margin-top:60px;flex-direction:column;">
	            <!-- On y applique nos classes -->
            <?php
			$totalSeats = 0;
			$totalSum = 0;
				foreach ($cartPayment as $cart) {
					$totalSeats += $cart['seats'];
					$totalSum += $cart['sum'];
				}
			echo "<div style='width:80%;padding:1% 10%;margin-bottom:10px;background-color:rgb(246,238,225);font-weight:bold;'>";

			echo "<div style='font-size:26px;text-align:left;'>Votre panier</div>";

			echo "<div style='display:flex;justify-content:space-between;'>";
			echo "<span>Total " . $totalSeats . " place(s)</span>";
			echo "<span>" . $totalSum . " €</span>";
			echo "</div>";

			echo "</div>";
			echo "<div style='display:flex;justify-content:flex-end;margin-bottom:30px;padding:0 5%;color:white;'><button class='btn-cart'><a href='index.php?page=payment' class='btn-cart'>
        Valider
    </a></button></div>";

				foreach($cartPayment as $cart) {
					echo "<div style='width:50%;border:1px solid black;display:flex;margin:auto'>";

					echo "<img src='" . $films[$cart['movie_id'] - 1]['pochette'] . "'
							alt='" . htmlspecialchars($films[$cart['movie_id'] - 1]['titre']) . "'
							height='250'
							width='200' />";

					echo "<div style='display:flex;flex-direction:column;margin-left:15px;'>";
					echo "<span>" . $films[$cart['movie_id'] - 1]['titre'] . "</span>";
					echo "<span>&nbsp;</span>";
					echo "<span>" . $cart['seats'] . " place(s)</span>";
					echo "<span>Siège(s) : " . implode(' - ', $selectedSeatsArray) . "</span>";
					echo "</div>";

					echo "<div style='display:flex;flex-direction:column;margin-left:auto;align-items:flex-end;margin-right:15px;'>";
					echo "<span>&nbsp;</span>";					
					echo "<span>" . $cart['sum'] . " €</span>";
					echo "</div>";

					echo "</div>";
				}
			echo '</div>';
                ?> 
</main>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>					
			
			</div>
  </body>
</html>