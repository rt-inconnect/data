<?php

class ApiController extends Controller
{
  /* GET */
  public function actionRayons()
  {
    echo json_encode(Rayon::model()->getAll());
  }

  public function actionIndicators()
  {
    echo json_encode(Indicator::model()->getAll());
  }

  public function actionDatas()
  {
    echo json_encode(Data::model()->getAll($_GET));
  }

  /* POST */
  public function actionLogin()
  {
    $model = new LoginForm;
    $model->attributes = H::ngRequest();
    if ($model->validate() && $model->login()) echo H::ngSuccess();
  }

  public function actionIndicatorSave()
  {
    $post = H::ngRequest();
    if (!empty($post['id'])) {
      $model = Indicator::model()->findByPk($post['id']);
    } else {
      $model = new Indicator;
    }
    $model->attributes = $post;
    if ($model->save()) {
      echo json_encode(H::toArray($model, array("id", "name", "measure", "name_en", "measure_en", "name_ru", "measure_ru", "color")));
    }
  }

  public function actionDataSet()
  {
    $post = H::ngRequest();
    $model = Data::model()->onSave($post);
    if ($model) {
      echo json_encode($model);
    }
  }

  public function actionDataImport()
  {
    $results = [];
    $data = H::ngRequest();
    foreach ($data as $post) {
      $model = Data::model()->onSave((array) $post);
      if ($model) {
        $results[] = $model;
      }
    }
    echo json_encode($results);
  }

  public function actionIndicatorDelete()
  {
    $model = Indicator::model()->findByPk($_GET['id']);
    if ($model) $model->delete();
    echo H::ngSuccess();
  }

}
