<?php
/**
 * setUserOptions
 * generic script to set option(s) for user(s)
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Marooned <marooned at wikia-inc.com>
 *
 */

$optionsWithArgs = array( "from", "to" );
ini_set('include_path', dirname(__FILE__) . '/..' );
require_once('commandLine.inc');
	
// get preferences
$default_keys = array('conf', 'help', 'force', 'quiet', 'from', 'to', 'founder');
$preferences = array();	//pairs key=value
foreach($options as $key => $value) {
	if (!in_array($key, $default_keys))
		$preferences[$key] = $value;
}

if (isset($options['help']) || empty($preferences)) {
	die( "Usage: php setUserOptions.php --adoptionmails=1 --founderemails-joins-%=1 [--from=12345] [--to=12345] [--founderemail] [--quiet] [--force]

		  --founder  get unique founders from active wikis
		  --from     get data from user_id if not set founder or city_id if founder is set
		  --to       get data to user_id if not set founder or city_id if founder is set
		  --help     you are reading it right now
		  --force    overwrite existing option
		  --quiet    do not print anything to output\n\n");
}

$founder = isset($options['founder']);
$force = isset($options['force']);
$quiet = isset($options['quiet']);
$from  = $options['from'];
$to  = $options['to'];

if (!$quiet)
	echo 'Preferences: '.var_export($preferences, TRUE)."\n";

$limitUsers = array();	//WHERE in SQL
if ($founder) {
	$dbr = WikiFactory::db(DB_SLAVE);
	$limitUsers = array("city_founding_user != 0", "city_founding_user is not null", "city_public = 1");
	if ($from)
		$limitUsers[] = "city_id >= $from";
	if ($to)
		$limitUsers[] = "city_id <= $to";
	
	$res = $dbr->select(
		'city_list',
		array('city_id', 'city_founding_user as user_id'),
		$limitUsers,
		__METHOD__
	);
} else {
	$dbr = wfGetDB( DB_SLAVE );
	if ($from)
		$limitUsers[] = "user_id >= $from";
	if ($to)
		$limitUsers[] = "user_id <= $to";
	if (empty($limitUsers))
		$limitUsers = '';
	
	$res = $dbr->select(
		'user',
		'user_id',
		$limitUsers,
		__METHOD__
	);
}

$count = 0;


while ($row = $dbr->fetchObject($res)) {
	$user = User::newFromId($row->user_id);
	if ($user) {
		$optionsChanged = 0;
		foreach ($preferences as $key => $val) {
			if (isset($row->city_id))
				$key = str_replace('%', $row->city_id, $key);
			$old_val = $user->getOption($key, null);
			if ($force || $old_val === null) {
				$user->setOption($key, $val);
				$optionsChanged++;
				if (!$quiet) {
					echo "Setting preference '$key' from '$old_val' to '$val' for user {$user->getName()} (id:{$user->getId()}).\n";
				}
			}
		}
		if ($optionsChanged) {
			$user->saveSettings();
			$user->invalidateCache();
			$count++;
		}
	}
	wfWaitForSlaves( 5 );
}

if (!$quiet) {
	echo "Updated options for $count users.\n";
}