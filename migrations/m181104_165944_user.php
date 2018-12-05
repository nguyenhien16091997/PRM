<?php

use yii\db\Migration;

/**
 * Class m181019_153959_user
 */
class m181104_165944_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            /**
             * User authenication
             */
            'id'            => $this->primaryKey(),
            'username'      => $this->string()->unique(),
            'password'      => $this->string(),
            'email'         => $this->string()->unique(),
            'access_token'  => $this->string(),
            'auth_key'      => $this->string(),
            'status'        => $this->smallInteger()->defaultValue(1),

            /**
             * User profile
             */
            'fullname'      => $this->string(),
            'gender'        => $this->smallInteger()->defaultValue(0),
            'date_of_birth' => $this->date(),
            'address'       => $this->string(),
            'phone_number'  => $this->string(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181019_153959_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181019_153959_users cannot be reverted.\n";

        return false;
    }
    */
}
