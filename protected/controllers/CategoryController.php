<?php

class CategoryController extends Controller
{
	public function actionIndex($id = 0){
		if($id !== 0){
			$c = Category::model()->findByPk($id);
			if(count($c) == 0){
				throw new CHttpException(400, Yii::t('error', 'The id can\'t be found!'));
			}else if (Yii::app()->user->id !== $c->user_id){
				throw new CHttpException(400, Yii::t('error', 'This category isn\'t yours!'));
			}
			$c = $c->getChildren();
		}else{
			$c = Category::model()->findAllByAttributes(array(
				'user_id' => Yii::app()->user->id,
				'parent_id' => 0,
			));
		}
		$d = Document::model()->findAllByAttributes(array('category_id' => $id));
		$this->render('index', array('folders' => $c, 'documents' => $d));
	}

	public function actionDelete($id){
		$c = Category::model()->findByPk($id);

		if($c->deleteCategory()){
			$this->redirect(array('category/index'));
		}
	}

	public function actionCreate($parent_id, $name, $info){
		if($name == '') throw new CHttpException(400, Yii::t('error', 'You need forgot to set a name, please try again.'));
		$c = Category::model()->findByPk($parent_id);
		if(count($c) == 0)
			$c = new Category;
		$save = $c->addChild($name, $info);
		if($save != false)
			$this->redirect(array('category/index', 'id' => $save));
	}
}