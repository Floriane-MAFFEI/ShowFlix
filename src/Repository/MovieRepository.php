<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Movie[] Returns an array of Movie objects by title
    //     */
    public function findAllOrderByTitleSearch($search = null): array
    {
        // Creates a query builder instance and assigns the alias 'm' to the Movie entity.
        return $this->createQueryBuilder('m')

            // Specifies that the movies should be ordered by the 'title' field in ascending order.
            ->orderBy('m.title', 'ASC')
            // Adds a WHERE clause to the query, filtering movies based on the 'title' field using the LIKE operator.
            ->where("m.title LIKE :search")
            // Binds the search parameter value to the ':search' placeholder in the query, ensuring proper
            // sanitization and preventing SQL injection.
            ->setParameter("search", "%" . $search . "%")
            // Retrieves the Query object from the query builder.
            ->getQuery()
            // Executes the query and returns an array of movie entities that match the search criteria.
            ->getResult();
    }

    //    /**
    //     * @return Movie[] Returns an array of Movie objects by date
    //     */
    public function findAllOrderByDate(): array
    {
        // Creates a query builder instance and assigns the alias 'm' to the Movie entity.
        return $this->createQueryBuilder('m')
            //Specifies that the movies should be ordered by the 'releaseDate' field in descending order, meaning the most recent movies will be returned first.
            ->orderBy('m.releaseDate', 'DESC')
            // Limits the number of results to 10. Only the top 10 movies based on the ordering will be returned.
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findRandomMovie()
    {
        // Get the database connection
        $conn = $this->getEntityManager()->getConnection();

        // SQL query to select a random movie
        $sql = 'SELECT * FROM movie ORDER BY RAND() LIMIT 1';

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // Return the fetched result as an associative array
        return $resultSet->fetchAssociative();
    }
}
