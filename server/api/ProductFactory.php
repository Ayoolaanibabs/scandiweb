<?php

include(__DIR__ . "/../models/DVD.php");
include(__DIR__ . "/../models/Book.php");
include(__DIR__ . "/../models/Furniture.php");


class ProductFactory
{
  private $dict;

  public function __construct($objectList)
  {
    $this->dict = $objectList;
  }

  public function getRules($params)
  {
    if (array_key_exists("type", $params)) {
      return $this->dict[$params["type"]]::listRules();
    }

    return false;
  }

  public function newProduct($params)
  {
    if (array_key_exists("type", $params)) {
      return new $this->dict[$params["type"]]($params);
    }

    return false;
  }
}
