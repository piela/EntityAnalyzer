<?php

namespace TMSolution\ModelBundle\Util;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Model {

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function findOneById($entityClass, $id) {
        return $this->orm->getManager()->getRepository($entityClass)->findOneById($id);
    }

    public function search($query) {
        return $this->orm->getManager()->getRepository($entityClass)->findOneById($id);
    }

    public function save($entity) {

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update($entityClass, $entity) {
        $this->entityManager->flush();
    }

}
