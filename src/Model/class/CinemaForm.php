<!-- Class Cinema.php -->
<?php

// Utilisation de classes

class CinemaForm
{
    private array $film;
    private ?string $cinemaChoice;

    public function __construct(array $film, ?string $cinemaChoice)
    	{
        $this->film = $film;
        $this->cinemaChoice = $cinemaChoice;
    }

    public function getCinemas(): array
    	{
        return array_keys($this->film['cinema']);
    }

    public function hasCinema(): bool
    	{
        return !empty($this->cinemaChoice) && $this->cinemaChoice !== 'Choisir';
    }

    public function getSchedules(): array
    	{
        if (!$this->hasCinema()) {
            return [];
        }

        return array_map(
            'trim',
            explode(',', $this->film['schedules'])
        );
    }

    public function isSelected(string $city): bool
    	{
        return $this->cinemaChoice === $city;
    }
}
    ?>