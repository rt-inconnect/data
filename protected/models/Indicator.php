<?php

/**
 * This is the model class for table "indicator".
 *
 * The followings are the available columns in table 'indicator':
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $measure_ru
 * @property string $measure_en
 * @property string $color
 */
class Indicator extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'indicator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_ru, name_en', 'required'),
			array('name_ru, name_en', 'length', 'max'=>200),
			array('measure_ru, measure_en', 'length', 'max'=>100),
			array('color', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name_ru, name_en, measure_ru, measure_en, color', 'safe', 'on'=>'search'),
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
			'name_ru' => 'Name Ru',
			'name_en' => 'Name En',
			'measure_ru' => 'Measure Ru',
			'measure_en' => 'Measure En',
			'color' => 'Color',
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
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('measure_ru',$this->measure_ru,true);
		$criteria->compare('measure_en',$this->measure_en,true);
		$criteria->compare('color',$this->color,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Indicator the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function getAll()
  {
    $result = array();
    foreach ($this->findAll() as $data) {
      $result[] = H::toArray($data, array("id", "name", "measure", "name_en", "measure_en", "name_ru", "measure_ru", "color"));
    }
    return $result;
  }
}
