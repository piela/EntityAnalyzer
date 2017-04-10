<?php

namespace TMSolution\MenuBundle\Model;

class Model {

    protected $entityManager;
    protected $filter;
    protected $paginator;

    public function __construct($entityManager, $filter, $paginator) {
        $this->entityManager = $entityManager;
        $this->filter = $filter;
        $this->paginator = $paginator;
    }

    public function find($entityClass, $request, $form) {

        $page = $request->query->getInt('page', 1);
       
        $queryBuidler = $this->entityManager->getRepository($entityClass)->createQueryBuilder('p');

        if ($form) {
            $formMethod = $form->getConfig()->getMethod();
            $queryBuilder = $this->filter->filter($form, $queryBuidler);
        }
        
        $pagination=$this->paginator->paginate($queryBuidler, $page);
        return ["items"=>$pagination->getItems(),"paginator"=>$pagination];
    }

}
