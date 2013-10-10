<?php

class DocumentTest extends CDbTestCase
{
	public $document;
	public $items;
	public $settings;

	public function init1(){
		$d = Document::model()->find();
		$n = MindmapNode::model()->find();

		$this->document = '{"id":"'.$d->mm_id.'","title":"New Document","mindmap":{"root":{"id":"'.$n->mm_id.'","parentId":null,"text":{"caption":"New","font":{"style":"normal","weight":"normal","decoration":"none","size":18,"color":"#000000"}},"offset":{"x":0,"y":0},"foldChildren":false,"branchColor":"#000000","children":[{"id":"0f0bcc87-fcb8-4de1-b76f-44f27d49994c","parentId":"'.$n->mm_id.'","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-173,"y":-125},"foldChildren":false,"branchColor":"#2d248b","children":[{"id":"09d7084a-19dd-407d-acb1-9a544c06c73e","parentId":"0f0bcc87-fcb8-4de1-b76f-44f27d49994c","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-137,"y":-24},"foldChildren":false,"branchColor":"#2d248b","children":[]},{"id":"b8e2dfe6-90c0-446d-aafb-1f46b3a5b321","parentId":"0f0bcc87-fcb8-4de1-b76f-44f27d49994c","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-130,"y":59},"foldChildren":false,"branchColor":"#2d248b","children":[]}]},{"id":"530c4301-f39b-476c-92a6-c99b67d73f74","parentId":"'.$n->mm_id.'","text":{"caption":"complex","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-274,"y":50},"foldChildren":false,"branchColor":"#c5bc9f","children":[{"id":"4bd4a430-9f87-47e7-9f1d-75b7809d6eb4","parentId":"530c4301-f39b-476c-92a6-c99b67d73f74","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-167,"y":-16},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"3787354d-2327-4c32-90b8-a9a7d73d84ea","parentId":"530c4301-f39b-476c-92a6-c99b67d73f74","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-181,"y":62},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","parentId":"530c4301-f39b-476c-92a6-c99b67d73f74","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-72,"y":133},"foldChildren":false,"branchColor":"#c5bc9f","children":[{"id":"f1157657-61a3-4be4-a440-cc07deb8c2e0","parentId":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-166,"y":-3},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"5765a188-9bbb-4c9c-b7b8-3136e02b2866","parentId":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-127,"y":81},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"075f2078-9d36-4894-ab73-e172b4d3e058","parentId":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-18,"y":76},"foldChildren":false,"branchColor":"#c5bc9f","children":[]}]}]},{"id":"cb403ae1-0f02-4c15-9419-50eb97a1afd7","parentId":"'.$n->mm_id.'","text":{"caption":"complex name","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":268,"y":-104},"foldChildren":false,"branchColor":"#a2d46f","children":[]}]}},"dates":{"created":1381267063010},"dimensions":{"x":4000,"y":2000},"autosave":false}';
		$this->items = '{"'.$n->mm_id.'":{"term":"New","mem":"seomthing","answer":"something"},"0f0bcc87-fcb8-4de1-b76f-44f27d49994c":{"term":"New Idea","mem":"","answer":""},"530c4301-f39b-476c-92a6-c99b67d73f74":{"term":"complex","mem":"mem","answer":"answer"},"09d7084a-19dd-407d-acb1-9a544c06c73e":{"term":"New Idea","mem":"","answer":""},"b8e2dfe6-90c0-446d-aafb-1f46b3a5b321":{"term":"New Idea","mem":"mem","answer":"answer2"},"4bd4a430-9f87-47e7-9f1d-75b7809d6eb4":{"term":"New Idea","mem":"mem","answer":"answer2"},"3787354d-2327-4c32-90b8-a9a7d73d84ea":{"term":"New Idea","mem":"","answer":""},"64fb9938-0943-4d1b-8fb3-d28a70bc1e68":{"term":"New Idea","mem":"","answer":""},"f1157657-61a3-4be4-a440-cc07deb8c2e0":{"term":"New Idea","mem":"","answer":""},"5765a188-9bbb-4c9c-b7b8-3136e02b2866":{"term":"New Idea","mem":"","answer":""},"075f2078-9d36-4894-ab73-e172b4d3e058":{"term":"New Idea","mem":"","answer":""},"cb403ae1-0f02-4c15-9419-50eb97a1afd7":{"term":"complex name","mem":"","answer":""}}';
		$this->settings = '{"date":"12-12-2015","infinite":0,"target":0,"algoritm":1,"file":1}';
	}

