<?php
/**
 * Additional script for shoutbox widget, used for ticket #3813
 * Use host name (muppet.wikia.com) to find wikia cityId
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Maciej 'Macbre' Brencz <macbre at wikia-inc.com>
 *
 */

require_once(dirname(__FILE__) . '/../commandLine.inc');

$time_start = microtime(true);

$dbr = wfGetDB(DB_SLAVE);
$dbw = wfGetDB(DB_MASTER);

// get messages with city = NULL
echo "#1: Get list of shoutbox messages not yet converted from host name to cityId\n";
$messages = $dbr->select(wfSharedTable('shout_box_messages'), array('id', 'wikia'), array( 'city' => NULL ), 'shoutbox_host_to_city_id');

// update city value
echo "#2: Update each message (set city value based on hostname)\n";
$messagesCount = 0;
while ($msg = $dbr->fetchObject($messages) ) {
	
	$url = "http://{$msg->wikia}/";

	switch($url) {
		case 'http://wikia.com/':
			$city = 177;
			break;
		default:
			$city = $dbr->selectField(wfSharedTable('city_list'), array('city_id'), array('city_url' => $url), 'shoutbox_host_to_city_id'); 
	}

	if (is_numeric($city)) {
		$dbw->update(wfSharedTable('shout_box_messages'), array('city' => $city), array('id' => $msg->id), 'shoutbox_host_to_city_id');
		$messagesCount++;
		echo "\t{$url} -> {$city}\n";
	}
	else {
		echo "\t{$url} -> ERROR!\n";
	}
}

// make sure we commit transaction
$dbw->commit();

$time = microtime(true) - $time_start;
echo "#3: Updated " . count($messagesCount) . " messages. Execution time: $time seconds\n";
