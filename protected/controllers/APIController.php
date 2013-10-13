<?php

class APIController extends Controller
{

	public function actions()
    {
        return array(
            'fileUpload'=>array(
                'class'=>'ext.redactor.actions.FileUpload',
                'uploadCreate'=>true,
            ),
            'imageUpload'=>array(
                'class'=>'ext.redactor.actions.ImageUpload',
                'uploadCreate'=>true,
            ),
            'imageList'=>array(
                'class'=>'ext.redactor.actions.ImageList',
            ),
        );
    }

	/*
	Create mindmaps app
	 */
	public function actionSaveMindMap()
	{
		if(!isset($_POST)){
			Yii::app()->user->setFlash('error', 'No post variables set');
			$this->_sendResponse(false); //negative message
		}
		$mindmap = $_POST['mindmap'];
		$mindmapItems = $_POST['mindmapItems'];
		$settings = $_POST['settings'];
		/*
			Mindmap part
		 */ 
		$mindmap = CJSON::decode($mindmap);
		$settings = CJSON::decode($settings);
		$doc = new Document;
		$a = $doc->saveDocument($mindmap, $settings);
		/*
			Save items
		*/
		$items = CJSON::decode($mindmapItems);
		$item = new Item;
		$b = $item->saveMindmapItems($items, $a['id']);

		/* set practice times */				
		$practice = new Question;
		$practice->setPracticeTimes($a['id']);
		if($a == true && $b == true)
			$this->_sendResponse(true); // positive message
		else
			$this->_sendResponse(false); //negative message
	}

	public function actionSaveList(){
		if(!isset($_POST)){
			Yii::app()->user->setFlash('error', 'No post variables set');
			$this->_sendResponse(false); //negative message
		}
		$items = $_POST['items'];
		$settings = $_POST['settings'];
		$mindmap = $_POST['mindmap'];
		/*
			Save the document
		 */ 
		$mindmap = CJSON::decode($mindmap);
		$settings = CJSON::decode($settings);
		$doc = new Document;
		$a = $doc->saveDocument($mindmap, $settings);

		/*
			Save the list items
		 */
		$items = CJSON::decode($items);
		$c = $items->saveListItems($items, $a['id']);
	}

	/**
	 * Creates a new mindmap
	 * @param  int $id parent_id of mindmap -> in which folder it's stored
	 * @return int     id of mindmap
	 */
	public function actionNewMindMap($id){
		$m = new Document;
		$new = $m->newMindmap($id);
		if($new['success'] == false)
			$new = $m->newMindmap(false);
		else
			$this->_sendResponse($new['id']);
	}

	public function actionNewList($id){
		$m = new Document;
		$new = $m->newList($id);
		if($new['success'] == false)
			$new = $m->newMindmap(false);
		else
			$this->_sendResponse($new['id']);
	}

	/*
		Get mindmap
	 */ 
	public function actionGetMindmap($id)
	{	
		$doc = new Document;
		$doc = $doc->getMindmap($id);
		if($doc['success'] == true)
			$this->_sendResponse($doc['result']);	
		else
			$this->_sendResponse(false);	
	}

	public function actionGetItems($id){
		$items = Item::model()->findAllByAttributes(array('document_id' => $id));
		foreach ($items as $item) {
			$node = MindmapNode::model()->findByPk($item->mindmap_node_id);
			$r[$node->mm_id]['answer'] = $item->answer;
			$r[$node->mm_id]['mem'] = $item->mem;
			$r[$node->mm_id]['term'] = $item->term;
		}
		$this->_sendResponse($r);
	}

	public function actionGetSettings($id){
		$doc = new Document;
		$doc = $doc->getSettings($id);
		if($doc['success'] == true)
			$this->_sendResponse($doc['result']);	
		else
			$this->_sendResponse(false);	
	}

	public function actionLog($action, $target, $target_id, $timestamp){
		$log = new UserActionLog;
		//log($action, $target = 0, $target_id = 0, $timestamp = 0){
		$log = $log->log($action, $target, $target_id, $timestamp);
		$this->_sendResponse($log);
	}

	public function actionDeleteDocument($id){
		$doc = new Document;
		$a = $doc->deleteDocument($id);
		$this->_sendResponse($a);	
	}

	/**
	 * Practice app
	 */
	public function actionGetQuestions($id){
		$q = new Question;
		$q = $q->generate($id);
		$this->_sendResponse($q);
	}

	public function actionUpdatePracticeTimes($id){
		$p = new Question;
		$p = $p->setPracticeTimes($id);
		$this->_sendResponse($p);
	}

	public function actionEmptydb(){
		$m = new Document;
		$m->emptyDB();
	}

	public function actionTest(){
		$q = Category::model()->findByPk(4);
		CVarDumper::dump($q->breadcrumbs(), 10, true);
	}

	private function _sendResponse( $json, $content_type = 'application/json', $status = 200)
	{
	    // set the status
	    $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
	    header($status_header);
	    // and the content type
	    header('Content-type: ' . $content_type);
	 

	    if($json === false){
	    	$j['success'] = false;
    		$j['message'] = Yii::app()->user->getFlash('error');
	    }else{
	    	$j['success'] = true;
	    	$j['data'] = $json;
	    }
	    echo CJSON::encode($j);
	    Yii::app()->end();
	}

	private function _getStatusCodeMessage($status)
	{
	    // these could be stored in a .ini file and loaded
	    // via parse_ini_file()... however, this will suffice
	    // for an example
	    $codes = Array(
	        200 => 'OK',
	        400 => 'Bad Request',
	        401 => 'Unauthorized',
	        402 => 'Payment Required',
	        403 => 'Forbidden',
	        404 => 'Not Found',
	        500 => 'Internal Server Error',
	        501 => 'Not Implemented',
	    );
	    return (isset($codes[$status])) ? $codes[$status] : '';
	}
}