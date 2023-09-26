<?php

namespace App\Repository;

use App\Entity\UserChallenges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserChallenges>
 *
 * @method UserChallenges|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserChallenges|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserChallenges[]    findAll()
 * @method UserChallenges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserChallengesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserChallenges::class);
    }

//    /**
//     * @return UserChallenges[] Returns an array of UserChallenges objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserChallenges
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
