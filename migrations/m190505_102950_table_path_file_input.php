<?php

use yii\db\Migration;

/**
 * Class m190505_102950_table_path_file_input
 */
class m190505_102950_table_path_file_input extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('path_file_input', [
            'data_model_id'      =>  $this->string(),
            'pathFileInput' =>  $this->string(),
            'create_at' =>  $this->dateTime(),
            'update_at' =>  $this->dateTime(),
            'update_end_by' =>$this->dateTime(),
            'PRIMARY KEY(data_model_id, pathFileInput)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190505_102950_table_path_file_input cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190505_102950_table_path_file_input cannot be reverted.\n";

        return false;
    }
    */
}
