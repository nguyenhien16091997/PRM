<?php

namespace app\controllers;

use Yii;
use app\models\DataModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\extensions\HandleFile;

/**
 * DataModelController implements the CRUD actions for DataModel model.
 */
class DataModelController extends Controller
{
    /**
     * {@inheritdoc}
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

    /*
        upload file
    */
    public function upload($uploadFile, $filePathIn, $filePathOut)
    { 
        $handleFile = new HandleFile();   

        //  save file to upload folder        
        $uploadFile->saveAs($filePathIn);

        return  $handleFile->handle($filePathIn, $filePathOut);
    }
    public function readRow1($filePath){       
        $this->readRow1($filePathIn);
  
    }


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DataModel::find(),
        ]);    	      
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single DataModel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $dm = new DataModel();
     
        $xls_data = $dm->readFileExcel($model->pathFileOutput);        

        return $this->render('view', [
            'model' => $model, 
            'xls_data' => $xls_data
        ]);
    }

    /**
     * Creates a new DataModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataModel();

        if ($model->load(Yii::$app->request->post())) {          
            $time      = strtotime('+7 hour', time());
            $datetime  = date('Y-m-d H:i:s', $time);
            $suffix    = date('YmdHis', $time);
            $model->uploadFile= UploadedFile::getInstance($model, 'uploadFile');      
            if(empty($model->uploadFile)){
                $model->addError('uploadFile', 'you have to choce a file !');
                return $this->render('create', compact('model'));
            }

            // Determine fileName
            $component = explode('.',$model->uploadFile->name);
            $fileName = $component[0].'_'.$suffix.'.'.$component[1];
            $model->file_name  =    $fileName;
            $fileNameOut = $component[0].'_'.$suffix.'.'.'xlsx';

            // Determine path Input and Output
            $model->pathFileInput   =   Yii::$app->basePath.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileInput'.DIRECTORY_SEPARATOR.$fileName;
            $model->pathFileOutput  =   Yii::$app->basePath.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileOutput'.DIRECTORY_SEPARATOR.$fileNameOut;   

            $model->create_at   =   $datetime;
            $model->update_at   =   $datetime;    
   
            if( $this->upload($model->uploadFile, $model->pathFileInput, $model->pathFileOutput)){
                $model->pathFileInput = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileInput'.DIRECTORY_SEPARATOR.$fileName;
                $model->pathFileOutput = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileOutput'.DIRECTORY_SEPARATOR.$fileNameOut; 
                if($model->save()){
                    Yii::$app->session->setFlash('success', "User created successfully.");
                    return $this->redirect(['view', 'id' => $model->id]);
                }       
            }
               
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DataModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DataModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetxls(){

        $id = Yii::$app->request->post('id');

        $model = $this->findModel($id);

        $dm = new DataModel();
     
        $xls_data = $dm->readFileExcel($model->pathFileOutput);        

        return json_encode($xls_data);
    }

    /**
     * Finds the DataModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
