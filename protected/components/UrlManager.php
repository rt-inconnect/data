<?php

class UrlManager extends CUrlManager
{
  public function createUrl($route, $params=array(), $ampersand='&')
  {
    if (empty($params['language']) && Yii::app()->language !== 'ru') {
      $params['language'] = Yii::app()->language;
    }
    return parent::createUrl($route, $params, $ampersand);
  }
}