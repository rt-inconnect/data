<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

	public function init() {
		if (empty($_GET['language'])) $_GET['language'] = Yii::app()->params->defaultLanguage;
		Yii::app()->language = $_GET['language'];
		parent::init();
	}

	public function nextLanguage() {
		$result = array();
		$languages = Yii::app()->params->translatedLanguages;
		$current = Yii::app()->language;
		if ($current == 'ru') {
			$result = array(
				'id' => 'en',
				'text' => $languages['en']
			);
		}
		if ($current == 'en') {
			$result = array(
				'id' => 'ru',
				'text' => $languages['ru']
			);
		}
		return $result;
	}

}