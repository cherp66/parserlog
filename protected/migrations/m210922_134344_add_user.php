<?php

class m210922_134344_add_user extends CDbMigration
{
    public function up()
    {
        $this->insert('user',
            [
             'username' => 'demo', 
             'password' => '$2a$10$JTJf6/XqC94rrOtzuF397OHa4mbmZrVTBOQCmYD9U.obZRUut4BoC',
             'token' => md5(microtime(true))
            ]
        );
    }

    public function down()
    {
        $this->truncateTable('user');
    }
}