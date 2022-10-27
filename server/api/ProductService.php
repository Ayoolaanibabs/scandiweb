<?php
require_once __DIR__ . "/../models/ProductModel.php";

class ProductService
{
  private $productModel;

  public function __construct()
  {
    $this->productModel = new ProductModel();
  }

  // GET
  public function listAll()
  {
    $products = $this->productModel->selectAll();
    return $products;
  }

  // PUT
  public function add(Request $request)
  {

    $body = $request->getBody();
    $body = json_decode($body, true);
    if ($body == null) {
      http_response_code(500);
      return false;
    }

    foreach ($body as $key => $value) {
      if ($value === "") {
        unset($body[$key]);
      }
    }

    return $this->productModel->addProduct($body);
  }


  // DElETE
  public function massDelete(Request $request)
  {
    $body = $request->getBody();
    $body = json_decode($body, true);

    $body = $body["productList"];

    $productList = [];
    foreach ($body as $key => $value) {
      if ($value == true) {

        $productList[] = $value;
      }
    }

    return $this->productModel->delete($productList);
  }
}
