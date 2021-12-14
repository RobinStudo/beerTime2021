<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function search($criteria)
    {
        $stmt = $this->createQueryBuilder('e');

        if(!empty($criteria['query'])){
            $stmt->leftJoin('e.place', 'p');

            $stmt->where('e.name LIKE :query');
            $stmt->orWhere('e.description LIKE :query');
            $stmt->orWhere('p.name LIKE :query');
            $stmt->setParameter('query', '%' . $criteria['query'] . '%');
        }

        if(!empty($criteria['category'])){
            $stmt->andWhere('e.category = :category');
            $stmt->setParameter('category', $criteria['category']);
        }

        return $stmt->getQuery()->getResult();
    }
}
