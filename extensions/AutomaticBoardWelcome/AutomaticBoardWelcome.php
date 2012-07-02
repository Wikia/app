<?php
/**
 * Automatic Board Welcome -- automatically posts a welcome message on new
 * users' user boards on account creation.
 * The message is sent by a randomly-chosen administrator (one who is a member
 * of the 'sysop' group).
 *
 * @file
 * @ingroup Extensions
 * @version 0.1.1
 * @date 30 July 2011
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Automatic Board Welcome',
	'version' => '0.1.1',
	'author' => 'Jack Phoenix',
	'descriptionmsg' => 'automaticboardwelcome-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Automatic_Board_Welcome',
);

$wgHooks['AddNewAccount'][] = 'wfSendUserBoardMessageOnRegistration';
/**
 * Send the message if the UserBoard class exists (duh!) and the welcome
 * message has some content.
 *
 * @param $user User: the new User object being created
 * @param $byEmail Boolean: true if the account was created by e-mail
 * @return Boolean: true
 */
function wfSendUserBoardMessageOnRegistration( $user, $byEmail ) {
	if ( class_exists( 'UserBoard' ) && $user instanceof User ) {
		$message = trim( wfMsgForContent( 'user-board-welcome-message' ) );

		// If the welcome message is empty, short-circuit right away.
		if( wfEmptyMsg( 'user-board-welcome-message', $message ) ) {
			return true;
		}

		// Just quit if we're in read-only mode
		if ( wfReadOnly() ) {
			return true;
		}

		$dbr = wfGetDB( DB_SLAVE );
		// Get all users who are in the 'sysop' group and aren't blocked from
		// the database
		$res = $dbr->select(
			array( 'user_groups', 'ipblocks' ),
			array( 'ug_group', 'ug_user' ),
			array( 'ug_group' => 'sysop', 'ipb_user' => null ),
			__METHOD__,
			array(),
			array(
				'ipblocks' => array( 'LEFT JOIN', 'ipb_user = ug_user' )
			)
		);

		$adminUids = array();
		foreach ( $res as $row ) {
			$adminUids[] = $row->ug_user;
		}

		// Pick one UID from the array of admin user IDs
		$random = array_rand( array_flip( $adminUids ), 1 );
		$sender = User::newFromId( $random );

		$senderUid = $sender->getId();
		$senderName = $sender->getName();

		// Send the message
		$b = new UserBoard();
		$b->sendBoardMessage(
			$senderUid, // sender's UID
			$senderName, // sender's name
			$user->getId(),
			$user->getName(),
			// passing the senderName as an argument here so that we can do
			// stuff like [[User talk:$1|contact me]] or w/e in the message
			wfMsgForContent( 'user-board-welcome-message', $senderName )
			// the final argument is message type: 0 (default) for public
		);
	}
	return true;
}