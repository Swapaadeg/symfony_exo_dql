<?php

namespace App\Repository;

use App\Entity\Survivant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Survivant>
 */
class SurvivantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survivant::class);
    }
    //ORDRE INVERSE ALPHABET
    public function filterZa(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nom', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    //DWARF EVERYWHERE!
    public function filterNain($name): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.race', 'r')
            ->andWhere('r.race_name = :raceName')
            ->setParameter('raceName', $name)
            ->getQuery()
            ->getResult()
        ;
    }

    //LES ELFES CHEATES
    public function filterElf25($name, $puissance): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.race', 'r')
            ->andWhere('r.race_name = :raceName')
            ->setParameter('raceName', $name)
            ->andWhere('s.puissance >= :puissance')
            ->setParameter('puissance', $puissance)
            ->getQuery()
            ->getResult()
        ;
    }

    //PAS D'HUMAINS SACHANT VISER
    public function filterArcher($name, $cname): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.race', 'r')
            ->andWhere('r.race_name != :raceName')
            ->setParameter('raceName', $name)
            ->join('s.classe', 'c')
            ->andWhere('c.class_name = :className')
            ->setParameter('className', $cname)
            ->getQuery()
            ->getResult()
        ;
    }

    //Filtre Formulaire
    public function filterForm($puissance, $race, $classe): array
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.puissance >= :puissance')
            ->setParameter('puissance', $puissance)
        ;
        if ($race != null) {
            $qb->andWhere('s.race = :race')
               ->setParameter('race', $race) ;   

        };
        if ($classe != null) {
            $qb->join('s.classe', 'c')
               ->andWhere('c IN (:classe)')
               ->setParameter('classe', $classe)
               ->groupBy('s.id')
               ->having('COUNT(DISTINCT c.id) = :nbClasse')
               ->setParameter('nbClasse', count($classe));
        };
        return $qb ->getQuery()->getResult();
    }

    // PUISSANCE DES RACES

    public function getPuissance(): array
    {
        return $this->createQueryBuilder('s')
        ->select('r.race_name as race', 'SUM(s.puissance) AS totalPuissance')
        ->join('s.race', 'r')
        ->groupBy('r.id')
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Survivant[] Returns an array of Survivant objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Survivant
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


}
