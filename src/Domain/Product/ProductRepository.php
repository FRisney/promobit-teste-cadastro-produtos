<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Entity\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Product
     * @throws ProductNotFoundException
     */
    public function findProductOfId(int $id): Product;

    /**
     * @param object|array $prod
     * @return Product
     * @throws ProductNotCreatedException
     */
    public function new(object|array $prod): Product;

    /**
     * @param int $id
     * @param object|array $newProd
     * @return Product
     * @throws ProductNotFoundException
     * @throws ProductNotUpdatedException
     */
    public function update(int $id, object|array $newProd): Product;

    /**
     * @param int $id
     * @return Product
     * @throws ProductNotFoundException
     * @throws ProductNotDeletedException
     */
    public function delete(int $id): Product;
}
