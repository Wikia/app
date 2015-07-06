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

echo "this script is deprecated since it's unable to determine the difference between a user property, flag, and preference\n";
exit(1);
$optionsWithArgs = array( "from", "to" );
ini_set('include_path', dirname(__FILE__) . '/..' );
require_once('commandLine.inc');
	
$clearcache = isset($options['clearcache']);

// get preferences
$default_keys = array('conf', 'help', 'force', 'quiet', 'from', 'to', 'founder', 'clearcache', 'memory-limit');
$preferences = array();	//pairs key=value
foreach($options as $key => $value) {
	if (!in_array($key, $default_keys))
		$preferences[$key] = $value;
}

if (isset($options['help']) || (empty($preferences) && !$clearcache)) {
	die( "Usage: php setUserOptions.php --adoptionmails=1 --founderemails-joins-%=1 [--from=12345] [--to=12345] [--founder] [--clearcache] [--quiet] [--force]

		  --founder       get unique founders from active wikis
		  --clearcache    clear user cache only
		  --from          get data from user_id if not set founder or city_id if founder is set
		  --to            get data to user_id if not set founder or city_id if founder is set
		  --help          you are reading it right now
		  --force         overwrite existing option
		  --quiet         do not print anything to output\n\n");
}

$founder = isset($options['founder']);
$force = isset($options['force']);
$quiet = isset($options['quiet']);
$from  = $options['from'];
$to  = $options['to'];

if (!$quiet && !empty($preferences))
	echo 'Preferences: '.var_export($preferences, TRUE)."\n";

$limitUsers = array();	//WHERE in SQL
$dbr = WikiFactory::db(DB_SLAVE);
if ($founder) {
	$limitUsers = array("city_founding_user != 0", "city_founding_user is not null", "city_public = 1");
	if ($from)
		$limitUsers[] = "city_id >= $from";
	if ($to)
		$limitUsers[] = "city_id <= $to";
	
	// SELECT in SQL
	if($clearcache)
		$selectUsers = 'distinct city_founding_user as user_id';
	else
		$selectUsers = array('city_id', 'city_founding_user as user_id');
		
	$res = $dbr->select(
		'city_list',
		$selectUsers,
		$limitUsers,
		__METHOD__
	);
} else {
	if ($from)
		$limitUsers[] = "user_id >= $from";
	if ($to)
		$limitUsers[] = "user_id <= $to";
	if (empty($limitUsers))
		$limitUsers = '';
	
	$res = $dbr->select(
		'`user`',
		'user_id',
		$limitUsers,
		__METHOD__
	);
}

$count = 0;


while ($row = $dbr->fetchObject($res)) {
	$user = User::newFromId($row->user_id);
	$user->load();
	if ( $user instanceof User and $user->getId() > 0 ) {
		if ($clearcache) {
			$user->invalidateCache();
			$count++;
			if (!$quiet) {
				echo "Clear cache for user {$user->getName()} (id:{$user->getId()}).\n";
			}
		} else {
			$optionsChanged = 0;
			foreach ($preferences as $key => $val) {
				if (isset($row->city_id))
					$key = str_replace('%', $row->city_id, $key);
				$old_val = $user->getOption($key, null);
				if ( ($force && $old_val !== $val) || $old_val === null ) {
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
	}
	wfWaitForSlaves();
}

if (!$quiet) {
	echo "Updated $count users.\n";
}