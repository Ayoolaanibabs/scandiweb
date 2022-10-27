<?php

abstract class Product
{
  private $id;
  private $sku;
  private $name;
  private $price;
  private $type;
  private static $rules = array(
    "sku" => ["requiredCheck", "emptyFieldCheck", "spaceCheck"],
    "name" => ["requiredCheck", "emptyFieldCheck"],
    "price" => ["requiredCheck", "integerCheck"],
  );

  public function __construct($id, $sku, $name, $price, $type)
  {
    $this->id = $id;
    $this->sku = $sku;
    $this->name = $name;
    $this->price = $price;
    $this->type = $type;
  }
  public abstract function convert_to_dict();

  public static function getRules()
  {
    return Product::$rules;
  }
  public function get_id()
  {
    return $this->id;
  }

  public function set_id($id)
  {
    $this->id = $id;
  }

  public function get_sku()
  {
    return $this->sku;
  }

  public function set_sku($sku)
  {
    $this->sku = $sku;
  }

  public function get_name()
  {
    return $this->name;
  }

  public function set_name($name)
  {
    $this->sku = $name;
  }

  public function get_price()
  {
    return $this->price;
  }

  public function set_price($price)
  {
    $this->price = $price;
  }

  public function get_type()
  {
    return $this->type;
  }

  public function set_type($type)
  {
    $this->type = $type;
  }
}
