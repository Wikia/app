<?php

require_once( "../commandLine.inc" );

if(!function_exists('readline')){
	function readline($str = ""){
		print "$str";
		return rtrim(fgets(STDIN));
	}
}

$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

$res = $dbr->select(
		'user',
		'user_id'
	);

while($row = $dbr->fetchObject($res)) {

	$user = User::newFromId($row->user_id);

	echo '.';

	$config = unserialize($user->getOption('widgets'));

	if(!empty($config) && is_array($config)) {
		if(empty($config[1]) && !is_array($config[1])) {
			$config[1] = array();
		}
		$hasWidgetMagCloud = false;
		foreach($config[1] as $val) {
			if($val['type'] == 'WidgetMagCloud') {
				$hasWidgetMagCloud = true;
				break;
			}
		}
		if(!$hasWidgetMagCloud) {
			array_unshift($config[1], array('type' => 'WidgetMagCloud', 'id' => 143));
			$user->setOption('widgets', serialize($config));
			$user->saveSettings();
			$user->invalidateCache();
		}
	}
}

$dbw = wfGetDB(DB_MASTER);
$dbw->commit();
