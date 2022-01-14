<?php

namespace App\Repository;

use App\Entity\Chatroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chatroom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chatroom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chatroom[]    findAll()
 * @method Chatroom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatroomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chatroom::class);
    }



    public function getParticipants()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.participants', 'participant')
            ->where('c.id = :id')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Chatroom
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
