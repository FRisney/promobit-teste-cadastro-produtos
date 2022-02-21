<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Product;

use App\Domain\Entity\Product;
use App\Domain\Product\ProductNotCreatedException;
use App\Domain\Product\ProductNotDeletedException;
use App\Domain\Product\ProductNotFoundException;
use App\Domain\Product\ProductNotUpdatedException;
use App\Domain\Product\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

class DoctrineProductRepository implements ProductRepository
{
    /**
     * @var EntityManager $em
     */
    private EntityManager $em;

    /**
     * @param Product[]|null
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $a = $this->em
            ->createQueryBuilder()
            ->select('p.id','p.name')
            ->from(Product::class,'p')
            ->getQuery()
            ->execute();
        return  $a;
    }

    /**
     * {@inheritdoc}
     */
    public function findProductOfId(int $id): Product
    {
        try {
            $prod = $this->em->find(Product::class, $id);
        } catch (OptimisticLockException|TransactionRequiredException|\Doctrine\ORM\ORMException $e) {
            throw new ProductNotFoundException();
        }

        if(!$prod){
            throw new ProductNotFoundException();
        }

        return $prod;
    }

    /**
     *  {@inheritDoc}
     */
    public function new(object|array $prod): Product
    {
        $newProd = new Product();
        $newProd->setName($prod['name']);
        try {
            $this->em->persist($newProd);
            $this->em->flush();
        } catch (\Doctrine\ORM\ORMException|OptimisticLockException $e) {
            throw new ProductNotCreatedException();
        }
        return $newProd;
    }
    /**
     *  {@inheritDoc}
     * @throws ProductNotUpdatedException
     */
    public function update(int $id, object|array $newProd): Product
    {
        try {
            $prod = $this->em->find(Product::class,$id);
            if(!$prod){
                throw new ProductNotFoundException();
            }
            $prod->setName($newProd['name']);
            $this->em->persist($prod);
            $this->em->flush();
        } catch (OptimisticLockException|\Doctrine\ORM\ORMException $e) {
            throw new ProductNotUpdatedException();
        }
        return $prod;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): Product
    {
        try {
            $prod = $this->em->find($id);
            if(!$prod){
                throw new ProductNotFoundException();
            }
            $this->em->remove($prod);
            $this->em->flush();
        } catch (OptimisticLockException|TransactionRequiredException|\Doctrine\ORM\ORMException $e) {
            throw new ProductNotDeletedException();
        }
    }
}
