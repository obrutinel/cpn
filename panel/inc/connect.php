<?php

$cfg['db_prefix']='wagaia_';
//mysql_connect($cfg['db_host'],$cfg['db_user'],$cfg['db_pass']);
mysql_connect(DB_SERVER,DB_USER,DB_PASS);
mysql_select_db(DB_NAME);
mysql_query( 'SET NAMES UTF-8' );
$db_prefix=$cfg['db_prefix'];
global $db_prefix;
?>