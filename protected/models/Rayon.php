<?php

/**
 * This is the model class for table "rayon".
 *
 * The followings are the available columns in table 'rayon':
 * @property string $country_id
 * @property integer $oblast_id
 * @property integer $rayon_id
 * @property string $oblast_en
 * @property string $oblast_ru
 * @property string $rayon_en
 * @property string $rayon_ru
 * @property string $geometry
 * @property string $createdAt
 * @property string $updatedAt
 */
class Rayon extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rayon';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, oblast_id, rayon_id, oblast_en, oblast_ru, rayon_en, rayon_ru, geometry', 'required'),
			array('oblast_id, rayon_id', 'numerical', 'integerOnly'=>true),
			array('country_id', 'length', 'max'=>10),
			array('oblast_en, oblast_ru, rayon_en, rayon_ru', 'length', 'max'=>200),
			array('createdAt, updatedAt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('country_id, oblast_id, rayon_id, oblast_en, oblast_ru, rayon_en, rayon_ru, geometry, createdAt, updatedAt', 'safe', 'on'=>'search'),
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
			'country_id' => 'Country',
			'oblast_id' => 'Oblast',
			'rayon_id' => 'Rayon',
			'oblast_en' => 'Oblast En',
			'oblast_ru' => 'Oblast Ru',
			'rayon_en' => 'Rayon En',
			'rayon_ru' => 'Rayon Ru',
			'geometry' => 'Geometry',
			'createdAt' => 'Created At',
			'updatedAt' => 'Updated At',
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

		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('oblast_id',$this->oblast_id);
		$criteria->compare('rayon_id',$this->rayon_id);
		$criteria->compare('oblast_en',$this->oblast_en,true);
		$criteria->compare('oblast_ru',$this->oblast_ru,true);
		$criteria->compare('rayon_en',$this->rayon_en,true);
		$criteria->compare('rayon_ru',$this->rayon_ru,true);
		$criteria->compare('geometry',$this->geometry,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('updatedAt',$this->updatedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rayon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

  public function getAll()
  {
    $result = array();
    foreach ($this->findAll() as $data) {
      $result[] = H::toArray($data, array("country_id", "oblast_id", "rayon_id", "oblast", "rayon", "geometry"));
    }
    return $result;
  }
}
