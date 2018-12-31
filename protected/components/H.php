<?php

class H
{

  public function p($array)
  {
    echo "<pre>";
    var_dump($array);
    die("</pre>");
  }

  public function ngSuccess()
  {
    return '{"success": true}';
  }

  public function toArray($record, $fields) {
    $translatedFields = array("name", "measure", "oblast", "rayon");
    $result = array();
    foreach ($fields as $field) {
      if (in_array($field, $translatedFields)) {
        $result[$field] = $record->{ $field . '_' . Yii::app()->language };
      } else {
        $result[$field] = $record->{ $field };
      }
    }
    return $result;
  }

  public function ngRequest()
  {
    $result = array();
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    foreach ($request as $key => $value) {
      $result[$key] = $value;
    }

    return $result;
  }

}