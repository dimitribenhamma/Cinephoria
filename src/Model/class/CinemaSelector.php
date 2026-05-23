<!-- Class CinemaSelector.php -->
<?php
$login = ‘SELECT id,user,email,password,role_id FROM `client` WHERE email = :email’ // Erreur de conception SQL
// Utilisation de classes
class CinemaSelector
{
    private array $cinemas;      // Toutes les données des cinémas
    private ?string $choice;      // Cinéma choisi

    public function __construct(array $cinemas, ?string $choice = null)
    {
        $this->cinemas = $cinemas;
        $this->choice = $choice ?? 'choisir';
    }

    // Retourne true si une ville est sélectionnée
    public function isSelected(string $ville): bool
    {
        return $this->choice === $ville;
    } 

    // Retourne le HTML du select
    public function renderSelect(string $name = 'cinema', string $id = 'cinemaForm'): string
    {
        $html = '<form method="POST" id="' . htmlspecialchars($id) . '">';
        $html .= '<select name="' . htmlspecialchars($name) . '" onchange="document.getElementById(\'' . htmlspecialchars($id) . '\').submit();">';
        $html .= '<option value="choisir"' . ($this->choice === 'choisir' ? ' selected' : '') . '>Choisir le cinéma</option>';

        foreach ($this->cinemas as $nomPays => $listeCinemas) {
            $html .= '<optgroup label="' . htmlspecialchars($nomPays) . '">';
            foreach ($listeCinemas as $ville => $cinema) {
                $selected = $this->isSelected($ville) ? ' selected' : '';
                $html .= '<option value="' . htmlspecialchars($ville) . '"' . $selected . '>' . htmlspecialchars($cinema['Ville']) . '</option>';
            }
            $html .= '</optgroup>';
        }

        $html .= '</select>';
        $html .= '</form>';

        return $html;
    }

    // Optionnel : récupérer les infos du cinéma choisi
    public function getChosenCinemaInfo(): ?array
{
    foreach ($this->cinemas as $pays => $listeCinemas) {
        if (isset($listeCinemas[$this->choice])) {
            return $listeCinemas[$this->choice] + ['Pays' => $pays];
        }
    }
    return null;
}
}
    ?>