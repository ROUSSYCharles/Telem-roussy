<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    private QueryBuilder $qb;
    private string $alias = 'pdt';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    /**
     * Initialisation d'un querybuilder courant
     * @return QueryBuilder
     */
    private function initializeQueryBuilder(): void {
        $this->qb = $this->createQueryBuilder($this->alias)
        ->select($this->alias);
    }

    // Filtres

    /**
     * Recherche le mot clé passé en argument dans la propriété Name
     * @param string $keyword
     * @return QueryBuilder
     */
    private function orNameLike(string $keyword): void {
        $this->qb->orWhere("$this->alias.name LIKE :name")
                ->setParameter('name', '%'.$keyword.'%');
    }

    /**
     * Recherche le mot clé passé en argument dans la propriété description
     * @param string $keyword
     * @return QueryBuilder
     */
    private function orDescriptionLike(string $keyword): void {
        $this->qb->orWhere("$this->alias.description LIKE :description")
                ->setParameter('description', '%'.$keyword.'%');
    }


    /**
     * Filtre générique sur une propriété donnée
     * @param string $propertyName
     * @param string $keyword
     * @return void
     */
    private function orPropertyLike(string $propertyName, string $keyword): void {
        $this->qb->orWhere("$this->alias.$propertyName LIKE :$propertyName")
            ->setParameter('$propertyName', '%'.$keyword.'%');
    }

    // Recherche

    public function search(string $keyword): array {
        $this->initializeQueryBuilder();
        // recherche sur le nom
        $this->orPropertyLike('name', $keyword);
        // recherche sur la description
        $this->orPropertyLike('description', $keyword);

        return $this->qb->getQuery()->getResult();
    }
}