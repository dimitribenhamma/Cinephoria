<?php
  $main_title = "404";
  $title = "Désolé, page introuvable";
  $subtitle = "La bobine est introuvable 🎬";
  $text = "Retour au menu";
  $img = "./img/nos-cinémas/chocolat.png";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>404 | <?= $_ENV["APP_NAME"]; ?></title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Arial", sans-serif;
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;  /* centre horizontalement */
      align-items: center;      /* centre verticalement */
      height: 100vh;
      color: #333;
    }

    .wrapper {
      display: flex;
      align-items: center;  /* aligne texte et image verticalement */
      gap: 50px; 
	  margin-left:20%;           /* espace entre texte et image */
    }

    .container {
      max-width: 600px;
      text-align: center;
    }

    .big-404 {
      font-size: 150px;
      font-weight: bold;
      color: #d9d9d9;
      margin: 0;
      line-height: 1;
    }

    h1 {
      font-size: 32px;
      margin: 20px 0 10px;
    }

    p {
      font-size: 18px;
      margin: 0 0 30px;
      color: #666;
    }

    .btn-404 {
      display: inline-block;
      padding: 12px 30px;
      font-size: 14px;
      text-decoration: none;
      color: white;
      background-color: #333;
      border-radius: 25px;
      transition: background 0.3s;
      text-transform: uppercase;
      font-weight: bold;
    }

    .btn-404:hover {
      background-color: #555;
    }

    .image-wrapper {
      max-height: 400px; /* ajuste la taille de l’image */
      height: auto;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="container">
      <div class="big-404">404</div>
      <h1><?= $title; ?></h1>
      <p><?= $subtitle ?></p>
      <a href="index.php?page=films" class="btn-404"><?= $text; ?></a>
    </div>

    <img class="image-wrapper" src="<?= $img; ?>" alt="Personnage" />
  </div>

			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
        
</body>
</html>