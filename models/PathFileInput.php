<?php

namespace app\models;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;

/**
 * This is the model class for table "path_file_input".
 *
 * @property string $data_model_id
 * @property string $pathFileInput
 * @property string $create_at
 * @property string $update_at
 * @property string $update_end_by
 */
class PathFileInput extends \yii\db\ActiveRecord
{
    public $uploadFile;
    public $choseColumn;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'path_file_input';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at', 'update_end_by'], 'safe'],
            [['data_model_id', 'pathFileInput'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'data_model_id' => 'Data Model Id',
            'pathFileInput'=>'Path File Input',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'update_end_by' => 'Update End By',
        ];
    }


}
