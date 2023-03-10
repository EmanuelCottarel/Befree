<?php

namespace App\Repository;

use App\Entity\Personnels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Personnels>
 *
 * @method Personnels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personnels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personnels[]    findAll()
 * @method Personnels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnelsRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnels::class);
    }

    public function save(Personnels $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Personnels $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Personnels) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function findByActivities()
    {
        return $this->createQueryBuilder('act')
            ->getQuery()
            ->getResult();
    }

    public function findPersonnelsForOneActivity(int $idActivity)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, a 
            FROM App\Entity\Personnels p
            INNER JOIN p.activites a
            WHERE a.id = :id'
        )->setParameter('id', $idActivity);

        return $query->getResult();
    }

    public function findAllPersonnels()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, a 
            FROM App\Entity\Personnels p
            INNER JOIN p.activites a '
        );


        return $query->getResult();
    }

    //    /**
    //     * @return Personnels[] Returns an array of Personnels objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Personnels
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
