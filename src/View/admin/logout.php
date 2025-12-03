<?php

  // On lance une session et on détruit toutes les variables de session $_SESSION
  // ainsi que le(s) cookie(s)
  session_destroy();
  setcookie("visite", "", time() - 3600);

  $title = "Déconnexion en cours...";

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= $_ENV["APP_NAME"]; ?></title>
  <script>
    // Supprimer l'entrée 'lienActif' dans le localStorage
    localStorage.removeItem('lienActif');
    // Rediriger après un court délai pour laisser le temps au JS de s'exécuter
    setTimeout(() => {
      window.location.href = 'index.php?page=' . $confirm;
    }, 4000);
  
  localStorage.removeItem('lienActif');
  
</script>
</head>
<body>
    <div style="text-align:center;margin-top:300px">
  <span style="margin-bottom:10px;display:block"><?= $title ?></span>
  <img src="img/icons/ring.gif" alt="<?= $title ?>" width="30px" height="30px" />
</div>
</body>
</html>
