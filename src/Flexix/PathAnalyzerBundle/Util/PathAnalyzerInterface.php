<?php
//Flexix\PrototypeBundle\Util\PathAnalyzerInterface
namespace Flexix\PathAnalyzerBundle\Util;

interface PathAnalyzerInterface {

        public function analyze($applicationPath,$entitiesPath,$id=null);

}
