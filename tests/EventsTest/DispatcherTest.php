<?php
use PHPUnit\Framework\TestCase;

use Peak\Events\Dispatcher;
use Peak\Events\EventInterface;


class DispatcherTest extends TestCase
{

    public function testAttach()
    {   
        $d = new Dispatcher();  

        $d->attach('myevent', function($argv) {
            //do something
        });

        $this->assertTrue($d->hasEvent('myevent'));
        $this->assertFalse($d->hasEvent('mysecondevent'));
    }

    public function testEventClosure()
    {   
        $d = new Dispatcher();  

        $var = 'barfoo';

        $this->assertTrue($var === 'barfoo');

        $d->attach('myevent', function($argv) use(&$var) {
            $var = $argv;
        });

        $d->fire('myevent', 'foobar');

        $this->assertTrue($var === 'foobar');
    }

    public function testMultipleFire()
    {   
        $d = new Dispatcher();  

        $int = 0;

        $d->attach('myevent', function() use(&$int) {
            ++$int;
        });
        $d->attach('myevent', function() use(&$int) {
            ++$int;
        });
        $d->attach('myevent', function() use(&$int) {
            ++$int;
        });


        $d->fire('myevent');

        $this->assertTrue($int == 3);
    }

    public function testEventsObject()
    {   
        $d = new Dispatcher();  

        /**
         * Event instance are permanent
         * @var Event1
         */
        $event1 = new Event1();

        $d->attach('myevent', $event1);

        $this->assertTrue($event1->i == 0);
        
        $d->fire('myevent');

        $d->fire('myevent');

        // direct event call
        $event1->fire(null);

        $d->fire('myevent');
        $d->fire('myevent');

        $this->assertTrue($event1->i == 5);

        $event1->fire(null);

        $this->assertTrue($event1->i == 6);
    }

    public function testClassNameObject()
    {   
        $d = new Dispatcher();  

        /**
         * Event classname have no memory
         */
        $d->attach('myevent', Event2::class);
        
        $d->fire('myevent');
        $d->fire('myevent');
        $d->fire('myevent');
        $d->fire('myevent');
    }

    public function testException()
    {
        try {
            $d = new Dispatcher();
            $d->attach('myevent', Event2::class);
            $d->attach('myevent', [1]); //invalid callback

            $d->fire('myevent'); // should trigger exception because of second callback

        } catch(Exception $e) {
            $error = true;
        }

        $this->assertTrue(isset($error));
    }
}


class Event1 implements EventInterface
{
    public $i = 0;
    public function fire($argv)
    {
        ++$this->i;
        //echo 'bob is '.$this->i.' years old';
    }
}

class Event2 implements EventInterface
{
    public $i = 0;
    public function fire($argv)
    {
        ++$this->i;
        //echo 'bob is '.$this->i.' years old';
    }
}
