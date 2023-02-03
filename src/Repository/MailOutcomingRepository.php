<?php

namespace App\Repository;

use App\Entity\MailOutcoming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MailOutcoming>
 *
 * @method MailOutcoming|null find($id, $lockMode = null, $lockVersion = null)
 * @method MailOutcoming|null findOneBy(array $criteria, array $orderBy = null)
 * @method MailOutcoming[]    findAll()
 * @method MailOutcoming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailOutcomingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailOutcoming::class);
    }

    public function save(MailOutcoming $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MailOutcoming $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MailOutcoming[] Returns an array of MailOutcoming objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MailOutcoming
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
