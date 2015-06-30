<?php
if(!is_writable('Wysiwyg.log')) {
	echo 'Error 2';
	exit();
}

require_once( "../commandLine.inc" );

if(!function_exists('readline')){
	function readline($str = ""){
		print "$str";
		return rtrim(fgets(STDIN));
	}
}

$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

echo "Get id and creation date for all wikis with Wysiwyg enabled\n";
$res = $dbr->select(
		array('city_variables', 'city_list'),
		'cv_city_id, city_created, city_dbname',
		array("cv_value = 'b:1;'", "cv_variable_id = 637", "cv_city_id = city_id")
	);

$wikis = array();
while($row = $dbr->fetchObject($res)) {
	$wikis[$row->cv_city_id] = array('id' => $row->cv_city_id, 'dbname' => $row->city_dbname, 'created' => strtotime($row->city_created));
}
$dbr->freeResult($res);
echo "Wysiwyg is enabled for ".count($wikis)." wikis\n";

echo "Get the Wysiwyg enabling time for each wiki\n";
$res = $dbr->select(
		'city_list_log',
		'cl_city_id, cl_timestamp',
		"cl_text like '%wgEnableWysiwygExt%' and (cl_text like '%set value: true' or cl_text like '%to true')"
	);

while($row = $dbr->fetchObject($res)) {
	$cl_timestamp = strtotime($row->cl_timestamp);

	// We are interested only in wikis which has Wysiwyg enabled now
	if(isset($wikis[$row->cl_city_id])) {
		// Wysiwyg enabling time shouldn't be lower then wiki creation time
		if($cl_timestamp < $wikis[$row->cl_city_id]['created']) {
			echo "Error 1";
			exit();
		}
		if(!isset($wikis[$row->cl_city_id]['enabled'])) {
			$wikis[$row->cl_city_id]['enabled'] = $cl_timestamp;
		} else {
			if($cl_timestamp < $wikis[$row->cl_city_id]['enabled']) {
				$wikis[$row->cl_city_id]['enabled'] = $cl_timestamp;
			}
		}
	}
}
$dbr->freeResult($res);

echo "Get list of users which made at least one edit since Wysiwyg has been enabled on particular wiki\n";
$users = array();
foreach($wikis as $wiki) {
	if(isset($wiki['enabled'])) {
		$timestamp = $wiki['enabled'];
	} else {
		$timestamp = $wiki['created'];
	}
	$dbr = wfGetDB( DB_SLAVE, array(), $wiki['dbname'] );
	$res = $dbr->select(
			'revision',
			'rev_user',
			array('rev_timestamp > '.gmdate('YmdHis', $timestamp)),
			null,
			array('GROUP BY' => 'rev_user')
		);
	while($row = $dbr->fetchObject($res)) {
		$users[] = $row->rev_user;
	}
	$dbr->freeResult($res);
}
$users = array_unique($users);
echo "There is ".count($users)." such users\n";

echo "Exclude users which has disabled Wysiwyg in their preferences\n";
$usersNew = array();
foreach($users as $idx => $user) {
	$oUser = User::newFromId($user);
	if(!$oUser->getGlobalPreference('disablewysiwyg')) {
		$usersNew[] = $user;
	}

}

$fp = fopen('Wysiwyg.log', 'w');

echo "Now there is ".count($usersNew)." users\n";
if(trim(readline("Please enter 'blabla' to continue and enable Wysiwyg for those users using new variable\n")) == 'blabla') {
	foreach($usersNew as $user) {
		fwrite($fp, $user."\n");
		$oUser = User::newFromId($user);
		$oUser->setGlobalPreference("EnableWysiwyg", true);
		$oUser->saveSettings();
		$oUser->invalidateCache();
	}

} else {
	echo 'exit';
}

fclose($fp);
