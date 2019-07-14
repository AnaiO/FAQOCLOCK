<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @return Answer[] Returns an array of Answer objects
     *
    */
    // public function findByQuestion($question)
    // {
    //     return $this->createQueryBuilder('a')
    //         ->andWhere('a.question = :val')
    //         ->setParameter('val', $question)
    //         ->orderBy('a.id DESC, a.status DESC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    

    
    /**
     * 
     * @param Question $question
     * @return Answer[]
     */
    public function findByQuestion($question)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT a 
            FROM App\Entity\Answer a
            WHERE a.question = :question
            ORDER BY a.status DESC, a.id DESC 
        ')
        ->setParameter('question', $question);
        return $query->getResult(); 
    }
    
}
