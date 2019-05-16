<?php

use yii\db\Migration;

/**
 * Class m190505_103006_table_path_file_output
 */
class m190505_103006_table_path_file_output extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('path_file_output', [
            'data_model_id'      =>  $this->string(),
            'pathFileOutput' =>  $this->string(),
            'create_at' =>  $this->dateTime(),
            'update_at' =>  $this->dateTime(),
            'update_end_by' =>$this->dateTime(),
            'PRIMARY KEY(data_model_id, pathFileOutput)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190505_103006_table_path_file_output cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190505_103006_table_path_file_output cannot be reverted.\n";

        return false;
    }
    */
}
