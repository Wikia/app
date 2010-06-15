<?php
/**
 * One-time script to move data from different tables uded by different spam tools into one
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 *
 */

require_once(dirname(__FILE__) . '/../commandLine.inc');

$time_start = microtime(true);

define('TYPE_CONTENT', 1);
define('TYPE_SUMMARY', 2);
define('TYPE_TITLE', 4);
define('TYPE_USER', 8);
define('TYPE_ANSWERS_QUESTION', 16);
define('TYPE_ANSWERS_WORDS', 32);
define('TYPE_WIKI_CREATION', 64);

$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

//id, author_id, text, type, timestamp, expire, exact, regex, case, reason, lang
$insert = "INSERT INTO phalanx VALUES (NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);";
$inserts = array();

////////////////////////////////

echo "-- [1/x] table for: extensions/3rdparty/SpamList/SpamList_helper.php AND extensions/wikia/RegexBlock/RegexBlock.php\n";
$data = $dbr->select(
	array('blockedby', 'user'),
	array('blckby_name', 'blckby_timestamp', 'blckby_expire', 'blckby_create', 'blckby_exact', 'blckby_reason', 'user_id'),
	'',
	__METHOD__,
	'',
	array('user' => array('LEFT JOIN', 'blckby_blocker=user_name'))
);

while ($row = $dbr->fetchObject($data)) {
	$expire = $row->blckby_expire == 'infinite' ? 'NULL' : $dbr->AddQuotes($row->blckby_expire);
	$inserts[] = sprintf($insert,
		$dbr->AddQuotes($row->user_id),				//author_id
		$dbr->AddQuotes($row->blckby_name),			//text
		TYPE_USER,									//type
		$dbr->AddQuotes($row->blckby_timestamp),	//timestamp
		$expire,									//expire
		$dbr->AddQuotes($row->blckby_exact),		//exact
		1,											//regex
		0,											//case
		$dbr->AddQuotes($row->blckby_reason),		//reason
		'NULL'										//lang
	);
}

if ($data !== false) {
	$dbr->FreeResult($data);
}

////////////////////////////////

echo "-- [2/x] table for: extensions/SpamRegex/SpamRegex.php\n";
$data = $dbr->select(
	array('spam_regex', 'user'),
	array('spam_text', 'spam_timestamp', 'spam_textbox', 'spam_summary', 'user_id'),
	'',
	__METHOD__,
	'',
	array('user' => array('LEFT JOIN', 'spam_user=user_name'))
);

while ($row = $dbr->fetchObject($data)) {
	$type = 0;
	if ($row->spam_textbox) {
		$type |= TYPE_CONTENT;
	}
	if ($row->spam_summary) {
		$type |= TYPE_SUMMARY;
	}
	$inserts[] = sprintf($insert,
		$dbr->AddQuotes($row->user_id),				//author_id
		$dbr->AddQuotes($row->spam_text),			//text
		$type,										//type
		$dbr->AddQuotes($row->spam_timestamp),		//timestamp
		'NULL',										//expire
		0,											//exact
		1,											//regex
		0,											//case
		"'SpamRegex initial import'",				//reason
		'NULL'										//lang
	);
}

if ($data !== false) {
	$dbr->FreeResult($data);
}

////////////////////////////////

echo "-- [3/x] table for: extensions/TextRegex/TextRegex.php\n";
$dbrs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
$data = $dbrs->select(
	'text_regex',
	array('tr_text', 'tr_timestamp', 'tr_user', 'tr_subpage'),
	'tr_subpage = "creation"',
	__METHOD__
);

while ($row = $dbrs->fetchObject($data)) {
	$inserts[] = sprintf($insert,
		$dbr->AddQuotes($row->tr_user),				//author_id
		$dbr->AddQuotes($row->tr_text),				//text
		TYPE_WIKI_CREATION,							//type
		$dbr->AddQuotes($row->tr_timestamp),		//timestamp
		'NULL',										//expire
		0,											//exact
		1,											//regex
		0,											//case
		"'TextRegex initial import'",				//reason
		'NULL'										//lang
	);
}

if ($data !== false) {
	$dbrs->FreeResult($data);
}

////////////////////////////////
if (isset($options['verbose'])) echo(implode("\n", $inserts));
if (!isset($options['dryrun'])) {
	$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
	foreach ($inserts as $insert) {
		wfWaitForSlaves(5);
		$dbw->query($insert);
	}
	//make sure we commit transaction
	$dbw->commit();
}

$time = microtime(true) - $time_start;
echo "\n-- Execution time: $time seconds\n";