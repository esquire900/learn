<?php

/**
 * This is the model class for table "mindmap_document".
 *
 * The followings are the available columns in table 'mindmap_document':
 * @property integer $id
 * @property string $mm_id
 * @property string $title
 * @property string $dimension_x
 * @property string $dimension_y
 * @property integer $mindmap_node_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property MindmapNode $mindmapNode
 * @property User $user
 */
class Document extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
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
		return 'document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, category_id, setting_algoritm', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('mm_id, title, dimension_x, dimension_y', 'length', 'max'=>45),
			// The following rule is used by search().
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mm_id' => 'Mm',
			'title' => 'Title',
			'dimension_x' => 'Dimension X',
			'dimension_y' => 'Dimension Y',
			'mindmap_node_id' => 'Mindmap Node',
			'user_id' => 'User',
		);
	}

	/**
	 * Returns the name of the document
	 * @return string name of doc
	 */		
	public function getName(){
		if($this->title == ''){
			$i = Item::model()->findByAttributes(array(
				'user_id' => Yii::app()->user->id,
				'document_id' => $this->id,
				'parent_id' => NULL
			));
			return $i->term;
		}else{
			return $this->title;
		}
	}

	/**
	 * Saves the document
	 * @param  array $array    array with the complete tree, defined by the js mindmap front-end
	 * @param  array $settings settings array
	 * @return array           with success (true or false), and additional info
	 */
	public function saveDocument($array = NULL, $settings)
	{
		// save nodes
		if($array != NULL){
			$nodes = new MindmapNode;
			$nodes->saveNode($array['mindmap']['root']);
		}
		// save document itself
		$document = Document::model()->findByAttributes(array('mm_id' => $array['id']));

		if(count($document) == 0){
			return array('success' =>  false, 'errors' => "Document has to be made already!");
		}else{
			$document->dimension_x = $array['dimensions']['x'];
			$document->dimension_y = $array['dimensions']['y'];
			// settings
			$document->setting_date = $settings['date'];
			$document->setting_infinite = $settings['infinite'];
			$document->setting_algoritm = $settings['algoritm'];
			$document->setting_target_percentage = $settings['target'];
			if($document->save()){
				$log = new UserActionLog;
				$log->log(L_MINDMAP_DOCUMENT_UPDATE, null, $document->id);
				return array('success' => true, 'id' => $document->id, 'type' => 'old');
			}else{
				return array('success' => false, 'errors' => $document->getErrors());
			}
		}
	}

	/**
	 * Generates a document in mindmap format
	 * @param  int $id id of the document that needs to be exported
	 * @return array     array(succes, message or result)
	 */
	public function getMindmap($id){
		$result = array();
		$doc = Document::model()->findByPk($id);
		if(count($doc) == 0)
		{
			return array('success' => false, 'message' => "This document doesn't exist");
		}
		$n = MindmapNode::model()->findByAttributes(array('parent_id' => NULL, 'document_id' => $id));
		$n = $n->getNodes($n->id);
		$result['id'] = $doc->mm_id;
		$result['title'] = $doc->title;
		$result['mindmap']['root'] = $n;
		$result['dates']['created'] = time();
		$result['dimensions']['x'] = intval($doc->dimension_x);
		$result['dimensions']['y'] = intval($doc->dimension_y);
		$result['autosave'] = false;

		return array('success' => true, 'result' => $result);
	}

	/**
	 * Generates settings of a document in mindmap format
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getSettings($id){
		$result = array();
		$doc = Document::model()->findByPk($id);
		$result['settings']['date'] = $doc->setting_date;
		$result['settings']['infinite'] = $doc->setting_infinite;
		$result['settings']['algoritm'] = $doc->setting_algoritm;
		$result['settings']['target_percentage'] = $doc->setting_target_percentage;
		$result['settings']['category_id'] = $doc->category_id;

		return array('success' => true, 'result' => $result);
	}
	/**
	 * Returns count of items that need to be practiced
	 * @return int [description]
	 */
	public function practiceCount(){
		$q = new Question;
		$q = $q->generate($this->id);
		$count = count($q);
		if($count == 0){
			// $criteria = new CDbCriteria;
			// $criteria->condition('user_id='. Yii::app()->user->id);
			// $criteria->condition(
			// Practice::model()->find($criteria);
			return "Nothing yet.";
		}else{
			return "You've got ".$count." items left to practice.";
		}
	}

	public function deleteDocument($id){
		$doc = Document::model()->findByPk($id);
		if(count($doc) == 0){
			Yii::app()->user->setFlash('error', "Document doesn't exist.");
			return false;
		}
		if($doc->user_id != Yii::app()->user->id){
			Yii::app()->user->setFlash('error', "Document isn't yours.");
			return false;
		}
		$items = Item::model()->findAllByAttributes(array('document_id' => $id));
		foreach ($items as $item) {
			$item->delete();
			$p = Practice::model()->findByAttributes(array('item_id' => $item->id));
			if(count($p) != 0)
				$p->delete();
		}
		$nodes = MindMapNode::model()->findAllByAttributes(array('document_id' => $id));
		foreach ($nodes as $node) {
			$node->delete();
		}
		if($doc->delete()){
			$url = Yii::app()->createUrl('overview');
			Yii::app()->request->redirect($url);
		}
	}

	/**
	 * Creates a new list in the database
	 * @return int/bollean the id if succeeded, false is failed
	 */
	public function newList($id){
		$m = new Document;
		$m->category_id = (int)$id;
		$m->mm_id = substr(str_shuffle("0123456789abcdef"), 0, 8)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 8);
		$m->title = '';
		$m->dimension_x = 2000;
		$m->dimension_y = 4000;
		$m->user_id = Yii::app()->user->id;
		$m->setting_date = date("d-m-Y H:i:s", time());
		$m->setting_algoritm = '1';
		if($m->save())
			return $m->id;
		return false;
	}

	/**
	 * Creates a new mindmap in the database
	 * @return int/bollean the id if succeeded, false is failed
	 */
	public function newMindmap($id){
		$m = new Document;
		$m->category_id = (int)$id;
		$m->mm_id = substr(str_shuffle("0123456789abcdef"), 0, 8)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 8);
		$m->title = '';
		$m->dimension_x = 2000;
		$m->dimension_y = 2000;
		$m->user_id = Yii::app()->user->id;
		$m->setting_date = date("d-m-Y H:i:s", time());
		$m->setting_algoritm = '1';
		if($m->save()){
			$n = new MindmapNode;
			$n->parent_id = NULL;
			$n->mm_id = substr(str_shuffle("0123456789abcdef"), 0, 8)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 4)."-".
			substr(str_shuffle("0123456789abcdef"), 0, 8);
			$n->offset_x = 0;
			$n->font_size = 18;
			$n->offset_y = 0;
			$n->branch_color = '#ffffff';
			$n->document_id = $m->id;
			$n->save();

			$item = new Item;
			$item->term = "New";
			$item->mindmap_node_id = $n->id;
			$item->document_id = $m->id;
			$item->user_id = Yii::app()->user->id;
			$item->save();
			return array('success' => true, 'id' => $m->id);
		}else{
			return array('success' => false);
		}
	}

	public function emptyDB(){
		$node = MindmapNode::model()->findAll();
		foreach($node as $n){
			$n->delete();
		}
		$doc = Document::model()->findAll();
		foreach($doc as $n){
			$n->delete();
		}
		$doc = Item::model()->findAll();
		foreach($doc as $n){
			$n->delete();
		}
		$doc = UserActionLog::model()->findAll();
		foreach($doc as $n){
			$n->delete();
		}
		$doc = Practice::model()->findAll();
		foreach($doc as $n){
			$n->delete();
		}
	}

	public function beforeSave() {
			    
		$t = str_replace("nbsp;", ' ', $this->setting_date);
	    $this->setting_date = strtotime($t);
	    return parent::beforeSave();
	}

	public function afterFind() {
		$this->setting_date = date("d-m-Y H:i:s", $this->setting_date);   
		return parent::afterFind();
	}
}