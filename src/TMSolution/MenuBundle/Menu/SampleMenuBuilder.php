<?php

namespace TMSolution\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SampleMenuBuilder {

    protected $factory;
    protected $orm;
    protected $rootMenuItemName;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, $orm, $rootMenuItemName) {
        $this->orm = $orm;
        $this->factory = $factory;
        $this->rootMenuItemName = $rootMenuItemName;
    }

    public function createMainMenu(RequestStack $requestStack) {

        $repository = $this->orm->getRepository('TMSolution\MenuBundle\Entity\MenuItem');
        $rootMenuItem = $repository->findOneByName($this->rootMenuItemName);

        if (!$rootMenuItem) {
            throw new \Exception(sprintf('There is no root menu item: "%s"', $this->rootMenuItemName));
        }
        $menu = $this->factory->createItem('root');

        $children = $repository->childrenHierarchy($rootMenuItem);

        $this->createMenu($menu, $children);


        return $menu;
    }

    protected function createMenu($menu, $children) {

        usort($children, function($a, $b) {
            return $a['position'] - $b['position'];
        });

        foreach ($children as $child) {

            $routeParameters = [];
            if ($child['routeParameters']) {
                $routeParameters = $child['routeParameters'];
            }


            try {
                $menu->addChild($child['name'], ['route' => $child['route'],
                    'routeParameters' => $routeParameters
                ]);
            } catch (\Exception $e) {
                throw new \Exception(sprintf('Error generating for route: "%s" - %s', $child["name"], $e->getMessage()));
            }

            $this->createMenu($menu[$child['name']], $child['__children']);
        }
    }

}
