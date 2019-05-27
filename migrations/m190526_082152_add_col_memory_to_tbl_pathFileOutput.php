<?php

use yii\db\Migration;

/**
 * Class m190526_082152_add_col_memory_to_tbl_pathFileOutput
 */
class m190526_082152_add_col_memory_to_tbl_pathFileOutput extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('path_file_output', 'memory_upload', 'VARCHAR(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190526_082152_add_col_memory_to_tbl_pathFileOutput cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190526_082152_add_col_memory_to_tbl_pathFileOutput cannot be reverted.\n";

        return false;
    }
    */
}
