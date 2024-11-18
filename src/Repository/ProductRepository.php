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

    /**
     * Initialise le query builder avec la fonction agrégative COUNT sur l'attribut clé primaire (aucun élément null ignoré par la fonction count)
     * @return void
     */
    private function initializeQueryBuilderWithCount(): void {
        $this->qb = $this->createQueryBuilder($this->alias)
            ->select("COUNT($this->alias.id)");
    }

    // Query builder mobilisant filtres et/ou jointures

    /**
     * QueryBuilder qui cherche tous les items contenant la chaîne passée en argument.
     * @return void
     */
    private function searchQb(string $keyword): void {
         // recherche sur le nom
        $this->orPropertyLike('name', $keyword);
        // recherche sur la description
        $this->orPropertyLike('description', $keyword);
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
            ->setParameter($propertyName, '%'.$keyword.'%');
    }

    // Recherches

    public function search(string $keyword): array {
        $this->initializeQueryBuilder();
        $this->searchQb($keyword);
        return $this->qb->getQuery()->getResult();
    }

    public function searchCount(string $keyword): int {
        $this->initializeQueryBuilderWithCount();
        $this->searchQb($keyword);

        return $this->qb->getQuery()->getSingleScalarResult(); // récupération d'un unique résultat
    }
}