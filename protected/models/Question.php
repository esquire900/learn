<?php
class Question
{
	const Q_LIST = '!list';
	const Q_EXCEPTION = '!e';
	public $hashbangContacts = array(
		Question::Q_EXCEPTION, 
		Question::Q_LIST
	);
	public $documentId; // document id
	public $elements = array(); // all elements, e.g. mems
	public $questionElements = array();
	public $questions = array(); // final array of questions
	public $questionNumb = 0; // number of the current question that's being calculated

	public function generate($id){
		$this->documentId = $id;
		$this->getElements();
		$this->questionOptions();
		$this->removePracticeElements();
		$this->createQuestions();
		return $this->questions;
	}

	public function setPracticeTimes($docId){
		$this->documentId = $docId;
		$this->getElements();
		$this->questionOptions();
		foreach ($this->questionElements as $id => $element) {
			$c = Practice::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'item_id' => $id));
			$p = new Practice;
			if(count($c) == 0)
			{
				$p->setNew($id);
			}else{
				$p->updatePracticeTimes($this->questionElements, $docId);
			}
		}
		return true;
	}
	/**
	 * Prepares the elements, get's all the relevant info
	 * @return nothing, results set in $this->elements
	 **/
	public function getElements(){
		$itemsQ = Item::model()->findAllByAttributes(array('document_id' => $this->documentId));

		foreach ($itemsQ as $item) {
			$i = $item->id;
			$practice = Practice::model()->findByAttributes(array('item_id' => $i));
			$items[$i]['practice'] = $practice;

			// parent
			if($item['parent_id'] != null)
				$parent = Item::model()->findByPk($item['parent_id']);
			else
				$parent = null;
			$items[$i]['parent'] = $parent;

			$items[$i]['children'] = array();
			foreach ($itemsQ as $x => $m) {
				if($m['parent_id'] == $i)
					$items[$i]['children'][] = $m;
			}

			$items[$i]['hashbangs'] = array();
			// filter the !hashbangs
			$items[$i]['answer'] = $item->answer;
			$items[$i]['mem'] = $item->mem;
			$items[$i]['term'] = $item->term;
			foreach ($this->hashbangContacts as $hb) {
				if(strstr($items[$i]['answer'], $hb) != false){
					$items[$i]['answer'] = str_replace($hb, '', $items[$i]['answer']);
					$items[$i]['hashbangs'][$hb] = true;
				}
				if(strstr($items[$i]['mem'], $hb) != false){
					$items[$i]['mem'] = str_replace($hb, '', $items[$i]['mem']);
					$items[$i]['hashbangs'][$hb] = true;
				}
			}

			if($items[$i]['answer'] != '' && $items[$i]['answer'] != '<br>' && $items[$i]['answer'] != ' '){
				$items[$i]['independentQuestion'] = true;
			}else{
				$items[$i]['independentQuestion'] = false;
			}

			$items[$i]['id'] = $i;
		}
		$this->elements = $items;
	}
	/**
	 * Investigates all the $this->elements elements and 
	 * sets the ones that can be possibly questioned in $this->questionElements
	 */
	public function questionOptions(){
		foreach ($this->elements as $id => $element) {
			if(isset($element['hashbangs'][Question::Q_EXCEPTION]))
				continue; // user set this as exception so we won't question the topic
			if($element['independentQuestion'] == false && count($element['children']) == 0)
				continue; // has no answer and no children, so nothing to ask about element
			$this->questionElements[$id] = $element;
		}

	}

	/**
	 * Removes the elements from $this->questionElements which have
	 * a practice date further than now
	 */
	public function removePracticeElements(){
		foreach ($this->questionElements as $id => $element) {
			if($element['practice']['time'] > time() or $element['practice']['time'] == null){
				unset($this->questionElements[$id]);
			}
		}
	}

	/**
	 * Container function for all the question creation functions
	 * takes the $questionElements array and puts questions in $questions
	 */
	public function createQuestions(){
		foreach ($this->questionElements as $id => $element) {
			$questions = array();

			if($element['independentQuestion'] == true){
				$questions[] = $this->questionIndep($element);
			}

			if(count($element['children']) > 0 && $element['independentQuestion'] == false){
				$questions[] = $this->questionChildren($element);
			}

			$r = array();
			$r['id'] = $id;
			$r['questions'] = $questions;
			$this->questions[] = $r;
		}

		shuffle($this->questions);
	}

	public function questionIndep($element){
		$r['question'] = "Explain the meaning of ".$element['term'];
		$r['answer'] = $element['answer'].'.';
		$r['mem'] = $element['mem'];
		$r['line'] = $this->getLine($element);
		$r['questionMethod'] = $this->getQuestionMethod();
		$r['reverseAnswer'] = false;
		return $r;
	}

	public function questionChildren($element){
		if($element['parent'] != null){
			$r['question'] = "Explain ".$element['term']." of ".$element['parent']['term'];
		}else{
			$r['question'] = "Explain the list of ".$element['term'];
		}

		$r['answer'] = '';
		$r['answerOptions'] = 0;
		foreach($element['children'] as $i => $child){
			if($i != 0) $r['answer'] .= ", ";
			$r['answer'] .= $child['term'];
			$r['answerOptions']++;
		}
		$r['answer'] .= ".";
		$r['line'] = $this->getLine($element);
		$r['mem'] = $element['mem'];
		$r['questionMethod'] = $this->getQuestionMethod();
		$r['reverseAnswer'] = false;
		return $r;
	}


	public function getLine($element){
		$r = array($element['term']);
		$r = array_merge($r, $this->l($element));
		// $r = array_reverse($r);
		return $r;
	}

	public function l($element){
		$r = array();
		if($element['parent'] != null){
			$r[] = $element['parent']['term'];
			$r = array_merge($r, $this->l($this->elements[$element['parent']['id']]));
		}else{
			return array();
		}
		return $r;
	}

	public function getQuestionMethod(){
		$possibilities = array('think', 'write');
		$this->questionNumb++;
		return $possibilities[rand(0,1)];
	}
}