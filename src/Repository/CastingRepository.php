<?php

namespace App\Repository;

use App\Entity\Casting;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Casting>
 *
 * @method Casting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casting[]    findAll()
 * @method Casting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CastingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Casting::class);
    }

    public function add(Casting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Casting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Casting[] returns all casting for a movie
//     */
   public function findAllJoinedToPersonByMovie(Movie $movie)
   {
       //createQueryBuilder creates a new query builder instance for entity 'c' (casting)
       return $this->createQueryBuilder('c')
       // Do an inner join with the 'person' association in the casting entity
       ->innerJoin("c.person", "p")
       // Select the 'person' association with the casting entity
       ->addSelect("p")
       // Add condition to filter castings by provided movie
       ->where("c.movie = :movie")
       // Set the value of the 'movie' parameter
       ->setParameter("movie", $movie)
       // Order the castings by the 'creditOrder' property in ascending order
       ->orderBy("c.creditOrder", "ASC")
       // Get the request object
       ->getQuery()
       // Execute the query and get the result
       ->getResult();
   }

//    public function findOneBySomeField($value): ?Casting
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
