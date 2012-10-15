<?php
/**
 * EnhanceContactForm -- improves Special:Contact by adding new fields for:
 *	-wiki URL ($wgServer; this is the only visible field)
 *	-wiki database name ($wgDBname)
 *	-reporter's IP address
 *	-reporter's browser
 *	-reporter's operating system
 *	-reporter's User-Agent string
 * MyInfo extension is required for the browser/OS/UA detection.
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @copyright Copyright © 2009-2011 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'EnhanceContactForm',
	'version' => '0.5',
	'author' => 'Jack Phoenix',
	'url' => 'https://www.mediawiki.org/wiki/Extension:EnhanceContactForm',
	'description' => 'Enhances [[Special:Contact]] by sending more info',
);

$wgHooks['ContactForm'][] = 'enhanceContactForm';
$wgHooks['ContactFormBeforeMessage'][] = 'addContactFormFields';

/**
 * Add extra info to the e-mail which gets sent to the staff.
 * @return Boolean: true
 */
function enhanceContactForm( &$to, &$replyto, &$subject, &$text ) {
	global $wgRequest;
	$text = 'Contact message by the user: ' . $wgRequest->getText( 'wpText' ) . "\n";
	// Now add the custom stuff
	$text .= 'URL of the wiki: ' . $wgRequest->getText( 'wpWikiURL' ) . "\n";
	$text .= 'Database name: ' . $wgRequest->getText( 'wpDBname' ) . "\n";
	$text .= 'IP address of the reporter: ' . wfGetIP() . "\n";
	$text .= 'Browser: ' . $wgRequest->getText( 'wpBrowser' ) . "\n";
	$text .= 'Operating system: ' . $wgRequest->getText( 'wpOperatingSystem' ) . "\n";
	$text .= 'User-Agent string: ' . $wgRequest->getText( 'wpUserAgent' ) . "\n";
	return true;
}

/**
 * Add new fields (1 shown + 1-5 hidden ones) to Special:Contact.
 *
 * @param $contactForm Object: instance of EmailContactForm class
 * @param $form Sringt: HTML
 * @return Boolean: true
 */
function addContactFormFields( $contactForm, $form ) {
	global $wgServer, $wgDBname;

	$form .= '<tr>
				<td class="mw-label">' .
					Xml::label( wfMsg( 'contactpage-wikiurl' ), 'wpWikiURL' ) .
				'</td>
				<td class="mw-input" id="mw-contactpage-address">' .
					Xml::input( 'wpWikiURL', 60, $wgServer, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				'</td>
			</tr>
			<tr>' .
				Html::Hidden( 'wpDBname', $wgDBname, array( 'maxlength' => 100 ) ) .
				"</tr>\n\t\t\t";
	if( class_exists( 'MyInfo' ) ) {
		$myinfo = new MyInfo();
		$myinfo->browser = get_browser( null, true );
		$myinfo->info = browser_detection( 'full' );
		$myinfo->info[] = browser_detection( 'moz_version' );
		$form .= '<tr>' .
				Html::Hidden( 'wpBrowser', $myinfo->getBrowser(), array( 'maxlength' => 255 ) ) .
				'</tr>
			<tr>' .
				Html::Hidden( 'wpOperatingSystem', $myinfo->getOs(), array( 'maxlength' => 255 ) ) .
				'</tr>
			<tr>' .
				Html::Hidden( 'wpSkinName', $myinfo->getSkin(), array( 'maxlength' => 35 ) ) .
				'</tr>
			<tr>' .
				Html::Hidden( 'wpUserAgent', $myinfo->getUAgent(), array( 'maxlength' => 500 ) ) .
				'</tr>';
	}
	return true;
}