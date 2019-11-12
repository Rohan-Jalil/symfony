<?php


namespace App\Repository;


use App\Entity\Store;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class StoreRepository
 * @package App\Repository
 */
class StoreRepository extends ServiceEntityRepository
{
    /**
     * StoreRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }

    /**
     * @param Store $store
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Store $store)
    {
        $this->_em->persist($store);
        $this->_em->flush($store);
    }
}