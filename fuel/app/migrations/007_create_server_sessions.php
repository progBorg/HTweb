<?php

namespace Fuel\Migrations;

class Create_server_sessions
{
	public function up()
	{
		\DBUtil::create_table('server_sessions', array(
			'session_id' => array('constraint' => 40, 'null' => false, 'type' => 'varchar'),
			'previous_id' => array('constraint' => 40, 'null' => false, 'type' => 'varchar'),
			'user_agent' => array('null' => false, 'type' => 'text'),
			'ip_hash' => array('constraint' => 32, 'null' => false, 'type' => 'char', 'default' => ''),
			'created' => array('constraint' => '10', 'null' => false, 'type' => 'int', 'unsigned' => true, 'default' => 0),
			'updated' => array('constraint' => '10', 'null' => false, 'type' => 'int', 'unsigned' => true, 'default' => 0),
			'payload' => array('null' => false, 'type' => 'longtext'),
		), array('session_id'));

		\DBUtil::create_index('server_sessions', array('previous_id'), 'PREVIOUS', 'UNIQUE');
	}

	public function down()
	{
		\DBUtil::drop_table('server_sessions');
	}
}