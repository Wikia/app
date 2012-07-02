<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MSSQLBackCompat',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MSSQLBackCompat',
	'author' => 'Sam Reed',
	'description' => 'Back compat hack for those that need non core MSSQL support (SMW, ED or something)',
);

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['DatabaseMssqlold'] = $dir . 'DatabaseMssqlOld.php';
$wgAutoloadClasses['MSSQLOldField'] = $dir . 'DatabaseMssqlOld.php';