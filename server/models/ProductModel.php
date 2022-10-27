<?php
include(__DIR__ . "/../api/ProductFactory.php");
include(__DIR__ . "/../api/ProductQueries.php");
include(__DIR__ . "/../core/Validator.php");
include(__DIR__ . "/../config/database.php");

class ProductModel
{
  private $db;
  private $queries;
  private $validator;
  private $factory;


  public function __construct()
  {
    $this->db = new Database();
    $this->queries = new ProductQueries();
    $this->validator = new Validator();

    $this->factory = new ProductFactory(array(
      "DVD" => DVD::class,
      "Furniture" => Furniture::class,
      "Book" => Book::class
    ));
  }
  public function selectAll()
  {
    $products = $this->db->execute($this->queries->selectAll())->fetchAll();

    $result = array();

    foreach ($products as $p) {
      $result[] = $this->factory->newProduct($p)->convert_to_dict();
    }

    return json_encode($result);
  }

  public function addProduct($dict)
  {
    $product = $this->validate($dict);
    $response = new Response();
    if (is_string($product)) {
      $response->setStatusCode(400);
      return json_encode(array("isError" => (true), "message" => $product));
    }

    $params = $product->get_parameters();

    $product = $product->convert_to_dict();


    $query = $this->queries->insert($product["type"]);
    try {
      $this->db->prepareAndExecute($query, $params);
    } catch (\Throwable $t) {
      return $t->getMessage();
    }

    $response->setStatusCode(200);
    return json_encode($product);
  }

  public function delete($idList)
  {
    $response = new Response();
    $query = $this->queries->delete();
    $inQuery = "";
    $params = array();
    foreach ($idList as $index => $value) {
      $inQuery = $inQuery . ":product" . $index . ", ";
      $params[":product" . $index] = $value;
    }

    $inQuery = substr($inQuery, 0, -2);
    $query = str_replace(":productList", $inQuery, $query);

    try {
      $this->db->prepareAndExecute($query, $params);
    } catch (\Throwable $t) {
      return $t->getMessage();
    }
    $response->setStatusCode(200);
    return json_encode(array("message" => "Mass Delete Succesful"));
  }

  private function validate($params)
  {
    $rules = $this->factory->getRules($params);
    $valid = $this->validator->validate($params, $rules);
    if ($valid != "") {
      return $valid;
    }
    // if ($valid == false) {
    //   return false;
    // }

    $query = $this->queries->exists();
    try {
      $result = $this->db->prepareAndExecute($query, array(":sku" => $params["sku"]));
    } catch (\Throwable $t) {
      return $t->getMessage();
    }

    if ($result->fetch(PDO::FETCH_NUM)[0] == 1) {
      return "sku already exists";
    }

    return $this->factory->newProduct($params);
  }
}
