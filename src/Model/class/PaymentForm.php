<!-- Class FilmForm.php : style K&R , indentation Ok -->
<?php

    /* On inclus les scripts nécéssaires */
    include_once ROOT_PATH . $formField_path;

class PaymentForm {
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
        $sum = $_SESSION['sum'] ?? '' ;
		$title = "Paiement" ;
        $text_button = "Payer " . $sum ;    
        $error = "Une erreur est survenue , veuillez réessayer" ;
        $fieldsHtml = '' ;
        $formStyle = "display:flex; flex-direction:column; align-items:center" ;
        $errorStyle = "font-size:16px;padding-top:5px;padding-bottom:15px;color:red";
		
		
		
        foreach ($this->fields as $field) {
           
            $htmlFields .= $field->render() . "\n";
        }

         // Prépare le formulaire de retour (on n'utilise pas de syntaxe heredoc ici)
        $html = '
                <form method="' . $this->method . '" action="' . $this->action . '" style="' . $formStyle . '" id="paymentForm">
                    <h2 style="font-size:36px">' . $title . '</h2>
                    ' . $htmlFields . '
                    <input type="submit" id="payButton" value="Payer ' . htmlspecialchars($sum) . '" style="background-color:red;color:white;padding:6px 10px;opacity:0.5;cursor:not-allowed" disabled>
                </form>';

        return $html;
    }
}
?>

