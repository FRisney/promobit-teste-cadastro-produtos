<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Domain\Product\ProductNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class ViewProductAction extends ProductAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $prodId = (int) $this->resolveArg('id');
        try {
            $prod = $this->productRepository->findProductOfId($prodId);
        } catch (ProductNotFoundException $e) {
            $this->logger->notice("Product of id `${prodId}` was not found.");
            return $this->respondWithData($e->getMessage(),204);
        }

        $this->logger->info("Product of id `$prodId` was viewed.");

        return $this->respondWithData($prod);
    }
}
