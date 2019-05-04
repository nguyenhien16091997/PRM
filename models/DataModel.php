<?php

namespace app\models;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;

/**
 * This is the model class for table "data_model".
 *
 * @property int $id
 * @property string $name
 * @property string $pathFileInput
 * @property string $pathFileOutput
 * @property string $userName
 * @property string $note
 * @property string $create_at
 * @property string $update_at
 * @property string $update_end_by
 */
class DataModel extends \yii\db\ActiveRecord
{
    public $uploadFile;
    public $choseColumn;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name','create_at', 'update_at', 'update_end_by'], 'safe'],
            [['name', 'pathFileInput', 'pathFileOutput', 'userName', 'note'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['name'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'file_name'=>'File Name',
            'pathFileInput' => 'Path File Input',
            'pathFileOutput' => 'Path File Output',
            'userName' => 'User Name',
            'note' => 'Note',
            'run_time' => 'Run Time',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_end_by' => 'Update End By',
            'choseColumn'   => 'Please Chose Column'
        ];
    }

    public function readFileExcel($pathFile){
        $spreadsheet = IOFactory::load(Yii::$app->basePath.$pathFile);

        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        return $xls_data;
    }
}
