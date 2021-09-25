<?php

class m210922_133732_create_user_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => 'pk',
            'username' => 'varchar(128) NOT NULL',
            'password' => 'varchar(128) NOT NULL',
            'token' => 'varchar(32)',
               'UNIQUE KEY `login` (`username`)',
               'UNIQUE KEY `token` (`token`)'
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}