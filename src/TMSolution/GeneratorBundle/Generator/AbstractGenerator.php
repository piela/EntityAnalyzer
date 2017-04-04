<?php

/**
 * Copyright (c) 2014, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Core\PrototypeBundle\Generator;

use Doctrine\Bundle\DoctrineBundle\Mapping\DisconnectedMetadataFactory;
use ReflectionClass;
use LogicException;
use UnexpectedValueException;

/**
 * GridConfigCommand generates widget class and his template.
 * @author Mariusz Piela <mariuszpiela@gmail.com>
 */
abstract class AbstractGenerator {

    protected $container;
    protected $shortEntityName;
    protected $entityName;
    protected $templatePath;
    protected $fileName;
    protected $rootFolder;
    protected $directory;
    protected $prefix;

    protected $parentEntity;

    public function __construct($container, $entityName, $templatePath, $fileName, $rootFolder, $prefix = null,$parentEntity = null) {

        dump("prefix");
        dump($prefix);
        $this->container = $container;
        $this->entityName = $this->noramlizeEntityName($entityName);
        $this->templatePath = $templatePath;
        $this->fileName = $fileName;
        $this->rootFolder = $rootFolder;
        $this->prefix = $this->convertPrefix($prefix);
        dump("prefix po konwersji");
        dump( $this->prefix);
        
        $this->parentEntity = $parentEntity;
    }
    
    
    protected function convertPrefix($prefix)
    {
       $prefixArr = explode("/",$prefix);
       for($i=0; $i<count($prefixArr); $i++){
           $prefixArr[$i]=  ucfirst($prefixArr[$i]);
       }
       
       return implode("\\",$prefixArr); 
        
    }

    protected function getParentEntity() {

        return $this->parentEntity;
    }

    protected function getPrefix() {

        return $this->prefix;
    }

  

    protected function getContainer() {
        return $this->container;
    }

    protected function getFileName() {
        return $this->fileName;
    }

    protected function getRootFolder() {
        return $this->rootFolder;
    }

    protected function getTemplatePath() {
        return $this->templatePath;
    }

    protected function noramlizeEntityName($entityName) {
        $doctrine = $this->getContainer()->get('doctrine');
        $entityName = str_replace('/', '\\', $entityName);

        if (($position = strpos($entityName, ':')) !== false) {
            $entityName = $doctrine->getAliasNamespace(substr($entityName, 0, $position)) . '\\' . substr($entityName, $position + 1);
        }

        return $entityName;
    }

    protected function getEntityName() {

        return $this->entityName;
    }

    protected function getFieldsInfo() {
        $model = $this->getContainer()->get("model_factory")->getModel($this->getEntityName());
        return $model->getFieldsInfo();
    }
    
    
    protected function getParentFieldsInfo() {
        $model = $this->getContainer()->get("model_factory")->getModel($this->getParentEntity());
        return $model->getFieldsInfo();
    }

    protected function getEntityShortName() {

        $entityReflection = new ReflectionClass($this->getEntityName());
        return $shortEntityName = $entityReflection->getShortName();
    }

    protected function getClassPath() {
        $manager = new DisconnectedMetadataFactory($this->getContainer()->get('doctrine'));
        $classPath = $manager->getClassMetadata($this->getEntityName())->getPath();
        return $classPath;
    }

    protected function getGridConfigNamespaceName($entityName) {

        $entityNameArr = explode("\\", str_replace("Entity", "Grid", $entityName));
        unset($entityNameArr[count($entityNameArr) - 1]);
        return implode("\\", $entityNameArr);
    }

    abstract protected function getDirectoryPath();

    protected function getDirectory() {

        if (!$this->directory) {

            $entityReflection = new ReflectionClass($this->getEntityName());
            $entityNamespace = $entityReflection->getNamespaceName();

            $directory = str_replace("\\", DIRECTORY_SEPARATOR, ($this->getClassPath() . "\\" . $entityNamespace));
           
            
            $this->directory = $this->replaceLast("Entity", $this->getDirectoryPath(), $directory);

        
            if (is_dir($this->directory) == false && mkdir($this->directory, 0777, true) == false) {
                throw new UnexpectedValueException("Creating directory failed: " . $directory);
            }
        }
        return $this->directory;
    }

    protected function calculateFileName($entityReflection) {

        $fileName = $this->replaceLast("Entity", "Grid", $entityReflection->getFileName());
        return $fileName;
    }

    protected function isFileNameBusy($fileName) {
        if (file_exists($fileName) == true) {
            throw true;
        }
        return false;
    }

