<?php

namespace App\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;;

abstract class AbstractManager {
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;


    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    protected function validateObject(object $object): void
    {
        $errors = $this->validator->validate($object);

        foreach ($errors as $error) {
            throw new Exception($error->getMessage());
        }
    }

    /**
     * @return ObjectRepository|EntityRepository
     */
    protected function getRepository(string $class)
    {
        return $this->entityManager->getRepository($class);
    }
}
