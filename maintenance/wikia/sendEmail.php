<?php

/**
 * Test email
 */

require_once( dirname(__FILE__)."/../commandLine.inc" );
require_once( dirname(__FILE__)."/../../includes/UserMailer.php" );

sendEmail();

function sendEmail() {
	$from    = new MailAddress("community@wikia-inc.com");
	$to      = new MailAddress("garth@wikia-inc.com");
	$body    = "Test sendgrid email";
	$headers = array( "X-Msg-Category" => "Test" );
	$subject = "This is a sendgrid test";

	UserMailer::send($to, $from, $subject, $body);
}
