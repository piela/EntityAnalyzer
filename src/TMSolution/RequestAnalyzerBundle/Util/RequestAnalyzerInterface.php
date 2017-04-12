<?php
//TMSolution\PrototypeBundle\Util\RequestAnalyzerInterface
namespace TMSolution\RequestAnalyzerBundle\Util;

interface RequestAnalyzerInterface {

        public function analyze($applicationPath,$entitiesPath,$id=null);

}
