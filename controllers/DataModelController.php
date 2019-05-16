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
use app\models\PathFileInput;
use app\models\PathFileOutput;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
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
    public function upload($uploadFile, $filePathIn, $filePathOut, $chose)
    { 
        
        $handleFile = new HandleFile();   

        //  save file to upload folder        
        $uploadFile->saveAs($filePathIn);

        $datamodelP = new DataModel();

        $arrP = $datamodelP->readFileExcel(substr($filePathIn, strlen(Yii::$app->basePath)));
        
        switch ($chose) {
            case '1':
                foreach ($arrP as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if($value2 == null){
                            unset($arrP[$key]);
                        }
                    }
                }                
                break;
            case '2':
                foreach ($arrP as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if($value2 == null){
                            $arrP[$key][$key2] = 0;
                        }
                    }
                }
                break;
            case '3':
                foreach ($arrP as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if($value2 == null){

                            $arrP[$key][$key2] = $this->getRowRepeatMost($arrP, $key2, count($arrP));
                        }
                    }
                }
                break;
            case '4':
                foreach ($arrP as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if($value2 == null){
                            if($key == 2)
                            {
                                $arrP[$key][$key2] = $arrP[$key + 1][$key2];
                            }elseif ($key == count($arrP)) {
                                $arrP[$key][$key2] = $arrP[$key - 1][$key2];
                            }else{
                                $arrP[$key][$key2] = $arrP[$key - 1][$key2];
                            }
                        }
                    }
                }
                break;
           
            default:
                # code...
                break;
        }

        $this->writeToPHPExcel($arrP, $filePathIn, $chose);
        return  $handleFile->handle(explode(".",$filePathIn)[0]."_".$chose.".xlsx", explode(".",$filePathOut)[0]."_".$chose.".xlsx");
    }

    public function getRowRepeatMost($arrP, $column, $numberRows){

        $arrDem = array();

        for ($i=2; $i <= $numberRows ; $i++) { 
            if($arrP[$i][$column] !=null){
                if(array_key_exists((int)$arrP[$i][$column], $arrDem)){
                    $arrDem[$arrP[$i][$column]]++;
                }else{
                    $arrDem[$arrP[$i][$column]] = 1;
                }
            }
        }
        return array_search (max($arrDem), $arrDem);
        
    }

    public function writeToPHPExcel($array_data, $filePathIn, $chose){

        // Load file product_import.xlsx lên để tiến hành ghi file
        // $objPHPExcel = IOFactory::load($filePathIn);
        // $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // //Lấy ra số dòng cuối cùng
        // $Totalrow = $sheet->getHighestRow();
        // //Lấy ra tên cột cuối cùng
        // $LastColumn = $sheet->getHighestColumn();
        // var_dump($LastColumn);die();
        $spreadsheet = new Spreadsheet();

        // ADD DATA TO SPECIFIC CELL
        $indexRow = 1;
        foreach ($array_data as $value) {

            foreach ($value as $key2 => $value2) {
                $spreadsheet->getActiveSheet()->setCellValue($key2.$indexRow, $value2);
            }
            $indexRow++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(explode(".",$filePathIn)[0]."_".$chose.".xlsx");

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
        
        $PathFileOutput = new PathFileOutput();

        $listPath = $PathFileOutput->getListPath($model->id);

        $arrXls_data = array();

        foreach ($listPath as $key => $value) {
            $arrXls_data[$key]['file'] = $dm->readFileExcel($value['pathFileOutput']);
            $arrXls_data[$key]['time'] = $value['type_upload'];
            $fileName1 = explode( '.', $value['pathFileOutput'])[0];
            $arrXls_data[$key]['type'] = substr($fileName1,-1);
        }

        return $this->render('view', [
            'model' => $model, 
            'arrXls_data' => $arrXls_data
        ]);
    }

    /**
     * Creates a new DataModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        //$arrChose = ["1","3"];
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
            echo "<pre>";

            $arrChose = Yii::$app->request->post()['DataModel']['choseTypeUpdate'];
            // Determine fileName
            $component = explode('.',$model->uploadFile->name);
            $fileName = $component[0].'_'.$suffix.'.'.$component[1];
            $model->file_name  =    $fileName;
            $fileNameOut = $component[0].'_'.$suffix.'.'.'xlsx';

            // Determine path Input and Output
            $pathFileInput   =   Yii::$app->basePath.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileInput'.DIRECTORY_SEPARATOR.$fileName;
            $pathFileOutput  =   Yii::$app->basePath.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileOutput'.DIRECTORY_SEPARATOR.$fileNameOut; 
            $arrayTime = array();
            
            $model->create_at   =   $datetime;
            $model->update_at   =   $datetime; 

            $uploadSuccess = true;
            foreach ($arrChose as $key => $value) {
                $startTime = time();
                $this->upload($model->uploadFile, $pathFileInput, $pathFileOutput, $value);
                $endTime =time();
                $arrayTime[$value] = $endTime - $startTime;
            }

            
            $model->run_time = $endTime - $startTime;
            if( $uploadSuccess){
                if($model->save()){
                    
                    foreach ($arrChose as $key => $value) {
                        $pathFileInputsModel = new PathFileInput();
                        $pathFileOutputsModel = new PathFileOutput();
                        $pathFileInputsModel->data_model_id = $model->id;
                        $pathFileOutputsModel->data_model_id = $model->id;
                        $pathFileInputsModel->type_upload = $arrayTime[$value];
                        $pathFileOutputsModel->type_upload = $arrayTime[$value];
                        $pathFileInputsModel->pathFileInput = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileInput'.DIRECTORY_SEPARATOR.explode(".",$fileName)[0]."_".$value.".xlsx";
                        $pathFileInputsModel->save(false);

                        $pathFileOutputsModel->pathFileOutput = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'fileOutput'.DIRECTORY_SEPARATOR.explode(".",$fileName)[0]."_".$value.".xlsx";
                        $pathFileOutputsModel->save(false);
                    }
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
