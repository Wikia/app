<?php

/**
 * Sets up the extension.
 */

if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SignDocument/SignDocument.php.php" );
EOT;
	exit( 1 );
}

/**
 * Adds two special pages, Special:SignDocument and Special:CreateSignDocument, which
 * enable the creation of signable documents. See the README for more information.
 *
 * @addtogroup Extensions
 *
 * @author Daniel Cannon (AmiDaniel)
 * @copyright Copyright © 2007, Daniel Cannon
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfCreateSignatureLog';

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'SignDocument',
	'author'         => 'Daniel Cannon',
	'description'    => 'Enables document signing',
	'descriptionmsg' => 'signature-desc',
	'svn-date'       => '$LastChangedDate: 2008-08-15 23:04:54 +0200 (ptk, 15 sie 2008) $',
	'svn-revision'   => '$LastChangedRevision: 39440 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SignDocument',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SignDocument'] = $dir . 'SignDocument.i18n.php';
$wgExtensionMessagesFiles['SpecialSignDocument'] = $dir . 'SpecialSignDocument.i18n.php';
$wgExtensionMessagesFiles['CreateSignDocument'] = $dir . 'SpecialCreateSignDocument.i18n.php';
$wgExtensionAliasesFiles['SignDocument'] = $dir . 'SignDocument.alias.php';
$wgAutoloadClasses['SpecialSignDocument'] = $dir . 'SpecialSignDocument.php';
$wgAutoloadClasses['SpecialCreateSignDocument'] = $dir . 'SpecialCreateSignDocument.php';
$wgSpecialPages['SignDocument'] = 'SpecialSignDocument';
$wgSpecialPages['CreateSignDocument'] = 'SpecialCreateSignDocument';

/* Set up sigadmin permissions. */
$wgAvailableRights[] = 'sigadmin';
$wgAvailableRights[] = 'createsigndocument';
$wgGroupPermissions['*']['sigadmin'] = false;
$wgGroupPermissions['sigadmin']['sigadmin'] = true;
$wgGroupPermissions['*']['createsigndocument'] = false;
$wgGroupPermissions['sigadmin']['createsigndocument'] = true;

/**
 * Create the Signature log.
 */
function wfCreateSignatureLog() {
	wfLoadExtensionMessages('SignDocument');

	# Add a new log type
	global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;

	$wgLogTypes[]                      = 'signature';
	$wgLogNames['signature']           = 'signaturelogpage';
	$wgLogHeaders['signature']         = 'signaturelogpagetext';
	$wgLogActions['signature/sign']    = 'signaturelogentry';
}

/**
 * Logs the addition of a signature to a document. If it's an anonymous user,
 * it will add it to the logging table but the entry won't display on Special:Log.
 * Currently trying to work out a good way to "fix" this.
 */
function wfLogSignDocumentSignature( $sig ) {
	global $wgUser;
	$log = new LogPage( 'signature' );
	$log->addEntry( 'sign', Title::newFromId( $sig->mForm->getPageId() ),
		'id=' . $sig->mId );
}
