<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Summary;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class SummaryRepository extends EntityRepository
{
    public function createQueryBuilderForAdherent(Adherent $adherent): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->where('s.member = :member')
            ->setParameter('member', $adherent)
        ;
    }

    public function findOneForAdherent(Adherent $adherent): ?Summary
    {
        return $this->createQueryBuilderForAdherent($adherent)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneBySlug(string $slug): ?Summary
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'm', 'mt', 'e', 'sk', 'l', 't')
            ->leftJoin('s.member', 'm')
            ->leftJoin('s.missionTypeWishes', 'mt')
            ->leftJoin('s.experiences', 'e')
            ->leftJoin('s.skills', 'sk')
            ->leftJoin('s.languages', 'l')
            ->leftJoin('s.trainings', 't')
            ->where('s.slug = :slug')
            ->andWhere('s.public = :public')
            ->setParameter('slug', $slug)
            ->setParameter('public', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
