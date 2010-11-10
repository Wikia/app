<?php
/**
 * sendEmailToUsers
 * Sends e-mail for users
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Marooned <marooned at wikia-inc.com>
 *
 */

require_once( dirname(__FILE__)."/../commandLine.inc" );
require_once( dirname(__FILE__)."/../../includes/UserMailer.php" );

$optionsWithArgs = array('list');

if (isset($options['help']) || !isset($options['list'])) {
	die( "Usage: php setUserOptions.php --list=file [--quiet]

		  --help       you are reading it right now
		  --list=file  path to .php file that will be included - has to provide $users array of $user_id => array($data)
		  --quiet      do not print anything to output\n\n");
}

include($options['list']);

if (!isset($users)) {
	die( 'Provided file did not contain $users variable.' );
}

foreach ($users as $userId => $userMails) {
	$type = $userMails > 1 ? 'second' : 'first';
	$user = User::newFromId($userId);
	$acceptMails = $user->getOption('adoptionmails', null);
	if ($acceptMails && $user->isEmailConfirmed()) {
		$user->sendMail(
			wfMsg("mail-$type-subject"),
			wfMsg("mail-$type-content"),
			null, //from
			null, //replyto
			'AutomaticWikiAdoption'
		);
	}
}