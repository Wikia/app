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

//variables
$limitUsers = '';	//WHERE in SQL
$preferences = array('adoptionmails' => '1');	//pairs key=value
///

ini_set('include_path', dirname(__FILE__) . '/..' );
require_once('commandLine.inc');

if (isset($options['help'])) {
	die( "Usage: php setUserOptions.php [--quiet] [--force]

		  --help     you are reading it right now
		  --force    overwrite existing option
		  --quiet    do not print anything to output\n\n");
}


$force = isset($options['force']);
$quiet = isset($options['quiet']);
$from  = isset($options['from']);

if( isset( $from ) ) {
  $limitUsers = array( 'user_id >= $from' );
}
$dbr = WikiFactory::db(DB_SLAVE);
$res = $dbr->select(
	'user',
	'user_id',
	$limitUsers,
	__METHOD__
);

$count = 0;


while ($row = $dbr->fetchObject($res)) {
	$user = User::newFromId($row->user_id);
	if ($user) {
		$optionsChanged = 0;
		foreach ($preferences as $key => $val) {
			if ($force || $user->getOption($key, null) === null) {
				$user->setOption($key, $val);
				$optionsChanged++;
				if (!$quiet) {
					echo "Setting preference '$key' to '$val' for user {$user->getName()} (id:{$user->getId()}).\n";
				}
			}
		}
		if ($optionsChanged) {
			$user->saveSettings();
			$user->invalidateCache();
			$count++;
		}
	}
	usleep( 5000 );
}

if (!$quiet) {
	echo "Updated options for $count users.\n";
}