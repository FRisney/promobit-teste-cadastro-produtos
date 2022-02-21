<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ProductNotDeletedException extends DomainRecordNotFoundException
{
    public $message = 'O produto requisitado nao pode ser apagado!';
}
