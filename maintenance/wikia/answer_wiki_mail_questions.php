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

function wfMailQuestions( $user, $subject, $body ){

	$headers = "From: $wgEmailFrom\n";
	$headers .= "Reply-To: $wgEmailFrom\n";
	$headers .= "Return-Path:$wgEmailFrom\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\n";

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
$subject = "New Questions on $wgSitename";
$edits_subject = "Edited Questions on $wgSitename";

$time_start = microtime(true);

//calculate cutoff time

$cutoff_unixtime_start = time() - ( $days * 86400 );
$cutoff_unixtime_start = $cutoff_unixtime_start - ($cutoff_unixtime_start % 86400);
$cutoff_unixtime_end = $cutoff_unixtime_start + ( $days * 86400 );

$cutoff_start = $dbr->timestamp( $cutoff_unixtime_start );
$cutoff_end = $dbr->timestamp( $cutoff_unixtime_end );

//GET PAGES FOR EMAIL BODY
//NEW QUESTIONS
list ($page,$recentchanges) = $dbr->tableNamesN('page','recentchanges');
$res = $dbr->select( "$page, $recentchanges ",
		array( 'page_title','rc_timestamp' ),
		array("page_id = rc_cur_id","rc_new" => 1, 'rc_timestamp >= ' . $dbr->addQuotes( $cutoff_start ),
			'rc_timestamp <= ' . $dbr->addQuotes( $cutoff_end ),
			"page_namespace" => NS_MAIN, "page_is_redirect" => 0 ), __METHOD__,
	array("ORDER BY" => "rc_timestamp desc"  )
);

$body = "<table cellpadding='5'><tr><td><b>New Questions on answer.wikia.com</b><br><br></td></tr>
	<tr><td><a href=\"" . htmlspecialchars(SpecialPage::getTitleFor( 'Recentchanges' )->getFullURL()) . "\">" . wfMsg("see_all_changes") . "</a><br><br></td></tr>";

while ($row = $dbr->fetchObject( $res ) ) {
	$title = Title::newFromDBKey( $row->page_title );

	$body .= "<tr><td height='30' style='border-bottom:1px solid #eeeeee'>* <b><a href=\"" . htmlspecialchars($title->getFullURL()) . "\">" . $title->getText() . "</a></b> | <a href=\"" . htmlspecialchars($title->getFullURL("action=edit")) . "\">" . wfMsg("answer_this_question") . "</a> | <a href=\"" . htmlspecialchars(SpecialPage::getTitleFor( 'Movepage', $title->getText() )->getFullURL()) . "\">" . wfMsg("movepagebtn") . "</a> | <a href=\"" . htmlspecialchars($title->getFullURL("action=delete")) . "\">" . wfMsg("delete") . "</a></td></tr>\n";
}
$body .= "</table>";

//ALL EDITS
$res = $dbr->select( "$page, $recentchanges ",
		array( 'page_title','rc_timestamp' ),
		array("page_id = rc_cur_id","rc_new" => 0, 'rc_timestamp >= ' . $dbr->addQuotes( $cutoff_start ),
			'rc_timestamp <= ' . $dbr->addQuotes( $cutoff_end ),
			"page_namespace" => NS_MAIN, "page_is_redirect" => 0 ), __METHOD__,
	array("ORDER BY" => "rc_timestamp desc"  )
);

$edits_body = "<table cellpadding='5'><tr><td><b>Edited Questions on answer.wikia.com</b><br><br></td></tr>
	<tr><td><a href=\"" . htmlspecialchars(SpecialPage::getTitleFor( 'Recentchanges' )->getFullURL()) . "\">" . wfMsg("see_all_changes") . "</a><br><br></td></tr>";

$edits = array();
while ($row = $dbr->fetchObject( $res ) ) {
	$title = Title::newFromDBKey( $row->page_title );
	if( in_array( $row->page_title, $edits ) ) continue;
	$edits_body .= "<tr><td height='30' style='border-bottom:1px solid #eeeeee'>* <b><a href=\"" . htmlspecialchars($title->getFullURL()) . "\">" . $title->getText() . "</a></b> | <a href=\"" . htmlspecialchars($title->getFullURL("action=edit")) . "\">" . wfMsg("answer_this_question") . "</a> | <a href=\"" . htmlspecialchars(SpecialPage::getTitleFor( 'Movepage', $title->getText() )->getFullURL()) . "\">" . wfMsg("movepagebtn") . "</a> | <a href=\"" . htmlspecialchars($title->getFullURL("action=delete")) . "\">" . wfMsg("delete") . "</a></td></tr>\n";
	$edits[] = $row->page_title;
}
$edits_body .= "</table>";

//BUILD LIST OF ALL USERS IN THIS GROUP
$groups = User::getAllGroups();
if( !in_array( $group, $groups ) ){
	//die("Group '$group' does not exist!\n");
}

list ($user,$user_groups) = $dbr->tableNamesN('user','user_groups');
$res = $dbr->select( "$user_groups  LEFT JOIN $user ON user_id=ug_user",
		array( 'user_name','user_id' ),
	array("ug_group"=>$group ), __METHOD__,
	""
);

$emails_sent = 0;
while ($row = $dbr->fetchObject( $res ) ) {

	$user = User::newFromName( $row->user_name );
	$user->load();
	if( $user->getEmail() ){
		wfMailQuestions( $user, $subject, $body );
		wfMailQuestions( $user, $edits_subject, $edits_body );
		$emails_sent++;
	}
	//echo $row->user_name . " (" . $user->getEmail(). ")\n";
}

$time = microtime(true) - $time_start;
echo "Sent $emails_sent email(s). Execution time: $time seconds\n";
?>