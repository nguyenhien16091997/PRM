<?php

use yii\db\Migration;

/**
 * Class m190509_113827_add_column_typeUpload_to_path_input
 */
class m190509_113827_add_column_typeUpload_to_path_input extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('path_file_input', 'type_upload', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190509_113827_add_column_typeUpload_to_path_input cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190509_113827_add_column_typeUpload_to_path_input cannot be reverted.\n";

        return false;
    }
    */
}
