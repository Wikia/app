<?php
/**
 * Internationalisation file for the ConfirmEdit extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(

	// Base
	'captcha-edit'               => 'To edit this page, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-desc'               => 'Provides CAPTCHA techniques to protect against spam and password-guessing',
	'captcha-addurl'             => 'Your edit includes new external links.
To help protect against automated spam, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-badlogin'           => 'To help protect against automated password cracking, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount'      => 'To help protect against automated account creation, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount-fail' => "Incorrect or missing confirmation code.",
	'captcha-create'             => 'To create the page, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-sendemail'          => 'To help protect against automated spamming, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-sendemail-fail'     => 'Incorrect or missing confirmation code.',
	'captcha-disabledinapi'      => 'This action requires a captcha, so it cannot be performed through the API.',
	'captchahelp-title'          => 'CAPTCHA help',
	'captchahelp-cookies-needed' => "You will need to have cookies enabled in your browser for this to work.",
	'captchahelp-text'           => "Web sites that accept postings from the public, like this wiki, are often abused by spammers who use automated tools to post their links to many sites.
While these spam links can be removed, they are a significant nuisance.

Sometimes, especially when adding new web links to a page, the wiki may show you an image of colored or distorted text and ask you to type the words shown.
Since this is a task that's hard to automate, it will allow most real humans to make their posts while stopping most spammers and other robotic attackers.

Unfortunately this may inconvenience users with limited vision or using text-based or speech-based browsers.
At the moment we do not have an audio alternative available.
Please contact the  [[{{MediaWiki:Grouppage-sysop}}|site administrators]] for assistance if this is unexpectedly preventing you from making legitimate posts.

Hit the 'back' button in your browser to return to the page editor.",
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside URLs
 #</pre> <!-- leave this line exactly as it is -->',

	'right-skipcaptcha'          => 'Perform CAPTCHA-triggering actions without having to go through the CAPTCHA',
	'captcha-input-placeholder'  => 'Enter text here',

	// Recaptcha
	'recaptcha-desc' => 'reCAPTCHA module for Confirm Edit',
	'recaptcha-edit' => 'To help protect against automated edit spam, please type the two words you see in the box below:',
	'recaptcha-addurl' => 'Your edit includes new external links. To help protect against automated spam, please type the two words you see in the box below:',
	'recaptcha-badpass' => 'To help protect against automated password cracking, please type the two words you see in the box below:',
	'recaptcha-createaccount' => 'To help protect against automated account creation, please type the two words you see in the box below:',
	'recaptcha-createaccount-fail' => "Incorrect or missing reCAPTCHA answer.",
	'recaptcha-create' => 'To help protect against automated page creation, please type the two words you see in the box below:',
	'recaptcha-misconfigured' => 'ReCaptcha is not configured correctly',
);
