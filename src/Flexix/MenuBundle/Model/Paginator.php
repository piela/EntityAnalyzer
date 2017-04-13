<?php

namespace Flexix\MenuBundle\Model;

class Paginator {

    protected $paginator;
    protected $limit;

    public function __construct($paginator, $limit=10) {

        $this->paginator = $paginator;
        $this->limit = $limit;
    }

    public function paginate($queryBuilder, $page, $limit = null) {

        if (!$limit) {
            $limit = $this->limit;
        }

        $pagination = $this->paginator->paginate($queryBuilder, $page, $limit);

        return  $pagination;

    }

}
