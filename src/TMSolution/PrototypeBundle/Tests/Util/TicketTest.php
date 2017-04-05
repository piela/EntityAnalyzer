<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use TMSolution\PrototypeBundle\Util\Ticket;
use \PHPUnit\Framework\TestCase;

/**
 * 
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/TicketTest.php
 * @author Mariusz,TomDyg
 */
class TicketTest extends TestCase {
    
   
    public static function setupBeforeClass() {
    }

    public function testGetDriver() {
 
    }

    public function testGetObject() {
        
        $ticket=new Ticket();
        $this->assertEquals('TMSolution\PrototypeBundle\Util\Ticket',$ticket->getObject());
        
    }

    public function testSetObject() {
  
    }

    public function testSetDriver() {
  
    }
    
   

}
