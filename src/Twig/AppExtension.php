<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    // Tableau contenant nos filtres twig
    public function getFilters() : array {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
            new TwigFilter('dateFr', [$this, 'dateInFrenchFormat']),
        ];
    }

    public function formatPrice(int $priceInCents, int $decimals = 2) : string {
        $formattedPrice =  number_format(($priceInCents/100), 2);
        return $formattedPrice.' €';
    }

    public function dateInFrenchFormat(\DateTimeInterface $date) : string {
        return date_format($date, 'd/m/y');
    }

    // Tableau contenant nos fonctions twig
    public function getFunctions() : array {
        return [
            new TwigFunction('dateFr', [$this, 'dateInFrenchFormat']),
        ];
    }
}