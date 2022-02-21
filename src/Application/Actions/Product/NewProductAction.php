<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use Psr\Http\Message\ResponseInterface as Response;

class NewProductAction extends ProductAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();

        if (!$body) {
            return $this->respondWithData('No json provided',406);
        }

        $prod = $this->productRepository->new($body);

        $prodId = $prod->getId();

        $this->logger->info("Product of id `$prodId` was viewed.");

        return $this->respondWithData($prod);
    }
}
