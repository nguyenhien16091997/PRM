<?php

namespace app\models;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;

/**
 * This is the model class for table "path_file_output".
 *
 * @property string $data_model_id
 * @property string $pathFileOutput
 * @property string $create_at
 * @property string $update_at
 * @property string $update_end_by
 */
class PathFileOutput extends \yii\db\ActiveRecord
{
    public $uploadFile;
    public $choseColumn;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'path_file_output';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at', 'update_end_by'], 'safe'],
            [['data_model_id', 'pathFileOutput'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'data_model_id' => 'Data Model Id',
            'pathFileOutput'=>'Path File Output',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_end_by' => 'Update End By',
        ];
    }

    public function getListPath($modelId)
    {
        
        $rows = (new \yii\db\Query())
                ->select(['*'])
                ->from('path_file_output')
                ->where(['data_model_id' => $modelId])
                ->limit(10)
                ->all();
        return $rows;
    }

}
