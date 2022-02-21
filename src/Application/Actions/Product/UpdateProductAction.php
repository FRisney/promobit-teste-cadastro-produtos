<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Domain\Product\ProductNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateProductAction extends ProductAction
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
            $this->logger->notice("Product of id `$prodId` was not found.");
            return $this->respondWithData($e->getMessage(),204);
        }

        $body = $this->request->getParsedBody();

        if (!$body || $body['name'] == $prod->getName()) {
            $this->logger->notice('Request with no json attached.');
            return $this->respondWithData('no json provided',406);
        }

        $n = $this->productRepository->update($prodId,$body);

        $this->logger->info("Product of id `$prodId` was updated.");

        return $this->respondWithData($n);
    }
}
