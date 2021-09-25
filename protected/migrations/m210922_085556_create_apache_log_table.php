<?php

class m210922_085556_create_apache_log_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('apache_log', [
            'id' => 'pk',
            'ip' => 'varbinary(16) NOT NULL',
            'datetime' => 'datetime',
            'query' => 'varchar(255)',     
            'hostname' => 'varchar(255)',
            'remotename' => 'varchar(255)',
            'user' => 'varchar(255)',
            'status' => 'int(3) ',
            'size' => 'int(10)',
            'server' => 'varchar(255)',        
            'referer' => 'varchar(255)',
            'useragent' => 'varchar(255)',
                'UNIQUE KEY `uniq` (`datetime`, `query`)'        
        ]);
    
    }

    public function down()
    {
        $this->dropTable('apache_log');
    }
}
