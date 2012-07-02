<?php
/**
  * SimpleSpam extension by Ryan Schmidt
  * Adds a simple spam/bot check to forms
  * Does not affect real users in any way/shape/form
  */

if(!defined('MEDIAWIKI')) {
	efSimpleAntiSpamInstall();
	die(1);
}

$wgExtensionCredits[version_compare($wgVersion, '1.17alpha', '>=') ? 'antispam' : 'other'][] = array(
	'path'           => __FILE__,
	'name'           => 'SimpleAntiSpam',
	'descriptionmsg' => 'simpleantispam-desc',
	'author'         => 'Ryan Schmidt',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SimpleAntiSpam',
	'version'        => '1.0',
);

$wgExtensionMessagesFiles['SimpleAntiSpam'] = dirname(__FILE__) . '/SimpleAntiSpam.i18n.php';
$wgHooks['EditPage::showEditForm:fields'][] = 'efSimpleAntiSpamField';
$wgHooks['EditPage::attemptSave'][] = 'efSimpleAntiSpamCheck';

//add the form field
function efSimpleAntiSpamField(&$editpage, &$out) {
	$out->addHTML("<div id=\"antispam-container\" style=\"display: none;\">
<label for=\"wpAntispam\">".wfMsgExt('simpleantispam-label', array( 'parseinline' ))."</label> <input type=\"text\" name=\"wpAntispam\" id=\"wpAntispam\" value=\"\" />
</div>\n");
	return true;
}

//check for the field and if it isn't empty, negate the save
/**
 * @param  $editpage EditPage
 * @return bool
 */
function efSimpleAntiSpamCheck( $editpage ) {
	global $wgRequest, $wgUser;
	$spam = $wgRequest->getText( 'wpAntispam' );
	if( $spam !== '' ) {
		wfDebugLog( 'SimpleAntiSpam',
			$wgUser->getName() .
			' editing "' .
			$editpage->mTitle->getPrefixedText() .
			'" submitted bogus field "' .
			$spam .
			'"' );
		$editpage->spamPageWithContent();
		return false;
	}
	return true;
}

//gives installation directions if this script is accessed directly and not via the wiki
//don't try to localize the messages in this function, you'll just fail epicly
function efSimpleAntiSpamInstall() {
	$i = <<<EOM
		This is an extension to the MediaWiki software and cannot be used standalone.\n
		To install this on the wiki, add the following line to LocalSettings.php:\n
			<tt>require_once("\$IP/extensions/SimpleAntiSpam/SimpleAntiSpam.php");</tt>\n
		To verify the installation, browse to the Special:Version page on your wiki.\n
EOM;
	echo $i;
	return;
}
