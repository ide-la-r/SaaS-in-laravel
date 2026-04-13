<?php

namespace App\Exceptions;

use Exception;

class PlanLimitExceededException extends Exception
{
    public function __construct(
        public string $feature,
        public int $limit = 0,
    ) {
        parent::__construct("Has alcanzado el límite de {$feature} de tu plan ({$limit}).");
    }

    public function render()
    {
        return back()->with('error', $this->getMessage());
    }
}
