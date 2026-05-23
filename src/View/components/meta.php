			<!-- La seule meta obligatoire pour passer le validateur w3c -->
			<meta name="viewport" content="width=device-width, initial-scale=1">
			
			<meta charset="UTF-8">
			<meta name="description" content="<?= $descriptionMeta ?>">		
			<meta name="robots" content="index, follow">

			<!-- Open Graph pour les réseaux sociaux si l'on nous a partagé -->
			<meta property="og:title" content=<?= $referencementTitle ?>>
			<meta property="og:description" content=<?= $referencementProperty ?>>
			<meta property="og:image" content=<?= $referencementImage ?>>
			<meta property="og:url" content=<?= $referencementProperty ?>>
			<meta property="og:type" content=<?= $referencementType ?>>
			
			<link rel="icon" type="image/png" href=<?= $logo_path ?>>
			<!-- La feuille de style est prête -->
			<link href="<?= $cssBase_path ?>" rel="stylesheet" media="(min-width: 1025px) and (orientation: portrait)">
			<link href="<?= $cssPhonePortrait_path ?>" rel="stylesheet" media="(max-width: 1024px) and (orientation: portrait)">
			<link href="<?= $cssBase_path ?>" rel="stylesheet" media="(min-width: 1025px) and (orientation: landscape)">
			<link href="<?= $cssPhoneLandscape_path ?>" rel="stylesheet" media="(max-width: 1024px) and (orientation: landscape)">