	public function init2(){
		$d = Document::model()->find();
		$n = MindmapNode::model()->find();
		// create new mindmap
		$this->document = '{"id":"'.$d->mm_id.'","title":"New Document","mindmap":{"root":{"id":"'.$n->mm_id.'","parentId":null,"text":{"caption":"New","font":{"style":"normal","weight":"normal","decoration":"none","size":18,"color":"#000000"}},"offset":{"x":0,"y":0},"foldChildren":false,"branchColor":"#000000","children":[{"id":"0f0bcc87-fcb8-4de1-b76f-44f27d49994c","parentId":"'.$n->mm_id.'","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-173,"y":-125},"foldChildren":false,"branchColor":"#2d248b","children":[{"id":"09d7084a-19dd-407d-acb1-9a544c06c73e","parentId":"0f0bcc87-fcb8-4de1-b76f-44f27d49994c","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-137,"y":-24},"foldChildren":false,"branchColor":"#2d248b","children":[]},{"id":"b8e2dfe6-90c0-446d-aafb-1f46b3a5b321","parentId":"0f0bcc87-fcb8-4de1-b76f-44f27d49994c","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-130,"y":59},"foldChildren":false,"branchColor":"#2d248b","children":[]}]},{"id":"530c4301-f39b-476c-92a6-c99b67d73f74","parentId":"'.$n->mm_id.'","text":{"caption":"complex","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-274,"y":50},"foldChildren":false,"branchColor":"#c5bc9f","children":[{"id":"4bd4a430-9f87-47e7-9f1d-75b7809d6eb4","parentId":"530c4301-f39b-476c-92a6-c99b67d73f74","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-167,"y":-16},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"3787354d-2327-4c32-90b8-a9a7d73d84ea","parentId":"530c4301-f39b-476c-92a6-c99b67d73f74","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-181,"y":62},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","parentId":"530c4301-f39b-476c-92a6-c99b67d73f74","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-72,"y":133},"foldChildren":false,"branchColor":"#c5bc9f","children":[{"id":"f1157657-61a3-4be4-a440-cc07deb8c2e0","parentId":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-166,"y":-3},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"5765a188-9bbb-4c9c-b7b8-3136e02b2866","parentId":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-127,"y":81},"foldChildren":false,"branchColor":"#c5bc9f","children":[]},{"id":"075f2078-9d36-4894-ab73-e172b4d3e058","parentId":"64fb9938-0943-4d1b-8fb3-d28a70bc1e68","text":{"caption":"New Idea","font":{"style":"normal","weight":"normal","decoration":"none","size":15,"color":"#000000"}},"offset":{"x":-18,"y":76},"foldChildren":false,"branchColor":"#c5bc9f","children":[]}]}]}]}},"dates":{"created":1381267063010},"dimensions":{"x":4000,"y":2000},"autosave":false}';
		$this->items = '{"'.$n->mm_id.'":{"term":"New","mem":"seomthing","answer":"something"},"0f0bcc87-fcb8-4de1-b76f-44f27d49994c":{"term":"New Idea","mem":"","answer":""},"530c4301-f39b-476c-92a6-c99b67d73f74":{"term":"complex","mem":"mem","answer":"answer"},"09d7084a-19dd-407d-acb1-9a544c06c73e":{"term":"New Idea","mem":"","answer":""},"b8e2dfe6-90c0-446d-aafb-1f46b3a5b321":{"term":"New Idea","mem":"mem","answer":"answer2"},"4bd4a430-9f87-47e7-9f1d-75b7809d6eb4":{"term":"New Idea","mem":"mem","answer":"answer2"},"3787354d-2327-4c32-90b8-a9a7d73d84ea":{"term":"New Idea","mem":"","answer":""},"64fb9938-0943-4d1b-8fb3-d28a70bc1e68":{"term":"New Idea","mem":"","answer":""},"f1157657-61a3-4be4-a440-cc07deb8c2e0":{"term":"New Idea","mem":"","answer":""},"5765a188-9bbb-4c9c-b7b8-3136e02b2866":{"term":"New Idea","mem":"","answer":""},"075f2078-9d36-4894-ab73-e172b4d3e058":{"term":"New Idea","mem":"","answer":""}}';
		$this->settings = '{"date":"12-12-2015","infinite":0,"target":0,"algoritm":1,"file":1}';
	}

