<?php


namespace App\Repository;


use App\Entity\Branch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class StoreBranchRepository
 * @package App\Repository
 */
class StoreBranchRepository extends ServiceEntityRepository
{
    /**
     * StoreBranchRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Branch::class);
    }

    /**
     * @param Branch $branch
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Branch $branch)
    {
        $this->_em->persist($branch);
        $this->_em->flush($branch);
    }

    /**
     * @param Branch $branch
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Branch $branch)
    {
        $this->_em->remove($branch);
        $this->_em->flush($branch);
    }

    /**
     * @param $locations
     * @return mixed
     */
    public function getBranches($locations)
    {
        return $this->createQueryBuilder('b')
            ->andwhere('b.id IN (:ids)')
            ->setParameter('ids', array_values($locations))
            ->getQuery()
            ->getResult();
    }
}