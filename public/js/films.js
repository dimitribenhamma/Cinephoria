// Rediriger après un court délai pour laisser le temps au JS de s'exécuter

setTimeout(() => {
		window.location.href = 'index.php?page=<?= $page_confirm ?>';
	}, 4000);