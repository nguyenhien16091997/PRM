<?php

use yii\db\Migration;

/**
 * Class m190504_093355_add_runTime_to_data_model
 */
class m190504_093355_add_runTime_to_data_model extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('data_model', 'run_time', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190504_093355_add_runTime_to_data_model cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190504_093355_add_runTime_to_data_model cannot be reverted.\n";

        return false;
    }
    */
}
