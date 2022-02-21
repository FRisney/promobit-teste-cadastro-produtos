<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ProductNotUpdatedException extends DomainRecordNotFoundException
{
    public $message = 'O produto requisitado nao pode ser alterado!';
}
