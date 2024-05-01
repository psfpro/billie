<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    protected EntityManagerInterface $entityManager;
    protected EntityRepository $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $metadata = $entityManager->getClassMetadata($this->getEntityClassName());
        $repositoryClassName = $entityManager->getConfiguration()->getDefaultRepositoryClassName();
        $entityRepository = new $repositoryClassName($entityManager, $metadata);
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityRepository;
    }

    abstract protected function getEntityClassName(): string;
}
