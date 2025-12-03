<!-- La page d'UI nos-cinemas.php : style K&R , indentation Ok -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include_once ROOT_PATH . $meta_path; ?>
  		<title><?= $_ENV["APP_NAME"]; ?></title>
			<link href="<?= $css_path ?>" rel="stylesheet">
      <!-- Le style est intégré directement dans la page elle-même -->
  <style>
    body {
      margin: 0;      
      height: 100%;      
    }
    
    #container-maps {
      display: flex;
      height: 80vh;    
    }

    #menu-maps {
      width: 140px;
      overflow-y: auto;
      background-color: #f0f0f0;
      border-right: 1px solid #ccc;
      padding: 10px;
      padding-top: 20px;     
    }

    #menu-maps div {
      cursor: pointer;
      margin-bottom:10px;
      font-size: 12px;
    }
    #map {
      flex: 1;
      height:100%;
    }
  </style>
</head>
<body>
    <?php	  			
                   // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
              include_once ROOT_PATH . $cinemas_data_path;
              
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}

      $title = "Nos cinémas";      
    ?>
    
<!-- Partie Javascript -->
    <script>
    let map;
    let geocoder;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: { lat: 48.8566, lng: 2.3522 } // Paris par défaut
      });
      geocoder = new google.maps.Geocoder();
    }

    function showOnMap(address) {
      geocoder.geocode({ address: address }, (results, status) => {
        if (status === "OK") {
          map.setCenter(results[0].geometry.location);
          new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
          });
        } else {
          alert("Adresse non trouvée : " + status);
        }
      });
    }
  </script>
  
  <!-- On devra générer une clé API via Google Cloud Console. -->
  <script async defer
  
    src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initMap">
  </script>

    <main id="container-maps">
    <!-- Affiche une liste de cinémas (France et Belgique) -->
        <div id="menu-maps">	
        <span style="font-size:18px;font-weight:bold"><?= $title ?></span><br/><br/>
        
        <?php foreach ($cinemas as $pays => $villes): ?>
    <p style="font-size:18px;font-weight:bold;"><?= htmlspecialchars($pays) ?></p>
    
    <?php foreach ($villes as $ville => $infos): ?>
        <div style="margin-top:-6px;font-size:16px" 
             onclick="showOnMap('<?= htmlspecialchars($infos['Adresse'] . ', ' . $infos['Ville']) ?>')">
            <?= htmlspecialchars($infos['Ville']) ?>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

          <!-- Ajoutez autant d'adresses que vous voulez -->
        </div>        
        <div id="map"></div> 
  </main>
      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
</body>
</html>
