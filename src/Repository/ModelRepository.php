<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    /** findModelkitPng
     * @return Query
     */
    public function findModelkitPng($name): Query
    {
        $sql = "
            SELECT
                partial e.{id, name, description, price, filename},
                partial ljim.{id, path},
                partial ljca.{id, name}
            FROM App\Entity\Model e
            LEFT JOIN e.images ljim
            LEFT JOIN e.categories ljca
            WHERE ljca.name =:name
            ORDER BY e.name ASC
        ";
        $aParameter = ['name' => strtolower($name),];
        return $this->getEntityManager()->createQuery($sql)->setParameters($aParameter);
    }

    /**
     * @return Model[] Returns an array of Last Model objects
     */
    public function findAllModelkit(): array
    {
        return $this -> createQueryBuilder( 'p' )-> getQuery()-> getResult();
    }
}
