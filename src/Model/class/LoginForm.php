<!-- Classe LoginForm.php : style K&R , indentation Ok -->
<?php
    /* On inclus les scripts de classes nécéssaires */
    include_once ROOT_PATH . $formField_path ;
    include_once ROOT_PATH . $meta_path ;
    
/* Utilisation de classe en POO */
class LoginForm {
    /* Variables de classe */
    private string $action ;
    private array $fields = [] ;
    private array $labels = [] ;

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
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'fr', 0, 2) ?? null ;
            /* On créée les données de type/champ pour chaque champ de notre formulaire */  
            // Labels , Types , Titres , Longueur min et max
            $labels = [             
                                    'titleLogin' => ($lang === 'fr') ? "Connexion" : (($lang === 'de') ? "Verbindung" : "Verbinding") ,
                                    'button' => ($lang === 'fr') ? "Démarrer" : (($lang === 'de') ? "Starten" : "Starten") ,
                                    'link' => ($lang === 'fr') ? "Mot de passe oublié" : (($lang === 'de') ? "Passwort vergessen" : "Wachtwoord vergeten") ,
                                    'error' => ($lang === 'fr') ? "Les informations ne correspondent pas. Veuillez réessayer." : (($lang === 'de') ? "Die Informationen stimmen nicht überein. Bitte versuchen Sie es erneut." : "De gegevens komen niet overeen. Probeer het opnieuw.") ,
                                    'label' => [
                                            'password' => ($lang === 'fr') ? 'Mot de passe' : (($lang === 'de') ? "Passwort" : "Wachtwoord") ,
                                            'email'    => ($lang === 'fr') ? 'E-Mail' : (($lang === 'de') ? "E-Mail" : "E-Mail")
                                        ],
                                    'title' => [
                                            'password' => ($lang === 'fr') ? 'Mot de passe' : (($lang === 'de') ? "Passwort" : "Wachtwoord") ,
                                            'email'    => ($lang === 'fr') ? 'E-Mail' : (($lang === 'de') ? "E-Mail" : "E-Mail")                                          
                                        ],
                                    'placeholder' => [
                                            'password' => ($lang === 'fr') ? 'Mot de passe' : (($lang === 'de') ? "Passwort" : "Wachtwoord") ,
                                            'email'    => ($lang === 'fr') ? 'E-Mail' : (($lang === 'de') ? "E-Mail" : "E-Mail")
                                        ],
                                    'errorTitle' => [
                                            'password' => ($lang === 'fr') ? '8 à 20 caractères, avec au moins une majuscule, une minuscule et un chiffre' : (($lang === 'de') ? '8 bis 20 Zeichen, darunter mindestens ein Großbuchstabe, ein Kleinbuchstabe und eine Zahl.' : '8 tot 20 tekens, met ten minste één hoofdletter, één kleine letter en één cijfer.') ,                                            
                                            'email'    => ($lang === 'fr') ? 'Veuillez saisir une adresse email valide (ex: nom@domaine.com)' : (($lang === 'de') ? 'Bitte geben Sie eine gültige E-Mail-Adresse ein (z. B. name@domain.com).' : 'Voer een geldig e-mailadres in (bijv. naam@domein.com)') 
                                        ],
                                    'name' => [
                                            'password' => 'password',
                                            'email'    => 'email'
                                        ],    
                                    'types' => [
                                            'password' => 'password',
                                            'email'    => 'email'
                                        ],
                                    'pattern' => [                                                                        
                                            'password' => "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,20}$",
                                            'email'    => "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
                                        ],                                    
                                    'field_min' => [
                                            'password' => 8,
                                            'email'    => 8
                                        ],
                                    'field_max' => [
                                            'password' => 20,
                                            'email'    => 30
                                    ]                                    
                    ];

            $fieldsHtml = '';
        
        $this->addField(new FormField($labels["name"]["email"], $labels["types"]["email"], $labels["pattern"]["email"], $labels["title"]["email"], $labels["field_min"]["email"], $labels["field_max"]["email"], $labels["label"]["email"], "font-size:20px;font-weight:bold;", "width:200px;height:35px;", '', $labels["placeholder"]["email"], "on")) ;
        $this->addField(new FormField($labels["name"]["password"], $labels["types"]["password"], $labels["pattern"]["password"], $labels["title"]["password"], $labels["field_min"]["password"], $labels["field_max"]["password"], $labels["label"]["password"], "font-size:20px;font-weight:bold;", "width:200px;height:35px;", '', $labels["placeholder"]["password"], "off")) ;
                               
        foreach ($this->fields as $field) {
                $fieldsHtml .= $field->render() . "<br>";
            }   

        // Prépare le message d'erreur                    
                    if (isset($_SESSION['errorLogin']) && !empty($_SESSION['errorLogin'])) {
                        $errorLoginHtml = '<div class="login-error">'
                                . $labels["error"] .
                                '</div>';                        
                        } else {$errorLoginHtml = "" ;} 

		// Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
            $form = 
            '<form method="POST" action="' . $this->action . '" class="login-form form">
                <h1 style="font-size:36px;">' . $labels['titleLogin'] . '</h1> 
                <div class="grid-login">' . $fieldsHtml .
                 $errorLoginHtml . '</div>
                <button type="submit" class="buttons-text" style="cursor: pointer;">' . $labels['button'] . '</button>
            <div style="padding-top:15px;">
            <a href="index.php?page=password"><span class="login-link"><u>' . $labels['link'] . '</u></span></a><br/>                    
        </div></form>';
                            
        return $form;
    }
}
?>