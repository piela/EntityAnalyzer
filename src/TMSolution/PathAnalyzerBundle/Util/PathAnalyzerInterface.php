<?php
//TMSolution\PrototypeBundle\Util\PathAnalyzerInterface
namespace TMSolution\PathAnalyzerBundle\Util;

interface PathAnalyzerInterface {

        public function analyze($applicationPath,$entitiesPath,$id=null);

}
