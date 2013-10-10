<?php

/**
 * This is the model class for table "practice_settings".
 *
 * The followings are the available columns in table 'practice_settings':
 * @property integer $id
 * @property integer $target_timestamp
 * @property integer $infinite
 * @property integer $target_percentage
 */
class PracticeSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PracticeSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'practice_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('infinite, target_percentage', 'required'),
			array('target_timestamp, infinite, target_percentage', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, target_timestamp, infinite, target_percentage', 'safe', 'on'=>'search'),
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
			'target_timestamp' => 'Target Timestamp',
			'infinite' => 'Infinite',
			'target_percentage' => 'Target Percentage',
		);
	}

}