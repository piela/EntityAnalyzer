<?php

namespace TMSolution\ModelBundle\Util;

use TMSolution\ModelBundle\Util\ModelInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model implements ModelInterface {

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function findOneById($entityClass, $id) {
        return $this->entityManager->getRepository($entityClass)->findOneById($id);
    }

    public function search($entityClass, $query) {
        return $this->entityManager->getRepository($entityClass)->findAll();
    }

    public function getRepository($entityClass) {
        return $this->entityManager->getRepository($entityClass);
    }
    
    public function getQueryBuilder($entityClass) {
        return $this->entityManager->getRepository($entityClass)->createQueryBuilder('p');
    }

    public function save($entity) {

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update() {
        $this->entityManager->flush();
    }

    public function delete($entity) {
        $this->entityManager->flush();
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

}
