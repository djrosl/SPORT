<?php

namespace app\modules\admin\controllers;

use nullref\admin\components\AdminController;
use Yii;
use app\models\Exercise;
use app\modules\admin\models\ExerciseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ExerciseController implements the CRUD actions for Exercise model.
 */
class ExerciseController extends AdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Exercise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExerciseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exercise model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Exercise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Exercise();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$photo = UploadedFile::getInstance($model, 'photo');
					$video = UploadedFile::getInstance($model, 'video');

					if($photo){
						$path = date('U').'-'.$photo->baseName.'.'.$photo->extension;
						$photo->saveAs(Yii::getAlias('@webroot').'/files/images/'.$path);
						$model->attachImage(Yii::getAlias('@webroot').'/files/images/'.$path);
					}

					if($video){
						$path = date('U').'-'.$video->baseName.'.'.$video->extension;
						$video->saveAs(Yii::getAlias('@webroot').'/files/'.$path);
						$model->video = $path;
						$model->save();
					}

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Exercise model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

					$photo = UploadedFile::getInstance($model, 'photo');
					$video = UploadedFile::getInstance($model, 'video');

					if($photo){
						$path = date('U').'-'.$photo->baseName.'.'.$photo->extension;
						$photo->saveAs(Yii::getAlias('@webroot').'/files/images/'.$path);
						$model->attachImage(Yii::getAlias('@webroot').'/files/images/'.$path);
					}

					if($video){
						$path = date('U').'-'.$video->baseName.'.'.$video->extension;
						$video->saveAs(Yii::getAlias('@webroot').'/files/'.$path);
						$model->video = '/files/'.$path;
						$model->save();
					}

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Exercise model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Exercise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exercise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exercise::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
