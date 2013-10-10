<?php

/**
 * This is the model class for table "practice".
 *
 * The followings are the available columns in table 'practice':
 * @property integer $id
 * @property integer $time
 * @property integer $user_id
 * @property integer $mem_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Mem $mem
 */
class Practice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Practice the static model class
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
		return 'practice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time, user_id, mem_id', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time, user_id, mem_id', 'safe', 'on'=>'search'),
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
			'mem' => array(self::BELONGS_TO, 'Mem', 'mem_id'),
		);
	}
	/**
	 * setNew practice: a mem has just been made and the next practice time needs to be set
	 * @param [type] $id [description]
	 */
	public function setNew($id){

		$mem = new Mem;
		$doc = Document::model()->findByPk($mem->findDocumentId($id));
		if($doc->setting_algoritm == 1)
			$time = $this->Algo1(time(), 0, $doc);
		if($doc->setting_algoritm == 666)
			$time = $this->Algo666(time(), 0, $doc);

		$log = new UserActionLog;
		$log->log('mem.set_practice_time', $time, $id);
		$practice = new Practice;
		$practice->user_id = Yii::app()->user->id;
		$practice->mem_id = $id;
		$practice->time = $time;
		$practice->save();
	}

	/**
	 * Updates the practice times of $memarray
	 * @param  [type] $memArray [description]
	 * @return [type]           [description]
	 */
	public function updatePracticeTimes($memArray, $docId){
		$doc = Document::model()->findByPk($docId);
		$doc->setting_date = strtotime($doc->setting_date);
		foreach($memArray as $mem){

			$mem = Mem::model()->findByPk($mem['id']);
			// delete old ones
			$p = Practice::model()->findAllByAttributes(array('mem_id' => $mem->id));
			foreach($p as $a)
				$a->delete();
			// when was the mem made?
			$log = UserActionLog::model()->findByAttributes(array(
				'user_id' => Yii::app()->user->id,
				'action' => 'mem.create',
				'target_id' => $mem->id
			));
			$numb = UserActionLog::model()->findAllByAttributes(array(
				'user_id' => Yii::app()->user->id,
				'action' => 'mem.evaluate',
				'target_id' => $mem->id,
				'target' => '1'
			));
			if(count($numb) == 0){
				$lastpractice = time();
			}
			else{
				foreach ($numb as $n) {
					$lastpractice = $n->timestamp;
				}
			}
			
			if($doc->setting_algoritm == 1)
				$time = $this->Algo1($log->timestamp, count($numb), $doc, $lastpractice);
			if($doc->setting_algoritm == 666)
				$time = $this->Algo666($log->timestamp, count($numb), $doc, $lastpractice);
			$practice = new Practice;
			$practice->user_id = Yii::app()->user->id;
			$practice->mem_id = $mem->id;
			$practice->time = $time;
			$pdel = Practice::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id, 
				'mem_id' => $mem->id,
			));
			foreach ($pdel as $p) {
				$p->delete();
			}
			$practice->save();
		}	
		return true;
	}

	/**
	 * Algoritm 1:
	 *    ISI/RI: 10-20 percent, optimal ISI is 1 day
	 *    1/2 days input-learn interval
	 *    overlearning
	 *    learn everything once untill right, no separation between hard/easy items
	 * @param timestamp $lastInteraction last interaction with mem
	 * @param int $learnIterations #iteration for learning
	 * @param object $settings        PracticeSettings Model
	 */
	public function Algo1($creationDate, $learnIterations, $doc, $lastpractice = 0){
		if($lastpractice == 0)
			$lastpractice = time();
		if($doc->setting_date != NULL && $doc->setting_date != 0){
			// go for a specifiec date

			if($doc->setting_date < time()){

				return time();
			}
			// set 2 days between learn and first learning moment
			$timeUntillTest = $doc->setting_date - $lastpractice;
			$timeForIteation = $doc->setting_date - $creationDate;

			if($timeForIteation < 3*24*60*60 ){
				// time is too short to learn reasonable with this algoritm
				return time() + $timeUntillTest - 1*24*60*60;
			}else if($timeForIteation > 8*7*24*60*60){
				// too long
				return time() + $timeUntillTest - 1*24*60*60;
			}
			
			// not very long (3-4 days), so no between learning interval
			if($timeForIteation < 4*24*60*60){
				if($learnIterations == 0){
					// learn first right now
					return $creationDate;
				}elseif ($learnIterations == 1){
					// learn second time
					return $timeUntillTest * 0.1 + $lastpractice;
				}
			}
			// not very long (4-6 days), so no between learning interval
			if($timeForIteation < 6*24*60*60){
				if($learnIterations == 0){
					// learn first time 1 day after input
					return $creationDate + 1*24*60*60;
				}elseif ($learnIterations == 1){
					// learn second time
					return $timeUntillTest * 0.1 + $lastpractice;
				}
			}
			
			// average (6-10 days) keep ISI at one day
			if($timeForIteation < 10*24*60*60){
				if($learnIterations == 0){
					// learn first time 1 day after input
					return $creationDate + 1*24*60*60;
				}elseif ($learnIterations == 1){
					// learn second time
					return $lastpractice + 1*24*60*60;
				}elseif ($learnIterations == 2){
					return $timeUntillTest - 1*24*60*60;
				}
			}

			// average (10-20 days) keep ISI at two days
			if($timeForIteation < 20*24*60*60){
				if($learnIterations == 0){
					// learn first time 1 day after input
					return $creationDate + 1*24*60*60;
				}elseif ($learnIterations == 1){
					// learn second time
					return $lastpractice + 2*24*60*60;
				}elseif ($learnIterations == 2){
					return $timeUntillTest - 1*24*60*60;
				}
			}

			// average (20-30 days) keep ISI at three days
			if($timeForIteation < 30*24*60*60){
				if($learnIterations == 0){
					// learn first time 1 day after input
					return $creationDate + 1*24*60*60;
				}elseif ($learnIterations == 1){
					// learn second time
					return $lastpractice + 3*24*60*60;
				}elseif ($learnIterations == 2){
					return $timeUntillTest - 1*24*60*60;
				}
			}
		}else{
			if($learnIterations == 0){
				return $lastpractice;
			}elseif($learnIterations == 1){
				return $lastpractice + 6*24*60*60;
			}elseif($learnIterations == 2){
				return $lastpractice + 15*24*60*60;
			}elseif($learnIterations == 3){
				return $lastpractice + 37*24*60*60;
			}elseif($learnIterations == 4){
				return $lastpractice + 93*24*60*60;
			}elseif($learnIterations == 5){
				return $lastpractice + 234*24*60*60;
			}elseif($learnIterations == 5){
				return $lastpractice + 585*24*60*60;
			}elseif($learnIterations == 5){
				return $lastpractice + 1464*24*60*60;
			}
		}
	}

	/**
	 * Algoritm 666: simple test algoritm
	 * @param timestamp $lastInteraction last interaction with mem
	 * @param int $learnIterations #iteration for learning
	 * @param object $settings        PracticeSettings Model
	 */
	public function Algo666($creationDate, $learnIterations, $doc, $lastpractice = 0){
		if($lastpractice == 0)
			$lastpractice = time();
		if($learnIterations == 0){
			return $lastpractice;
		}elseif($learnIterations == 1){
			return $lastpractice + 1*60;
		}elseif($learnIterations == 2){
			return $lastpractice + 2*60;
		}elseif($learnIterations == 3){
			return $lastpractice + 3*60;
		}elseif($learnIterations == 4){
			return $lastpractice + 4*60;
		}elseif($learnIterations == 5){
			return $lastpractice + 5*60;
		}else{
			return $lastpractice + 5*60;
		}
	}
}