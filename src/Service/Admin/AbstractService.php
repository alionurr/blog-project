<?php


namespace App\Service\Admin;


use Doctrine\ORM\EntityManager;

class AbstractService
{

    /** @var EntityManager */
    protected $entityManager;

    /**
     * AbstractService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager): void
    {
        $this->entityManager = $entityManager;
    }

}