    protected function replaceLast($search, $replace, $subject) {
        $position = strrpos($subject, $search);
        if ($position !== false) {
            $subject = \substr_replace($subject, $replace, $position, strlen($search));
        }
        return $subject;
    }

    protected function getAssociatedObjects($fieldsInfo) {

        $associations = [];
        foreach ($fieldsInfo as $key => $value) {

            $associationTypes = ["OneToMany", "ManyToMany", "OneToOne"];
            $field = $fieldsInfo[$key];
            if (array_key_exists("association", $field) && in_array($field["association"], $associationTypes)) {
                $associations[$key] = $field;
                $associations[$key]["object_name"] = str_replace('\\', '\\\\', $field["object_name"]);
                $associations[$key]["object_name_stripslashes"] = $field["object_name"];
            }
        }

        return $associations;
    }

    public function generate() {

        $fileName = $this->createFile();
        return $fileName;
    }

    protected function getTranslationPrefix() {


        $arr = explode("Entity", $this->getEntityName());
        //można zgrabniej, z substr
        return strtolower(str_replace("Bundle", "", str_replace("\\", ".", $arr[0])));
    }

    protected function getFormTypeName() {
        return strtolower(str_replace('\\', '_', $this->getEntityName()));
    }

    protected function getTemplateData() {

        $associations = $this->getAssociatedObjects($this->getExtendedFieldsInfo($this->getFieldsInfo()));

        $entityReflection = new ReflectionClass($this->getEntityName());
        $entityNamespace = $entityReflection->getNamespaceName();
        $entityShortName = $entityReflection->getShortName();

        $lowerNameSpaceForTranslate = str_replace('bundle.entity', '', str_replace('\\', '.', strtolower($entityNamespace)));
        return
                [
                    "entityName" => $this->getEntityName(),
                    "formTypeName" => $this->getFormTypeName(),
                    "objectName" => $entityShortName,
                    "fieldsInfo" => $this->getExtendedFieldsInfo($this->getFieldsInfo()),
                    "associations" => $associations,
                    "lowerNameSpaceForTranslate" => $lowerNameSpaceForTranslate, /*                     * @todo do wywalenia */
                    "prefix" => $this->getPrefix(),
                    "parentEntity" => $this->getParentEntity(),
                    "parentFieldsInfo" => $this->getParentEntity()? $this->getExtendedFieldsInfo($this->getParentFieldsInfo()):null,
                    "rootAddress" =>  strtolower(implode(".", explode(DIRECTORY_SEPARATOR,$this->getRootFolder()))),
                    "that" => $this, /* @todo do wywalenia */
                    "translationPrefix" => $this->getTranslationPrefix()
        ];
    }

    protected function renderFile() {

        $templating = $this->getContainer()->get('templating');
        return $templating->render($this->getTemplatePath(), $this->getTemplateData());
    }

    protected function createFile() {

        $filePath = $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getFileName();
        if ($this->isFileNameBusy($this->getFileName())) {
            new LogicException("File " . $fileName . " exists!");
            ;
        }
        file_put_contents($filePath, $this->renderFile());

        return $filePath;
    }

    protected function getExtendedFieldsInfo($fieldsInfo) {

       // $fieldsInfo = $this->getFieldsInfo();

        foreach ($fieldsInfo as $key => $value) {


            if (array_key_exists("association", $fieldsInfo[$key]) && ( $fieldsInfo[$key]["association"] == "ManyToOne" || $fieldsInfo[$key]["association"] == "OneToOne" )) {

                if ($fieldsInfo[$key]["association"] == "ManyToMany") {
                    $this->manyToManyRelationExists = true;
                }
            } elseif (array_key_exists("association", $fieldsInfo[$key]) && ( $fieldsInfo[$key]["association"] == "ManyToMany" || $fieldsInfo[$key]["association"] == "OneToMany" )) {
                //unset($fieldsInfo[$key]);
            }

            if ($fieldsInfo[$key]['is_object']) {
                $model = $this->getContainer()->get("model_factory")->getModel($fieldsInfo[$key]["object_name"]);
                if ($model->checkPropertyByName("name")) {
                    $fieldsInfo[$key]["default_field"] = "name";
                    $fieldsInfo[$key]["default_field_type"] = "Text";
                } else {
                    $fieldsInfo[$key]["default_field"] = "id";
                    $fieldsInfo[$key]["default_field_type"] = "Number";
                }
            }
        }

        return $fieldsInfo;
    }

    public function getDefaultField($entityName) {
        $model = $this->getContainer()->get("model_factory")->getModel($entityName);
        if ($model->checkPropertyByName("name")) {
            return "name";
        } else {
            return "id";
        }
    }

}
