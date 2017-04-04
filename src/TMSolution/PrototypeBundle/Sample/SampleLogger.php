<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//TMSolution\PrototypeBundle\Sample\SampleLogger

namespace TMSolution\PrototypeBundle\Sample;

use TMSolution\ModelBundle\Util\ModelInterface;

/**
 * Description of SampleLogger
 *
 * @author Mariusz
 */
class SampleLogger {

    //put your code here

    protected $model;

    public function __construct(ModelInterface $model) {

        $this->model = $model;
    }

    public function findOneById($entityClass, $id) {

        echo "loguję pobranie obiektu";
        return $this->model->findOneById($entityClass, $id);
    }

    public function search($entityClass, $query) {
        echo "loguję wyszukanie";
        return $this->model->search($entityClass, $query);
    }

    public function save($entity) {

        echo "loguję zapis";
        return $this->model->search($entity);
    }

    public function update() {
        echo "loguję aktualizację";
        return $this->model->update();
    }

    public function delete($entity) {
        echo "loguję usunięcie";
        return $this->model->delete($entity);
    }

}
