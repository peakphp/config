<?php

use PHPUnit\Framework\TestCase;

use Peak\Bedrock\Application;
use Peak\Bedrock\Application\Bootstrap\ConfigCustomRoutes;
use Peak\Bedrock\View;
use Peak\Bedrock\View\Render\Layouts;

class ConfigCustomRoutesTest extends TestCase
{
    /**
     * Test bootstrap class
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function testBootstrap()
    {
        $app = dummyApp();
        Application::instantiate(ConfigCustomRoutes::class); //need to call it manually because test has no bootstrap
        $kernel = Application::kernel();
        $routing = $kernel->routing;
        $this->assertTrue(count($routing->custom_routes) == 3);
        $this->assertTrue($routing->custom_routes[0]->controller === 'user');
    }
}