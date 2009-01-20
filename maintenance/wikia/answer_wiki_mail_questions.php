<?php
/**
 * Additional script for UserChangesHistory, used for ticket #3078
 * Looks for earliest edit for every user on every wiki
 * First edit is taken as a registration wiki
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: David Pean
 *
 * @copyright Copyright (C) 2009, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

function wfMailNewQuestions( $user, $subject, $body ){
	
	$headers = "From: $wgEmailFrom\n";
	$headers .= "Reply-To: $wgEmailFrom\n";
	$headers .= "Return-Path:$wgEmailFrom\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
	
	mail( $user->getEmail(), $subject, $body, $headers );
	return 1;
}

/** */
echo "email questions start...\n\n";

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$optionsWithArgs = array( 'group','time' );

$dbr = wfGetDB( DB_SLAVE );

if ( !isset($options['group']) ){
	die( "Send users of a group an email containing newest created questions.\n
		  Usage: php answer_wiki_mail_questions.php --conf localsettings --group='ninjas'

		  --group    Wiki group name you want to send emails to\n
		 ");
}

$group = $options['group'];
$days = 1;
$subject = "New answer.wikia Questions";
$time_start = microtime(true);

//calculate cutoff time

$cutoff_unixtime = time() - ( $days * 86400 );
//$cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
$cutoff = $dbr->timestamp( $cutoff_unixtime );

//GET PAGES FOR EMAIL BODY
list ($page,$recentchanges) = $dbr->tableNamesN('page','recentchanges');
$res = $dbr->select( "$page, $recentchanges ", 
		array( 'page_title','rc_timestamp' ),
	array("page_id = rc_cur_id","rc_new" => 1, 'rc_timestamp >= ' . $dbr->addQuotes( $cutoff ), "page_namespace" => NS_MAIN, "page_is_redirect" => 0 ), __METHOD__, 
	array("ORDER BY" => "rc_timestamp desc", "LIMIT" => 10 )
);

$body = "<div><b>New Questions on answer.wikia.com</b></div>
	<div><a href=\"" . SpecialPage::getTitleFor( 'Recentchanges' )->escapeFullURL() . "\">See all changes</a></div><p>";
	
while ($row = $dbr->fetchObject( $res ) ) {
	$title = Title::newFromDBKey( $row->page_title );
	
	$body .= "<div style='padding-bottom:4px;'>* <a href=\"" . $title->escapeFullURL() . "\">" . $title->getText() . "</a> | <a href=\"" . $title->escapeFullURL("action=edit") . "\">" . "Answer this" . "</a> | <a href=\"" . $title->escapeFullURL("action=delete") . "\">" . wfMsg("delete") . "</a></div>";
}

//BUILD LIST OF ALL USERS IN THIS GROUP
$groups = User::getAllGroups();
if( !in_array( $group, $groups ) ){
	//die("Group '$group' does not exist!\n");
}

list ($user,$user_groups) = $dbr->tableNamesN('user','user_groups');
$res = $dbr->select( "$user_groups  LEFT JOIN $user ON user_id=ug_user", 
		array( 'user_name','user_id' ),
	array("ug_group"=>$group), __METHOD__, 
	""
);

$emails_sent = 0;
while ($row = $dbr->fetchObject( $res ) ) {
	
	$user = User::newFromName( $row->user_name );
	$user->load();
	if( $user->getEmail() ){
		wfMailNewQuestions( $user, $subject, $body );
		$emails_sent++;
	}
	//echo $row->user_name . " (" . $user->getEmail(). ")\n";
}

$time = microtime(true) - $time_start;
echo "Sent $emails_sent email(s). Execution time: $time seconds\n";
?>