<?php

include_once(__DIR__ . "/Product.php");

class Book extends Product
{
  private $weight;

  private static $rules = array(
    "weight" => ["requiredCheck", "integerCheck"]
  );

  public function __construct($params)
  {
    parent::__construct($params["id"] ?? 0, $params["sku"], $params["name"], $params["price"], $params["type"]);
    $this->weight = $params["weight"];
  }

  public static function listRules()
  {
    $rules = array();
    foreach (Book::$rules as $key => $value) {
      $rules[$key] = $value;
    }
    foreach (parent::getRules() as $key => $value) {
      $rules[$key] = $value;
    }

    return $rules;
  }

  public function convert_to_dict()
  {
    return array(
      "id" => $this->get_id(),
      "sku" => $this->get_sku(),
      "name" => $this->get_name(),
      "price" => $this->get_price(),
      "type" => "Book",
      "weight" => $this->weight,
    );
  }

  public function get_parameters()
  {
    return [
      ":weight" => $this->weight,
      ":sku" => $this->get_sku(),
      ":name" => $this->get_name(),
      ":price" => $this->get_price()
    ];
  }

  public function get_weight()
  {
    return $this->weight;
  }

  public function set_weight($weight)
  {
    $this->weight = $weight;
  }
}
