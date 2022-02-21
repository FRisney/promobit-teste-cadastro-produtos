<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ProductNotCreatedException extends DomainRecordNotFoundException
{
    public $message = 'O produto nao pode ser criado!';
}
