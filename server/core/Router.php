<?php
include(__DIR__ . "/../api/ProductService.php");
// include(__DIR__."/ProductQueries.php");

class Router
{
  public $request;
  public $response;
  protected $routes = [];

  public function __construct($request, $response)
  {
    $this->request = $request;
    $this->response = $response;
  }
  public function get($path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }
  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }
  public function delete($path, $callback)
  {
    $this->routes['delete'][$path] = $callback;
  }
  public function resolve()
  {
    $path =  $this->request->getPath();
    $method = $this->request->getMethod();
    $callback = $this->routes[$method][$path] ?? false;
    if (is_array($callback)) {
      $callback[0] = new $callback[0]();
    }
    if ($callback === false) {
      $this->response->setStatusCode(404);
      return  "Not Found!";
    }

    return call_user_func($callback, $this->request);
  }
}
