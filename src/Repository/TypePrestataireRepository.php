<?php

namespace App\Repository;

use App\Entity\TypePrestataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypePrestataire>
 *
 * @method TypePrestataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePrestataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePrestataire[]    findAll()
 * @method TypePrestataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePrestataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePrestataire::class);
    }

    public function save(TypePrestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypePrestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    public function findOneBySomeField($value): ?TypePrestataire
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
