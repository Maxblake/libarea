<?php

declare(strict_types=1);

namespace App\Services\Сheck;

use App\Models\FacetModel;

class FacetPresence
{
    // mixed $element (c PHP 8.0)
    public static function index($element, string $type_element = 'id', string $type = 'topic'): array
    {
        $facet = FacetModel::getFacet($element, $type_element, $type);

        notEmptyOrView404($facet);

        return $facet;
    }
}
