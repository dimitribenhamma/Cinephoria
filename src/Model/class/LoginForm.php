<!-- Classe LoginForm.php : style K&R , indentation Ok -->

<?php
/* On créée les données de type/champ de notre formulaire */  
// Labels pour chaque champ
$labels = [
    'password' => 'Mot de passe',
    'email'    => 'Email'
];

// Types pour chaque champ
$field_types = [
    'password' => 'password',
    'email'    => 'email'
];

// Motifs pour chaque champ
$field_pattern = [
    'password' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,20}$',
    'email'    => '.{5,30}'
];
// Titres pour chaque champ
$field_title = [
    'password' => '8 à 20 caractères, avec au moins une majuscule, une minuscule et un chiffre',
    'email'    => 'Veuillez saisir une adresse email valide (ex: nom@domaine.com)'
];

// Longueur min pour chaque type
$field_min = [
    'password' => 8,
    'email'    => 8
];

// Longueur max pour chaque type
$field_max = [
    'password' => 20,
    'email'    => 254
];


    /* On inclus les scripts nécéssaires */
    include_once ROOT_PATH . $formField_path;
    
/* Utilisation de classe en POO */
class LoginForm {
    /* Variables de classe */
    private string $action;
    private array $fields = [];

    /* Constructeur d'objet */
    public function __construct(string $action) {
        $this->action = $action;
    }

    /* La methode qui ajoute un champ de formulaire à la variable de tableau $fields[] */
    public function addField(FormField $field): void {
        $this->fields[] = $field;
    }

    /* La methode qui renvoie le formulaire avec les champs ajoutés */
    public function render(): string {
        $title = "Connexion";
        $text_button = "Démarrer";    
        $text_link = "Mot de passe oublié";
        $error = "Une erreur est survenue , veuillez réessayer";
        $fieldsHtml = '';
        $formStyle = "display:flex; flex-direction:column; align-items:center";
        $errorStyle = "font-size:16px;padding-top:5px;padding-bottom:15px;color:red";
        $linkStyle = "font-size:20px;font-weight:bold;";        

        foreach ($this->fields as $field) {
            $fieldsHtml .= $field->render() . "<br>";
        }

        // Prépare le message d'erreur
                    $errorHtml = '';
                    if (isset($_SESSION['errorLogin']) && $_SESSION['errorLogin'] === true) {
                        $errorHtml = '<div style=' . $errorStyle . '>'
                                . $error .
                                '</div>';                        
                        }

		// Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
            $form = 
            '<form method="POST" action="' . $this->action . '" style="' . $formStyle . '" class="form">
                <h2 style="font-size:36px">' . $title . '</h2>' . 
                $fieldsHtml .
                $errorHtml .
                '<button type="submit" class="buttons-text" style="cursor: pointer;">' . $text_button . '</button>
            <div style="padding-top:15px;padding-bottom:25px">
            <a href="index.php?page=password"><span style=' . $linkStyle . '><u>' . $text_link . '</u></span></a><br/>                    
        </div></form>';
                            
        return $form;
    }
}
?>