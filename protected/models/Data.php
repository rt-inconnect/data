<?php

/**
 * This is the model class for table "data".
 *
 * The followings are the available columns in table 'data':
 * @property integer $id
 * @property integer $indicator_id
 * @property integer $rayon_id
 * @property integer $year
 * @property string $val
 */
class Data extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('indicator_id, rayon_id, year, val', 'required'),
			array('indicator_id, rayon_id, year', 'numerical', 'integerOnly'=>true),
			array('val', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, indicator_id, rayon_id, year, val', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'indicator_id' => 'Indicator',
			'rayon_id' => 'Rayon',
			'year' => 'Year',
			'val' => 'Val',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('indicator_id',$this->indicator_id);
		$criteria->compare('rayon_id',$this->rayon_id);
		$criteria->compare('year',$this->year);
		$criteria->compare('val',$this->val,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Data the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function getAll($params)
  {
  	$results = array();
  	$args = ['indicator' => $params['indicator']];
    $sql = "
    	SELECT d.*
    	FROM data d
    	WHERE d.indicator_id = :indicator
    ";
    if (!empty($params['rayon'])) {
    	$args['rayon'] = $params['rayon'];
    	$sql .= ' AND d.rayon_id = :rayon';
    }
    if (!empty($params['year'])) {
    	$args['year'] = $params['year'];
    	$sql .= ' AND d.year = :year';
    }
    $results = Yii::app()->db->createCommand($sql)->queryAll(true, $args);

    return $results;
  }

  public static function onSave($data) {
    $model = Data::model()->find(
      'indicator_id = :indicator_id AND rayon_id = :rayon_id AND year = :year',
      [':indicator_id' => $data['indicator_id'], ':rayon_id' => $data['rayon_id'], ':year' => $data['year']]
    );
    if (!$model) {
      $model = new Data;
    }
    $model->attributes = $data;
    if ($model->save()) {
      return $model->attributes;
    }
    return false;
  }
}
