<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

echo "Checking for users that don't have a password yet\n";
$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads', 'users' ),
		array( 'user_id' ),
		array(
			"user_id = ad_user_id",
			"user_password = ''",
			"ad_closed IS NULL",
			),
		__METHOD__,
		array(
			'GROUP BY' => 'user_id',
		     )
	       );
foreach( $res as $row ) {
	$user = AdSS_User::newFromId( $row->user_id );
	echo "{$user->toString()} | ";
	$password = AdSS_User::randomPassword();
	$user->password = $user->cryptPassword( $password );
	$user->save();

	$to = new MailAddress( $user->email );
	$from = new MailAddress( $wgPasswordSender );
	$subject = '[AdSS] Your new password';
	$url = SpecialPage::getTitleFor( 'AdSS/manager' )->getFullURL();
	$body = "Hi,

Based on your feedback, we've launched a new feature that lets you
login to Wikia's ad system.  With the password shown below, and the
email address we sent this to as your username, you can login and
review your ads, buy new ads and cancel an ad if it starts getting
stale.

URL: $url
Username: {$user->email}
Password: $password

We expect to launch new ad products and promotions soon as we've been
overwhelmed by the interest so far. If you have any suggestions or
feedback, please email gil@wikia-inc.com

Thanks!

Gil
";
	UserMailer::send( $to, $from, $subject, $body );

	echo "sent...\n";
}
$dbw->freeResult( $res );
