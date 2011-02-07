<?php
/**
 * Internationalisation file for SpecialContact extension.
 *
 * @addtogroup Extensions
 * @todo FIXME: <s>Cannot add support for L10n in Translate because of key conflicts with MediaWiki SVN extension ContactPage.</s> Fixed. Is it ready for TWN now?
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
		'specialcontact-wikia' => 'Contact Wikia',
		'specialcontact-pagetitle' => 'Contact Wikia',

		/* form */
		'specialcontact-intro' => 'You can contact [[w:project:Staff|Wikia Staff]] using this form. Admins of this wiki can be found [[Special:ListAdmins|here]].

Additional information on how to report problems to Wikia can be found [[w:project:Report_a_problem|here]],<br/>
or you can post on [[w:Forum:Index|Wikia Community Forums]] for user support.

If you prefer to use regular email or have attachments, you can contact us at [mailto:community@wikia.com community@wikia.com]',
		'specialcontact-username' => 'Username',
		'specialcontact-wikiname' => 'Which wiki',
		'specialcontact-realname' => 'Your name',
		'specialcontact-yourmail' => 'Email',
		'specialcontact-problem' => 'Subject',
		'specialcontact-problemdesc' => 'Message',
		'specialcontact-mail' => 'Send to Wikia',
		'specialcontact-filledin' => 'This information has been filled in from your account preferences',
		'specialcontact-ccme' => 'Send me a copy of this message',
		'specialcontact-ccdisabled' => 'DISABLED: Please validate your email address to use this function',
		'specialcontact-notyou' => 'Not you?',
		'specialcontact-captchainfo' => 'Please enter the text in the image.',
		'specialcontact-captchatitle' => 'Blurry Word',
		'specialcontact-formtitle' => 'Contact Wikia Support Staff',
		/* errors */
		'specialcontact-nomessage' => 'Please fill in a message',
		'specialcontact-captchafail' =>	'Incorrect or missing confirmation code.', 
		/* email */
		'specialcontact-mailsub' => 'Wikia Contact Mail',
		'specialcontact-mailsubcc' => 'Copy of Wikia Contact Mail',
		'specialcontact-ccheader' => 'This is a copy of your message that was sent to Wikia Support',

		/* after */
		'specialcontact-submitcomplete' => 'Thank you for contacting Wikia.',
	)
);
