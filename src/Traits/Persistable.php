<?php
declare(strict_types=1);

namespace App\Traits;

trait Persistable
{
    private ?int $id = 0;

    public function isPresent(): bool
    {
        return $this->id > 0;
    }
}
