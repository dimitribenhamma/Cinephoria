<!-- Class FilmForm.php : style K&R , indentation Ok -->
<?php

    /* On inclus les scripts nécéssaires */
    include_once ROOT_PATH . $formField_path;

class FilmForm {
    /* variables de classe */
    private array $fields = [];
    private string $action;
    private string $method;

    public function __construct(string $action, string $method = 'POST') {
        $this->action = $action;
        $this->method = strtoupper($method);
    }

    // C’est ici que l'on définit addField
    public function addField(FormField $field): void {
        $this->fields[] = $field;
    }

    /* La methode qui renvoie le formulaire avec les champs ajoutés */
    public function render(): string {
        $html = "<form action='{$this->action}' method='{$this->method}' enctype='multipart/form-data'>\n";
        foreach ($this->fields as $field) {
           
            $html .= $field->render() . "\n";
        }

         // Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
        $html .= '
                <span style="width:100px;margin-left:20px;"><label style="font-weight:bold" for="description"><?= $subtitle_description ?></label>
					<textarea id="description" rows="6" style="width:300px;height:150px;white-space: pre-wrap;" name="description" required><?= $description ?></textarea></span><br><br>
					
					<!-- checkboxes -->
					<div style="display:flex; flex-wrap:wrap; gap:10px; margin-left:20px; max-width:100%;">
    				<span style="width:100%;font-weight:bold"><?= $subtitle_type ?></span>




					<?php foreach($allGenres as $genre): ?>
					<?php $checked = in_array($genre, $typeArray) ? "checked" : ""; ?>
					<label id="<?= htmlspecialchars($genre) ?>" style="margin-right:10px;"></label>
						<input type="checkbox" name="genre[]" value="<?= htmlspecialchars($genre) ?>" <?= $checked ?>>
						<?= htmlspecialchars($genre) ?>
					<?php endforeach; ?>
					</div><br><br>
					
					<!-- radios -->
					<div style="display:flex; flex-wrap:wrap; gap:10px; margin-left:20px; max-width:100%;">
    				<span style="width:100%;font-weight:bold"><?= $subtitle_version; ?></span>
					<?php foreach($allVersions as $version): ?>
					<?php $checked = in_array($version, $versionArray) ? "checked" : "" ; ?>
					<label id="<?= htmlspecialchars($version) ?>" style="margin-right:10px;"></label>
						<input type="radio" name="version[]" value="<?= htmlspecialchars($version) ?>" <?= $checked ?>>
						<?= htmlspecialchars($version) ?>					
					<?php endforeach; ?>
					</div><br><br>

		<div style="display:flex; flex-direction:column; gap:5px; margin-left:20px; max-width:100%;">
			<span style="font-weight:bold"><?= $subtitle_forbidden; ?></span>
			<?php foreach($allAges as $ages): ?>
				<?php $checked = in_array($ages, $forbiddenArray) ? "checked" : ""; ?>
				<label id="<?= htmlspecialchars($ages) ?>"></label>
					<input type="radio" name="age" value="<?= htmlspecialchars($ages) ?>" <?= $checked ?>>
					<?= htmlspecialchars($ages) ?>				
			<?php endforeach; ?>
		</div></br></br>

					
				<!-- On prérempli les cases input si on veut modifier suite à une erreur (PHP) -->
					<!-- Img upload -->
						<span style="margin-left:20px;font-weight:bold"><?= $subtitle_image ?></span><img style="margin-left:20px" id="preview" alt="Aucune pochette (Image)" name="img" src="<?= $pochette ?>" onerror="this.src=\'img/uploads/fallback.jpg\'; this.onerror=null;" width="250px" height="300px"><br><br>
						<span style="width:100px;margin-left:20px;">
						<button id="monBouton" style="font-weight:bold;background-color:black;color:white;padding:5px;"><?= $subtitle_delete ?></button>	<!-- masque la preview -->	
						<input type="file" id="imageUpload" name="pochette" accept="image/*" <?= $id === null ? "required" : "" ?>></span>
						<button id="effacer" style="font-weight:bold;background-color:black;color:white;padding:5px;margin-left:25px;"><?= $subtitle_reset ?></button><br>							
						<br><br>
					<div>		
						<input style="margin-left:20px;margin-bottom:30px;background-color:red;color:white;padding:5px" type="submit" value="<?= (isset($id)) ? "Modifier le film" : "Ajouter le film" ?>">
					</div>';
        $html .= '<input type="submit" value="Enregistrer" style="background-color:red;color:white;padding:6px 10px;">\n';
        $html .= "</form>\n";
        return $html;
    }
}
?>

