<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

$optionsWithArgs = array( 'uid' );
ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
	echo "Read-only mode - exiting.";
	exit( 1 );
}

if( isset( $options['uid'] ) ) {
	$uid = intval( $options['uid'] );
	if( $uid > 0 ) {
		$user = AdSS_User::newFromId( $uid );
		$password = AdSS_User::randomPassword();
		$user->newpassword = $user->cryptPassword( $password );
		$user->save();

		$to = new MailAddress( $user->email );
		$from = new MailAddress( $wgAdSSPasswordSender );
		$subject = '[AdSS] Your new password';
		$url = SpecialPage::getTitleFor( 'AdSS/manager' )->getFullURL();
		$body = "Hi,

Your password has been reset. With the password shown below, and the
email address we sent this to as your username, you can login and
review your ads, buy new ads and cancel an ad if it starts getting
stale.

URL: $url
Username: {$user->email}
Password: $password

Thanks!

The Wikia Team
";
		UserMailer::send( $to, $from, $subject, $body );
		echo "password reset!\n";
	} else {
		echo "wrong uid value!\n";
		exit( 1 );
	}
} else {
	echo "Usage: resetPassword.php --uid <user id>\n";
	exit( 1 );
}
