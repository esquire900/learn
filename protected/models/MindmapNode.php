<?php

/**
 * This is the model class for table "mindmap_node".
 *
 * The followings are the available columns in table 'mindmap_node':
 * @property integer $id
 * @property integer $parent_id
 * @property string $mm_id
 * @property string $mm_parent_id
 * @property integer $folded
 * @property integer $font_size
 * @property string $font_color
 * @property integer $offset_x
 * @property integer $offset_y
 * @property string $branch_color
 *
 * The followings are the available model relations:
 * @property Mem[] $mems
 * @property Document[] $Documents
 * @property MindmapNode $parent
 * @property MindmapNode[] $mindmapNodes
 */
class MindmapNode extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MindmapNode the static model class
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
		return 'mindmap_node';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mm_id, offset_x, offset_y, branch_color', 'required'),
			array('parent_id, folded, font_size, offset_x, offset_y', 'numerical', 'integerOnly'=>true),
			array('mm_id, mm_parent_id', 'length', 'max'=>45),
			array('font_color, branch_color', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, mm_id, mm_parent_id, folded, font_size, font_color, offset_x, offset_y, branch_color', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'mindmap_node_id'),
			'Documents' => array(self::HAS_MANY, 'Document', 'mindmap_node_id'),
			'parent' => array(self::BELONGS_TO, 'MindmapNode', 'parent_id'),
			'mindmapNodes' => array(self::HAS_MANY, 'MindmapNode', 'parent_id'),
		);
	}

	/**
	 * Saves one node and all of it's children, so needs to be called only once
	 * @param  array $array complete array of the mindmap, as created by frontend
	 * @return bool        wether succeeded or not
	 */
	public function saveNode($array)
	{
		$node = MindmapNode::model()->findByAttributes(array('mm_id' => $array['id']));
		
		// check if node already exists
		if(count($node) == 0)
		{
			$node = new MindmapNode;
			// set things that don't change
			$node->mm_id = $array['id'];
			$node->mm_parent_id = $array['parentId'];
			if($array['parentId'] == null)
			{
				$node->parent_id = null;
			}
			else{
				$id = MindmapNode::model()->findByAttributes(array('mm_id' => $array['parentId']));
				$node->parent_id = $id->id;
				$node->document_id = $id->document_id;
			}
		}
		$node->font_size = 		$array['text']['font']['size'];
		$node->font_color =		$array['text']['font']['color'];
		$node->offset_x = 		round($array['offset']['x']);
		$node->offset_y = 		round($array['offset']['y']);
		$node->branch_color = 	$array['branchColor'];
		$node->folded =			$array['foldChildren'];
		if(!$node->save()){
			return false;
		}

		foreach($array['children'] as $child)
		{
			$this->saveNode($child);
		}
		return true;
	}

	/**
	 * Exports one node in mindmap frontend format.
	 * @param  int $id id of the node that needs to be exported
	 * @return array     array of the node
	 */
	public function getNodes($id){
		$node = MindmapNode::model()->findByPk($id);
		$item = Item::model()->findByAttributes(array('mindmap_node_id' => $id));
		$r = array();
		$r['id'] = $node->mm_id;
		$r['parentId'] = $node->mm_parent_id;
		$r['text']['caption'] = $item->term;
		$r['text']['font']['style'] = 'normal';
		$r['text']['font']['weight'] = 'normal';
		$r['text']['font']['decoration'] = 'none';
		$r['text']['font']['size'] = intval($node->font_size);
		$r['text']['font']['color'] = $node->font_color;
		$r['offset']['x'] = intval($node->offset_x);
		$r['offset']['y'] = intval($node->offset_y);
		$r['foldChildren'] = $node->folded;
		$r['branchColor'] = $node->branch_color;
		$children = MindmapNode::model()->findAll('parent_id = :id', array(":id" => $id));

		// $r['children'] = array();
		$c = array();
		foreach($children as $i => $child){
			$c[$i] = $this->getChild($child->id);
		}
		$r['children'] = $c;
		return $r;
	}

	public function getChild($id){
		$node = MindmapNode::model()->findByPk($id);
		$item = Item::model()->findByAttributes(array('mindmap_node_id' => $id));
		$r = array();
		$r['id'] = $node->mm_id;
		$r['parentId'] = $node->mm_parent_id;
		$r['text']['caption'] = $item->term;
		$r['text']['font']['style'] = 'normal';
		$r['text']['font']['weight'] = 'normal';
		$r['text']['font']['decoration'] = 'none';
		$r['text']['font']['size'] = intval($node->font_size);
		$r['text']['font']['color'] = $node->font_color;
		$r['offset']['x'] = intval($node->offset_x);
		$r['offset']['y'] = intval($node->offset_y);
		$r['foldChildren'] = $node->folded;
		$r['branchColor'] = $node->branch_color;
		$children = MindmapNode::model()->findAll('parent_id = :id', array(":id" => $id));

		$r['children'] = array();
		$c = array();
		foreach($children as $i => $child){
			$c[$i] = $this->getChild($child->id);
		}
		$r['children'] = $c;
		
		return $r;
	}
	public function getAllIds($rootId){
		$node = MindmapNode::model()->findByPk($rootId);
		if( count($node) == 0) return false;
		$r[] = $node->id;
		$children = MindmapNode::model()->findAll('parent_id = :id', array(":id" => $node->id));
		foreach($children as $i => $child){
			if(isset($child->id))
				$r = array_merge($r, $this->getAllIds($child->id));
		}
		return $r;
	}

	public function beforeValidate(){
		if($this->folded == true)
			$this->folded = 1;
		else
			$this->folded = 0;
		return parent::beforeValidate();
	}

	public function afterFind(){
		if($this->folded == 0)
			$this->folded = false;
		else
			$this->folded = true;
		return parent::afterFind();
	}
}