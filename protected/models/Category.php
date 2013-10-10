<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $user_id
 * @property string $name
 * @property integer $archived
 * @property string $info
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name, archived', 'required'),
			array('parent_id, user_id, archived', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, user_id, name, archived, info', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'user_id' => 'User',
			'name' => 'Name',
			'archived' => 'Archived',
			'info' => 'Info',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('archived',$this->archived);
		$criteria->compare('info',$this->info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTopParent($obj = NULL){
		if($obj === NULL) $obj = $this;
		if($obj->parent_id != NULL){
			$parent = Category::model()->findByPk($obj->parent_id);
			$this->getTopParent($parent);
		}else{
			return $obj->id;
		}
	}

	public function getChildren($obj = NULL){
		if($obj === NULL) $obj = $this;
		$children = Category::model()->findAllByAttributes(array('parent_id' => $obj->id));
		return $children;
	}

	public function addChild($name, $info, $obj = NULL){
		if($obj === NULL) $obj = $this;
		$child = new Category;
		$child->user_id = Yii::app()->user->id;
		if(count($obj) == 0)
			$child->parent_id = NULL;
		else
			$child->parent_id = $obj->id;
		$child->name = $name;
		$child->archived = 0;
		$child->info = $info;
		if($child->save() == true)
			return $child->id;
		else
			return false;
	}

	public function deleteCategory($obj = NULL){
		if($obj === NULL) $obj = $this;
		if(Yii::app()->user->id !== $obj->user_id)
			return false;
		else
			$obj->delete();
		return true;
	}
}