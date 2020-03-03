<?php

namespace App\Repository;

use App\Entity\Bouquet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
/**
 * @method Bouquet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bouquet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bouquet[]    findAll()
 * @method Bouquet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BouquetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bouquet::class);
    }

    /**
     * @return Bouquet[]
     */

     public function findAllVisible(): array{
            return $this->findVisibleQuery()
                ->getQuery()
                ->getResult();
     }

   /**
     * @return Bouquet[] Returns an array of Bouquet objects
   */

    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }

    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('b')
            ->where('b.createdAt = b.createdAt');
    }
    

    

    
}
