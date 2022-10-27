<?php

class Validator
{
  private $rules;
  private $error_messages;

  public function __construct()
  {
    $this->rules = array(
      "requiredCheck" => function ($field) {
        return $this->requiredValueCheck($field);
      },
      "integerCheck" => function ($field) {
        return $this->integerCheck($field);
      },
      "emptyFieldCheck" => function ($field) {
        return $this->emptyFieldCheck($field);
      },
      "spaceCheck" => function ($field) {
        return $this->spaceCheck($field);
      },
      
    );

    $this->error_messages = array(
      "requiredCheck" => "Please submit required data",
      "integerCheck" => "Please, provide the data of indicated type",
      "emptyFieldCheck" => "Please, ensure there are no empty fields",
      "spaceCheck" => "Please, Ensure there are no spaces in the sku field",
    );
  }

  public function validate($data, $attributes)
  {
    $error = array();
    foreach ($attributes as $key => $value) {
      $error[$key] = "";
      if (in_array("requiredCheck", $value) and array_key_exists($key, $data) == false) {
        $error[$key] = $error[$key] . $this->error_messages["requiredCheck"];
      } else if (in_array("requiredCheck", $value) and array_key_exists($key, $data) == true) {
        $error[$key] = $error[$key] . $this->validateField($data[$key], $value);
      } else {
        unset($error[$key]);
      }
    }

    $resultAsStr = implode('', $error);
    return $resultAsStr;
    
  }

  private function validateField($field, $rules)
  {
    $error = "";
    foreach ($rules as $key) {
      $valid = $this->rules[$key]($field);
      if (!$valid) {

        $error = $error . $this->error_messages[$key];
      }
    }

    return $error;
  }

  private function requiredValueCheck($field)
  {
    $valid = false;
    if ($field != null and $field != "") {
      $valid = true;
    }

    return $valid;
  }

  private function emptyFieldCheck($field)
  {
    $valid = false;
    
    if (is_string($field) and strlen($field) > 0) {
      $valid = true;
    }

    return $valid;
  }

  private function spaceCheck($field)
  {
    $valid = false;
    if (is_string($field) and preg_match("/^\S+$/", $field)) {
      $valid = true;
    }

    return $valid;
  }

  private function integerCheck($field)
  {
    $valid = false;
    if (preg_match("/^[1-9]\d*$|^[0-9]+\.[0-9]+$/", $field)) {
      $valid = true;
    }

    return $valid;
  }
}
