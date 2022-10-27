<?php

class ProductQueries
{
  private $dict;

  public function __construct()
  {
    $aux = array(
      "DVD" => $this->insertDVD(),
      "Book" => $this->insertBook(),
      "Furniture" => $this->insertFurniture()
    );
    $this->dict = $aux;
  }

  public function selectAll()
  {
    return 'SELECT * FROM product;';
  }

  public function exists()
  {
    return 'SELECT EXISTS(SELECT * FROM product WHERE sku = (:sku));';
  }

  public function insert($type)
  {
    if (array_key_exists($type, $this->dict)) {
      return $this->dict[$type];
    } else {
      $response = new Response();
      $response->setStatusCode(500);
      return $response;
    }
  }

  private function insertDVD()
  {
    return "INSERT INTO product (sku, name, price, type, size) 
                VALUES (:sku, :name, :price, 'DVD', :size)";
  }
  private function insertFurniture()
  {
    return "INSERT INTO product (sku, name, price, type, height, width, length) 
                VALUES (:sku, :name, :price, 'Furniture', :height, :width, :length)";
  }
  private function insertBook()
  {
    return "INSERT INTO product (sku, name, price, type, weight) 
                VALUES (:sku, :name, :price, 'Book', :weight)";
  }

  public function delete()
  {
    return "DELETE FROM product WHERE id IN (:productList)";
  }
}