	public function testAMindmapInit()
	{
		$d = new Document;
		Yii::app()->user->id = 1;
		$save = $d->newMindmap(0);
		$this->assertTrue($save['success'], 'New mindmap is not created!');
		$doc = Document::model()->findAll();
		$this->assertEquals(count($doc), 1 , 'Mindmap wasnt saved');
		$node = MindmapNode::model()->findAll();
		$this->assertEquals(count($node), 1 , 'MindmapNode wasnt saved');
		$item = Item::model()->findAll();
		$this->assertEquals(count($item), 1 , 'Item wasnt saved');
	}

	public function testBMindMapsave(){
		Yii::app()->user->id  = 1;
		$d = Document::model()->find();
		$n = MindmapNode::model()->find();
		// create new mindmap
		$this->init1();
		$save = $d->saveDocument(CJSON::decode($this->document), CJSON::decode($this->settings));
		$this->assertTrue($save['success'], 'MindMap save didnt succeed');
		$node = MindmapNode::model()->findAll();
		$this->assertEquals(12, count($node) , 'Not all nodes were saved!');

		$item = new Item;
		$saveItem = $item->saveMindmapItems(CJSON::decode($this->items), $save['id']);
		$this->assertTrue($saveItem['success'], 'Items save didnt succeed');

		$item = Item::model()->findAll();
		$this->assertEquals(12, count($item) , 'Not all items were saved!');

		$item = Item::model()->findAllByAttributes(array('answer' => 'answer2'));
		$this->assertEquals(count($item), 2 , 'Answers not properly saved');

		$item = Item::model()->findAllByAttributes(array('term' => 'complex name'));
		$this->assertEquals(count($item), 1 , 'Terms not properly saved');
	}

	public function testCMindMapModify(){
		Yii::app()->user->id  = 1;
		$d = new Document;
		$this->init2();
		$save = $d->saveDocument(CJSON::decode($this->document), CJSON::decode($this->settings));
		$this->assertTrue($save['success'], 'MindMap save didnt succeed');
		
		$item = new Item;
		$saveItem = $item->saveMindmapItems(CJSON::decode($this->items), $save['id']);
		$this->assertTrue($saveItem['success'], 'Items save didnt succeed');
		$node = MindmapNode::model()->findAll();
		$this->assertEquals(11, count($node) , 'Not all nodes were saved!');

		$item = Item::model()->findAll();
		$this->assertEquals(11, count($item) , 'Not all items were saved!');

		$item = Item::model()->findAllByAttributes(array('term' => 'complex name'));
		$this->assertEquals(0, count($item) , 'Not the right item was deleted');
	}

	public function testDTestGenerate(){
		Yii::app()->user->id  = 1;
		$this->init2();
		$d = Document::model()->find();
		$result = $d->generateMindmap($d->id);
		$this->assertTrue($result['success'], 'Mindmap generation didnt succeed');
		$this->assertEquals(CJSON::decode($this->document), $result['result'] , 'settings export werent right');

		$resultSettings = $d->getSettings($d->id);
		$this->assertTrue($resultSettings['success'], 'Mindmap generation didnt succeed');
		$this->assertEquals(CJSON::decode($this->settings), $resultSettings['result'] , 'settings export werent right');
	}
	public function testZEmptyDB(){
		$d = new Document;
		$d->emptyDB();
	}
}
