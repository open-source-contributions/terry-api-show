<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Product\Entity\Product;
use App\Product\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductDoctrineRepository extends ServiceEntityRepository implements ProductRepository
{
    private EntityManagerInterface $em;

    private Connection $connection;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
        $this->connection = $this->getEntityManager()->getConnection();
        $this->em = $this->getEntityManager();
    }

    public function nextId(): int
    {
        return (int)$this->connection->fetchColumn('SELECT setval(\'product_id_seq\', nextval(\'product_id_seq\'::regclass))');
    }

    public function saveProduct(Product $category): void
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    public function productExists(string $gtin): bool
    {
        return null !== $this->findOneBy(['gtin' => $gtin]);
    }

    public function findProduct(int $id): Product
    {
        return $this->find($id);
    }

    public function findProducts(): array
    {
        return $this->findAll();
    }
}
