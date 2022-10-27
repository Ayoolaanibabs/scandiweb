<?php
include_once(__DIR__ . "/Product.php");

class Furniture extends Product
{
  private $width;
  private $height;
  private $length;
  private static $rules = array(
    "height" => ["requiredCheck", "integerCheck"],
    "width" => ["requiredCheck", "integerCheck"],
    "length" => ["requiredCheck", "integerCheck"]
  );
  public function __construct($parameters)
  {
    $this->height = $parameters["height"];
    $this->width = $parameters["width"];
    $this->length = $parameters["length"];
    parent::__construct($parameters["id"] ?? 0, $parameters["sku"], $parameters["name"], $parameters["price"], $parameters["type"]);
  }

  public static function listRules()
  {
    $rules = array();
    foreach (Furniture::$rules as $key => $value) {
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
      "type" => "Furniture",
      "height" => $this->height,
      "width" => $this->width,
      "length" => $this->length
    );
  }

  public function get_parameters()
  {
    return [
      ":height" => $this->height,
      ":width" => $this->width,
      ":length" => $this->length,
      ":sku" => $this->get_sku(),
      ":name" => $this->get_name(),
      ":price" => $this->get_price()
    ];
  }

  public function get_width()
  {
    return $this->width;
  }

  public function set_width($width)
  {
    $this->width = $width;
  }

  public function get_height()
  {
    return $this->height;
  }

  public function set_height($height)
  {
    $this->height = $height;
  }

  public function get_length()
  {
    return $this->length;
  }

  public function set_length($length)
  {
    $this->length = $length;
  }
}
