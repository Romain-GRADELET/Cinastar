<?php

namespace App\Repository;

use App\Entity\Casting;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
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

    public function findByMovieOrderByCreditOrderWithPerson(Movie $movie)
    {
        // 1. findBy()
        // * $castingRepository->findBy(["movie" => $movie],["creditOrder" => "ASC"]);

        // 2. Doctrine génère une requete DQL : Doctrine Query Language
        // ? https://www.doctrine-project.org/projects/doctrine-orm/en/2.14/reference/dql-doctrine-query-language.html#doctrine-query-language
        // ex : SELECT u FROM MyProject\Model\User u WHERE u.age > 20
        // * SELECT casting FROM App\Entity\Casting casting WHERE casting.movie = $movie ORDER BY casting.creditOrder ASC
        // SELECT <Alias de l'entité>
        // FROM <FQCN de l'entité> <Alias de l'entité>
        // WHERE <Alias de l'entité>.<propriété> = $valeur
        // ORDER BY <Alias de l'entité>.<propriété> <ASC/DESC>

        // * SELECT u, a FROM User u JOIN u.address a WHERE a.city = 'Berlin'"
        // JOIN <Alias de l'entité>.<propriété de jointure> <Alias de l'entité de la jointure>
        // * si on veux récupérer les entités de la jointure, il faut ajouter l'alias dans le select
        // SELECT <Alias de l'entité>, <Alias de l'entité de la jointure>

        $em = $this->getEntityManager();
        // on construit la requete DQL
        // ! Object of class App\Entity\Movie could not be converted to string
        // comme on construit une chaine de caractère, on ne peut pas donner directement l'objets
        // on passe donc par l'ID
        $movieId = $movie->getId();
        
        $query = $em->createQuery("
                SELECT casting, person
                FROM App\Entity\Casting casting 
                JOIN casting.person person
                WHERE casting.movie = $movieId
                ORDER BY casting.creditOrder ASC
            ");

        // version avec paramètre, comme requete préparées
        $queryNamedParam = $em->createQuery("
                SELECT casting, person
                FROM App\Entity\Casting casting 
                JOIN casting.person person
                WHERE casting.movie = :movieobject
                ORDER BY casting.creditOrder ASC
            ");
        // ici on peut fournir l'objet plutot que de passer par l'ID
        $queryNamedParam->setParameter('movieobject', $movie);

        // on éxécute la requete
        $result = $query->getResult();
        dd($result);
        // on reçoit un tableau d'objet Casting

        // 3. Doctrine génère le SQL
        // SELECT * FROM casting WHERE movie_id = xx ORBER BY credit_order ASC

        return $result;
    }

   /**
    * @return Casting[] Returns an array of Casting objects
    */
   public function findByExampleField(Movie $movie): array
   {
       // même chose que le DQL au dessus
       // avec l'objet de création de Query : QueryBuilder
       return $this->createQueryBuilder('c')
           ->andWhere('c.movie = :movieobject')
           ->setParameter('movieobject', $movie)
           ->orderBy('c.creditorder', 'ASC')
           ->getQuery()
           ->getResult()
       ;
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
