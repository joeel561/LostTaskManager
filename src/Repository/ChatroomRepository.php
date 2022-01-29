<?php

namespace App\Repository;

use App\Entity\Chatroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

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


 
    public function getChatrooms(User $sender, User $receiver)
    {
        return $this->createQueryBuilder('c')
            ->where(':sender MEMBER OF c.participants')
            ->andWhere(':receiver MEMBER OF c.participants')
            ->setParameters(array('sender' => $sender, 'receiver' => $receiver))
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
 

    public function getSenderChatrooms(User $sender)
    {
        return $this->createQueryBuilder('c')
            ->where(':sender MEMBER OF c.participants')
            ->setParameters(array('sender' => $sender))
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
