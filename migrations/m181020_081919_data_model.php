<?php

use yii\db\Migration;

/**
 * Class m181020_081919_data_model
 */
class m181020_081919_data_model extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('data_model', [
            'id'        =>  $this->primaryKey(),
            'name'      =>  $this->string()->unique(),
            'file_name' =>  $this->string(),
            'pathFileInput'  =>  $this->string(),
            'pathFileOutput' =>  $this->string(),
            'userName'  => $this->string(),
            'note'      =>  $this->string(),    
            'create_at' =>  $this->dateTime(),
            'update_at' =>  $this->dateTime(),
            'update_end_by' =>$this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181020_081919_data_model cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181020_081919_data_model cannot be reverted.\n";

        return false;
    }
    */
}
