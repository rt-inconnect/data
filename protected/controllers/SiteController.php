<?php

class SiteController extends Controller
{
  public $layout='//layouts/column1';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionLogout()
  {
    Yii::app()->user->logout();
    $this->redirect(Yii::app()->homeUrl);
  }

  public function actionTemplates($template)
  {
    $this->renderPartial($template);
  }
}