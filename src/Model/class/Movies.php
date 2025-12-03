<!-- Class Movies.php -->

<?php 
// Utilisation de classes
// Séparation nette des responsabilités et réutiliser pour d’autres pages.

    class Movies {
        
        private array $films;
        private int $perPage;

        public function __construct(array $films, int $perPage = 8) {
            $this->films = $films;
            $this->perPage = $perPage;
        }

        public function getTotalPages(): int {
            return ceil(count($this->films) / $this->perPage);
        }

        public function getPage(int $page = 1): array {
            if ($page < 1) $page = 1;
            $totalPages = $this->getTotalPages();
            if ($page > $totalPages) $page = $totalPages;

            $start = ($page - 1) * $this->perPage;
            return array_slice($this->films, $start, $this->perPage);
        }

        public function renderMovieCard(array $film): string {
            $subtitle = isset($film['subtitle']) ? htmlspecialchars($film['subtitle']) : '';
            return "
            <div class='movie'>
                <a class='title' href='index.php?page=details&id={$film['id']}'>
                    <img src='{$film['pochette']}' alt='" . htmlspecialchars($film['titre']) . "' height='300px' width='250px'>
                </a>
                <h3 style='margin-top:2%'>" . htmlspecialchars($film['titre']) . "</h3>
                <p style='margin-top:-3%;" . ($subtitle ? 'margin-bottom:-8px' : '') . "'>$subtitle</p>
            </div>";
        }

        public function renderMoviesPage(int $page): string {
            // Récupère la page de films
            $filmsPage = $this->getPage($page);            
            $html = "<div class='movies'>";
            foreach ($filmsPage as $film) {
                $html .= $this->renderMovieCard($film);
            }
            $html .= "</div>";
            return $html;
        }

        // Rechercher des films par titre
    public function searchByTitle(string $query): array {
        $query = strtolower(trim($query));
        if ($query === '') return [];

        return array_filter($this->films, function($film) use ($query) {
            return strpos(strtolower($film['titre']), $query) !== false;
        });
    }

    // Rendu des résultats de recherche
    public function renderSearchResults(string $query): string {
        $results = $this->searchByTitle($query);
        if (empty($results)) {
            return "<p><em>Aucun film trouvé pour '$query'</em></p>";
        }

        $html = "<div class='movies-search'>";
        foreach ($results as $film) {
            $html .= $this->renderMovieCard($film);
        }    
            $html .= "</div>";
        return $html;
    }
}
?>