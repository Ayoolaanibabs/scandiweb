<?php
include_once(__DIR__ . "/Product.php");

class DVD extends Product
{
  private $size;
  private static $rules = array(
    "size" => ["requiredCheck", "integerCheck"]
  );
  public function __construct($params)
  {
    parent::__construct($params["id"] ?? 0, $params["sku"], $params["name"], $params["price"], $params["type"]);
    $this->size = $params["size"];
  }

  public static function listRules()
  {
    $rules = array();
    foreach (DVD::$rules as $key => $value) {
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
      "type" => "DVD",
      "size" => $this->size,
    );
  }

  public function get_parameters()
  {
    return [
      ":size" => $this->size,
      ":sku" => $this->get_sku(),
      ":name" => $this->get_name(),
      ":price" => $this->get_price(),
    ];
  }
  public function get_size()
  {
    return $this->size;
  }

  public function set_size($size)
  {
    $this->size = $size;
  }
}
