<?php

include(__DIR__."/Request.php");
include(__DIR__."/Response.php");
include(__DIR__."/Router.php");

class Application
{
  public static $ROOT_DIR;
  public $router;
  public $request;
  public $response;

  public function __construct($rootPath)
  {
    self::$ROOT_DIR = $rootPath;

    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
  }

  public function run()
  {
    echo $this->router->resolve();
  }
}
