<?php

namespace TMSolution\MapperBundle\Generator;

use Symfony\Component\Yaml\Yaml;

class Mapper {

    protected $filePath;
    protected $manager;

    public function __construct($filePath, $manager) {
        $this->filePath = $filePath;
        $this->manager = $manager;
    }

    protected function getSnakeCase($text) {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $text)), '_');
    }
    
    protected function getDashCase($text) {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $text)), '-');
    }
    

    protected function getBundleName($entityDirectoryNamespace) {
        $entityDirectoryNamespaceArr = explode('\\', $entityDirectoryNamespace);
        unset($entityDirectoryNamespaceArr[count($entityDirectoryNamespaceArr) - 1]);
        return substr(implode($entityDirectoryNamespaceArr), 0, -6);
    }

    protected function getEntityName($entityNamespace) {
        $entityNamespaceArr = explode('\\', $entityNamespace);
        return end($entityNamespaceArr);
    }

    protected function readEntities($root) {
        $allMetadata = $this->manager->getMetadataFactory()->getAllMetadata();
        if (!array_key_exists('entities', $root['tm_solution_mapper'])) {
            $root['tm_solution_mapper']['entities'] = [];
        }
        
        if (!array_key_exists('applications', $root['tm_solution_mapper'])) {
            $root['tm_solution_mapper']['applications'] = [];
        }
        
        foreach ($allMetadata as $metadata) {
            $namespace = $this->getSnakeCase($this->getBundleName($metadata->namespace));
            if (!array_key_exists($namespace, $root['tm_solution_mapper']['entities'])) {
                $root['tm_solution_mapper']['entities'][$namespace] = [];
            }
            $entityName=$this->getEntityName($metadata->name);
            $snakeEntityName=$this->getSnakeCase($entityName);
            $root['tm_solution_mapper']['entities'][$namespace][$snakeEntityName]['alias'] = $this->getDashCase($entityName);
            $root['tm_solution_mapper']['entities'][$namespace][$snakeEntityName]['entityClass'] = $metadata->name;
        }
        $this->recursiveSort($root);
        return $root;
    }

    protected function recursiveSort(&$array) {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursiveSort($value);
            }
        }
        return ksort($array);
    }

    public function updateConfigFile() {
        $root = Yaml::parse(file_get_contents($this->filePath));
        if (!$root || !array_key_exists('tm_solution_mapper', $root) ) {
            $root['tm_solution_mapper'] = [];
        }
        $yaml = Yaml::dump($this->readEntities($root), 5);
        file_put_contents($this->filePath, $yaml);
    }

}
