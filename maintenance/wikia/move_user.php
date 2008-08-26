<?php
/**
 * A really simple & ugly shell script for merging user contributions
 * and related stuff.
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Lucas 'TOR' Garczewski <tor@wikia.com>
 *
 * @copyright Copyright (C) 2007 Lucas 'TOR' Garczewski, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

$optionsWithArgs = array( 'from','to' );

require_once( "../commandLine.inc" );

function alterTable($table,$column,$from_val,$to_val){
  global $options, $wgDBname, $dbw;
  $query = "UPDATE LOW_PRIORITY IGNORE $table SET $column=$to_val WHERE $column=$from_val;";
  if ( isset($options['verbose']) ) print ($query. "\n");
  if ( !isset($options['dryrun']) ) $dbw->query($query);
}

if (!isset($options['from']) || !isset($options['to']) || $options['from'] == $options['to'])
	die( "Reassign edits from one user to another.\n
		  Usage: php move_user.php --from='name' --to='name' [--merge] [--verbose] [--dryrun]

		  --from     the current name of the user
		  --to       the name the user should end up with (must be different than from)
		  --merge    use if the 'to' account exists on Wikia
		  --verbose  print out information on each operation
		  --dryrun   do not perform and operations on the database\n\n");

$dbw =& wfGetDB( DB_MASTER );
$dbw->selectDB( $wgSharedDB );

$from_text = $dbw->addQuotes($options['from']);
$to_text = $dbw->addQuotes($options['to']);

# Check if "from" user exists
$res = $dbw->select('user','user_id','user_name = '. $from_text);
if ($row = $dbw->fetchObject($res)) {
	$from_id = $row->user_id;
} else {
	die("Fatal error: User $from_text not found in $wgSharedDB\n");
}

# Check if "to" user exists
$res = $dbw->select('user','user_id','user_name = '. $to_text);
if ($row = $dbw->fetchObject($res) xor isset($options['merge'])) {
	$error = "Fatal error: User $to_text ";
	$error .= (isset($options['merge'])) ? "doesn't exist. Cannot merge." : "exists. Cannot move.";
	$error .= "\n";
	die($error);
} else
		$to_id = $row->user_id;

$dbw->selectDB($wgDBname);

if (isset($options['merge'])) {
	# Change user IDs if merging two accounts
	alterTable($dbw->tableName( 'archive' ),"ar_user",$row->user_name,$newid,"ar_user_text");
	alterTable($dbw->tableName( 'filearchive' ),"fa_user",$row->user_id,$newid);
	alterTable($dbw->tableName( 'image' ),"img_user",$row->user_name,$newid,"img_user_text");
	alterTable($dbw->tableName( 'ipblocks' ),"ipb_user",$row->user_id,$newid);
	alterTable($dbw->tableName( 'logging' ),"log_user",$row->user_id,$newid);
	alterTable($dbw->tableName( 'oldimage' ),"oi_user",$row->user_name,$newid,"oi_user_text");
	alterTable($dbw->tableName( 'recentchanges' ),"rc_user",$row->user_name,$newid,"rc_user_text");
	alterTable($dbw->tableName( 'revision' ),"rev_user",$row->user_id,$newid);
	alterTable($dbw->tableName( 'user_groups' ),"ug_user",$row->user_id,$newid);
	alterTable($dbw->tableName( 'user_newtalk' ),"user_id",$row->user_id,$newid);
	alterTable($dbw->tableName( 'watchlist' ),"wl_user",$row->user_id,$newid);
} else {
	# Change user name in local and shared DB if not merging
	alterTable('user',"user_name",$from_text,$to_text);
	$dbw->selectDB( $wgSharedDB );
	alterTable('user',"user_name",$from_text,$to_text);
}

# Change user names in remaining tables
$dbw->selectDB($wgDBname);
alterTable('revision',"rev_user_text", $from_text, $to_text);
alterTable('image',"img_user_text", $from_text, $to_text);
alterTable('recentchanges',"rc_user_text", $from_text, $to_text);

# Move user pages if there is no exisitng page at the new location
$query = 'UPDATE LOW_PRIORITY IGNORE page set page_title='. $to_text.
	' where (page_namespace = 2 or page_namespace = 3) and page_title = '. $from_text. ';';

if ( isset($options['verbose']) ) print($query. "\n");
if (!isset($options['dryrun'])) $dbw->query($query);

$query = 'UPDATE LOW_PRIORITY IGNORE page set page_title=concat('. $to_text. ',' .
	'substring(page_title, '. (strlen($options['from']) + 1) .')) ' .
	'WHERE (page_namespace = 2 OR page_namespace = 3) and page_title like "'.
	$dbw->escapeLike($options['from']). '/%";';

if ( isset($options['verbose']) ) print($query. "\n");
if (!isset($options['dryrun'])) $dbw->query($query);

?>
