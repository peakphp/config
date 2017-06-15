<?php

use PHPUnit\Framework\TestCase;

use Peak\Bedrock\Application;
use Peak\Bedrock\Controller\ActionController;
use Peak\Bedrock\View;
use Peak\Routing\Route;

class ApplicationControllerTest extends TestCase
{

    protected $app;

    /**
     * Test load controller
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function testLoadController()
    {
        $app = dummyApp();
        $controller = Application::instantiate(TestController::class);
        $this->assertTrue($controller->view instanceof View);
        $this->assertTrue($controller->getTitle() === 'Test');
        $this->assertFalse($controller->isAction('index'));
    }

    /**
     * Test controller route
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function testControllerRoute()
    {
        $app = dummyApp();
        $controller = Application::instantiate(TestController::class);

        $route = new Route();
        $route->action = 'index';

        $controller->setRoute($route);

        $this->assertTrue($controller->action === '_index');
    }



}

class TestController extends ActionController
{
    public $preaction = false;
    public $postaction = false;

    public function preAction()
    {
        $this->preaction = true;
    }

    public function postAction()
    {
        $this->postaction = true;
    }
}