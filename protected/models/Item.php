<?php

/**
 * This is the model class for table "mem".
 *
 * The followings are the available columns in table 'mem':
 * @property integer $id
 * @property string $term
 * @property string $answer
 * @property string $item
 * @property integer $user_id
 * @property integer $mindmap_node_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property MindmapNode $mindmapNode
 * @property Practice[] $practices
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mem the static model class
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
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, mindmap_node_id', 'numerical', 'integerOnly'=>true),
			array('term, answer, mem', 'length', 'max'=>1024000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, term, answer, mem, user_id, mindmap_node_id', 'safe', 'on'=>'search'),
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
			'mindmapNode' => array(self::BELONGS_TO, 'MindmapNode', 'mindmap_node_id'),
			'practices' => array(self::HAS_MANY, 'Practice', 'mem_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'term' => 'Term',
			'answer' => 'Answer',
			'mem' => 'Mem',
			'user_id' => 'User',
			'mindmap_node_id' => 'Mindmap Node',
		);
	}

	/**
	 * Saves the 'untied' items
	 * @param  array $array items that need to be saved
	 * @param  int $docId the Document id
	 * @return bool        whether succeeded or not
	 */
	public function saveListItems($array, $docId){
		$ids = array();
		foreach($array as $item){
			$itemSave = Item::model()->findByPk($item['id']);
			if(count($itemSave) == 0){
				$logcreate = true;
				$itemSave = new Item;
			}
			$itemSave->term = $item['term'];
			$itemSave->answer = str_replace("<p>", '', str_replace("</p>", '', $item['answer']));
			$itemSave->mem = str_replace("<p>", '', str_replace("</p>", '', $item['mem']));
			$itemSave->user_id = Yii::app()->user->id;
			$itemSave->document_id = $docId;
			if(!$itemSave->save()){
				Yii::app()->user->setFlash('error', "Error saving list item");
				return false;
			}
			if(isset($logcreate)){
				$log = new UserActionLog;
				$log->log('item.create', 'item', $item->id);
			}
			$ids[] = $item->id;
		}

		// query to find all items that are not in ids but are in the document
		$criteria = new CDbCriteria();
		$criteria->condition = 'document_id=:docId AND user_id=:userId';
		$criteria->params = array(':docId'=>$docId,':userId'=>Yii::app()->user->id);
		$criteria->addNotInCondition('id', $ids); 
		$results = Item::model()->findAll($criteria);
		foreach ($results as $res)
			$res->delete();

		return true;
	}

	/**
	 * Saves the items feeded in the array
	 * @param  array $array items that need to be saved
	 * @return bool        wheather saving succeeded or not
	 */
	public function saveMindmapItems($array, $docId)
	{
		reset($array);
		$first_key = key($array);

		// // get all the current nodes to check what needs to be deleted and what not
		$node = MindmapNode::model()->findByAttributes(array('mm_id' => $first_key));
		$all = Item::model()->findAllByAttributes(array('document_id' => $docId));
		$allitems = array();
		foreach ($all as $a) {
			$allitems[] = $a->id;
		}
		
		// loop over the array
		foreach($array as $itemm_id => $item)
		{
			$log = new UserActionLog;
			$node = MindmapNode::model()->findByAttributes(array('mm_id' => $itemm_id));
			if(count($node) == 0)
			{
				return array('success' => false, 'message' => "no nodes are found");
			}

			$newItem = Item::model()->findByAttributes(array('mindmap_node_id' => $node->id));
			if(count($newItem) == 0)
			{
				$newItem = new Item;
				$newItem->user_id = Yii::app()->user->id;
				
				$logCreate = true;
			}else{
				if($newItem->term != $item['term']){
					$log->log('item.update.term',$item['term'], $newItem->id);
				}
				if($newItem->mem != $item['mem']){
					$log->log('item.update.mem', $item['mem'], $newItem->id);
				}
				if($newItem->answer != $item['answer']){
					$log->log('item.update.answer', $item['answer'], $newItem->id);
				}
			}
			$newItem->mindmap_node_id = $node->id;
			$newItem->term = $item['term'];
			$newItem->answer = str_replace("<p>", '', str_replace("</p>", '', $item['answer']));
			$newItem->mem = str_replace("<p>", '', str_replace("</p>", '', $item['mem']));
			$newItem->document_id = $node->document_id; 
			$parent = Item::model()->findByAttributes(array('mindmap_node_id' => $node->parent_id));
			if(count($parent) == 0)
			{
				$parent = NULL;
			}else{
				$parent = $parent->id;
			} 
			if($node->parent_id == NULL)
				$parent = NULL;
			$newItem->parent_id = $parent;

			if(!$newItem->save()){
				return array('success' => false, 'error' => implode($newItem->getErrors()));
			}

			if(isset($logCreate))
				$log->log('item.create', 'item', $newItem->id);

			// check if create log actually exists
			$logcheck = UserActionLog::model()->findAllByAttributes(array(
				'user_id' => Yii::app()->user->id,
				'action' => 'item.create',
				'target_id' => $newItem->id,
			));
			if(count($logcheck) == 0)
				$log->log('item.create', 'item', $newItem->id);
			// unset the items in the complete array, so items left in $allitems need to be deleted
			if(($key = array_search($newItem->id, $allitems)) !== false) 
			    unset($allitems[$key]);
			
		}

		// delete all items left in array, these weren't in the document so are deleted by the user
		foreach ($allitems as $i => $item) {
			$item = Item::model()->findByPk($item);
			$node = MindmapNode::model()->findByPk($item->mindmap_node_id);
			$node->delete();
			$item->delete();
		}

		return array('success' => true);
	}

	/**
	 * gets the top parent Item
	 * @param  int $id id of the Item
	 * @return int     id of the top parent Item
	 */
	public function getTopParent($id){
		$item = Item::model()->findByPk($id);
		if(isset($item->parent_id) && $item->parent_id != NULL)
			return $this->getTopParent($item->parent_id);
		else
			return $item->id;
	}
}