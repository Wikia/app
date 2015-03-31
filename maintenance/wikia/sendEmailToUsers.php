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

$optionsWithArgs = array('list');
$quiet = isset($options['quiet']);

if (isset($options['help']) || !isset($options['list'])) {
	die( "Usage: php sendEmailToUsers.php --list=file [--quiet]

		  --help       you are reading it right now
		  --list=file  path to .php file that will be included - has to provide $users array of $user_id => array($data)
		  --quiet      do not print anything to output\n\n");
}

include($options['list']);

if (!isset($users)) {
	die( 'Provided file did not contain $users variable.' );
}

$mails = array(
	'first' => array(
		'subject' => 'Oops, we sent you an email by mistake',
		'content' => 'We mistakenly sent you an email with the subject line “We haven’t seen you around in a while.”  Our team was running some tests and accidentally sent out these emails to inactive adminstrators.  Please disregard the message and accept our apologies for any confusion.  
 
The Wikia Team'
	),
	'second' => array(
		'subject' => 'Oops, we sent you some emails by mistake',
		'content' => 'We mistakenly sent you some emails with the subject line “We haven’t seen you around in a while.”  Our team was running some tests and accidentally sent out these emails to inactive adminstrators.  Please disregard the message and accept our apologies for any confusion.
 
The Wikia Team'
	)
);

if (!$quiet) {
	$count = count($users);
	echo "Processing $count users.\n";
}

foreach ($users as $userId => $userMails) {
	$type = $userMails > 1 ? 'second' : 'first';
	$user = User::newFromId($userId);
	$acceptMails = $user->getOption('adoptionmails', null);
	if (!$quiet) {
		$accept = $acceptMails ? 'is accepting `adoptionmails`' : 'is not accepting `adoptionmails`';
		$confirmed = $user->isEmailConfirmed() ? 'has confirmed e-mail' : 'has not confirmed e-mail';
		echo "User (ID:$userId) $acceptMails and $confirmed.\n";
	}

	if ($acceptMails && $user->isEmailConfirmed()) {
		$user->sendMail(
			$mails[$type]['subject'],
			$mails[$type]['content'],
			null, //from
			null, //replyto
			'AutomaticWikiAdoption'
		);
		if (!$quiet) {
			echo "Sent mail (type:$type) to user (ID:$userId).\n";
		}
	}
}