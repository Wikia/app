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

	echo ".\n";

	$config = unserialize($user->getOption('widgets'));

	if(!empty($config) && is_array($config)) {
		if(empty($config[1]) && !is_array($config[1])) {
			$config[1] = array();
			echo "error.2\n";
		}


		$out = array();
		$da = false;
		foreach($config[1] as $val) {
		        if($val['type'] != 'WidgetLeftNav') {
        		        $out[] = $val;
		        }

		        if($val['type'] == 'WidgetCommunity' && !$da) {
                		$out[] = array('type'=>'WidgetLeftNav', 'id'=>205);
		                $da = true;
		        }
		}
		if(!$da) {
		        array_unshift($out, array('type'=>'WidgetLeftNav', 'id'=>205));
			echo "error.3\n";
		}
		$config[1] = $out;
		$user->setOption('widgets', serialize($config));
		$user->saveSettings();
		$user->invalidateCache();
		$dbw = wfGetDB(DB_MASTER);
		$dbw->commit();
	}
}

$dbw = wfGetDB(DB_MASTER);
$dbw->commit();
