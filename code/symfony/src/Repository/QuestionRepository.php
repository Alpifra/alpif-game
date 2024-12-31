<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * Find the question by it position
     *
     * @param  int $position
     * @return Question
     */
    public function findOneByPosition(int $position): ?Question
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.position', 'ASC')
            ->where('e.position > :position')
            ->setMaxResults(1)
            ->getQuery()
            ->setParameter('position', $position)
            ->getOneOrNullResult();
    }
}
