<?php

class CategoryController extends Controller
{
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions'=>array('index', 'delete', 'create'),
                'users'=>array('?'),
            ),
        );
    }

	public function actionIndex($id = 0, $search = ''){
		if($search != ''){
			$d = Document::model()->findAllByAttributes(array('category_id' => $id, 'user_id' => Yii::app()->user->id));
		}else if($id !== 0){
			$c = Category::model()->findByPk($id);
			if(count($c) == 0){
				throw new CHttpException(400, Yii::t('error', 'The id can\'t be found!'));
			}else if (Yii::app()->user->id !== $c->user_id){
				throw new CHttpException(400, Yii::t('error', 'This category isn\'t yours!'));
			}
			$c = $c->getChildren();
			$d = Document::model()->findAllByAttributes(array('category_id' => $id, 'user_id' => Yii::app()->user->id));
		}else{
			$c = Category::model()->findAllByAttributes(array(
				'user_id' => Yii::app()->user->id,
				'parent_id' => null,
			));
			$d = Document::model()->findAllByAttributes(array('category_id' => $id, 'user_id' => Yii::app()->user->id));

		}
		$this->render('index', array('folders' => $c, 'documents' => $d));
	}

	public function actionDelete($id){
		$c = Category::model()->findByPk($id);
		if($c->user->id !== Yii::app()->user->id)
			return false;
		else
			$c->delete();

		$this->redirect(array('category/index'));

	}

	public function actionCreate($parent_id, $name, $info){
		if($name == '') throw new CHttpException(400, Yii::t('error', 'You need forgot to set a name, please try again.'));
		$c = Category::model()->findByPk($parent_id);
		if(count($c) == 0)
			$c = new Category;
		$save = $c->addChild($name, $info, $c);
		if($save != false)
			$this->redirect(array('category/index', 'id' => $save));
	}
}