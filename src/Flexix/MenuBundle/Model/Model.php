<?php

namespace Flexix\MenuBundle\Model;

class Model {

    protected $model;
    protected $filter;
    protected $paginator;

    public function __construct($model, $filter, $paginator) {
        $this->model = $model;
        $this->filter = $filter;
        $this->paginator = $paginator;
    }

    public function find($entityClass, $request, $form) {

        $page = $request->query->getInt('page', 1);
       
        $queryBuidler = $this->model->getQueryBuilder($entityClass);

        if ($form) {
            $formMethod = $form->getConfig()->getMethod();
            $queryBuilder = $this->filter->filter($form, $queryBuidler);
        }
        
        $pagination=$this->paginator->paginate($queryBuidler, $page);
        return $pagination;
    }

}
