<?php

/**
 * This is the model class for table "user_action_log".
 *
 * The followings are the available columns in table 'user_action_log':
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property integer $timestamp
 * @property string $target
 * @property string $target_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
define( 'L_MINDMAP_DOCUMENT_CREATE', 'mindmap_document.create');
define( 'L_MINDMAP_DOCUMENT_UPDATE', 'mindmap_document.update');
	
class UserActionLog extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserActionLog the static model class
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
		return 'user_action_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, action, timestamp', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>100),
			array('target, target_id', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, action, timestamp, target, target_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function log($action, $target = 0, $target_id = 0, $timestamp = 0){
		$log = new UserActionLog;
		$log->user_id = Yii::app()->user->id;
		if($timestamp == 0)
			$timestamp = time();
		$log->timestamp = $timestamp;
		$log->action = $action;
		$log->target = $target;
		$log->target_id = $target_id;
		if($log->save())
			return true;
		else
			return false;
	}
}