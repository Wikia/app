<?php
/**
 * Internationalisation file for SpecialContact extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

/**
 * Prepare extension messages
 *
 * @return array
 */
$messages = array(

	'en' => array(
		/* special page */
		'contact' => 'Contact Wikia',
		'contactwikia' => 'Contact Wikia',
		'contactpagetitle' => 'Contact Wikia',

		/* form */
		'contactintro' => 'You can contact [[w:project:Staff|Wikia Staff]] using this form. Admins of this wiki can be found [[Special:ListAdmins|here]].

Additional information on how to report problems to Wikia can be found [[w:project:Report_a_problem|here]],<br/>
or you can post on [[w:Forum:Index|Wikia Community Forums]] for user support.

If you prefer to use regular email or have attachments, you can contact us at [mailto:community@wikia.com community@wikia.com]',
		'contactusername' => 'Username',
		'contactwikiname' => 'Which wiki',
		'contactrealname' => 'Your name',
		'contactyourmail' => 'Email',
		'contactproblem' => 'Subject',
		'contactproblemdesc' => 'Message',
		'contactmail' => 'Send to Wikia',
		'contactfilledin' => 'This information has been filled in from your account preferences',
		'contactccme' => 'Send me a copy of this message',
		'contactccdisabled' => 'DISABLED: Please validate your email address to use this function',
		'contactnotyou' => 'Not you?',
		
		/* errors */
		'contactnomessage' => 'Please fill in a message',
		
		/* email */
		'contactmailsub' => 'Wikia Contact Mail',
		'contactmailsubcc' => 'Copy of Wikia Contact Mail',
		'contactccheader' => 'This is a copy of your message that was sent to Wikia Support',

		/* after */
		'contactsubmitcomplete' => 'Thank you for contacting Wikia.',
	)
);
