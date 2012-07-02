<?php
/**
 * The purpose of this extension is to provide NameSpace-based features to uploaded files in the local file repositories (FileRepo)

 * The optimal solution would be a clean extension that is easily maintainable as the trunk of MW moves foward.
 *
 * @file
 * @author Jack D. Pond <jack.pond@psitex.com>
 * @ingroup Extensions
 * @copyright  2009 Jack D. pond
 * @url http://www.mediawiki.org/wiki/Manual:Extension:NSFileRepo
 * @licence GNU General Public Licence 2.0 or later
 *
 * Version 1.4 - Several thumbnail fixes and updates for FileRepo enhancements
 *
 * Version 1.3 - Allows namespace protected files to be whitelisted
 *
 * Version 1.2 - Fixes reupload error and adds lockdown security to archives, deleted, thumbs
 *
 * This extension extends and is dependent on extension Lockdown - see http://www.mediawiki.org/wiki/Extension:Lockdown
 * It must be included(required) after Lockdown!  Also, $wgHashedUploadDirectory must be true and cannot be changed once repository has files in it
 */

if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' );
if (!function_exists('lockdownUserCan')) die('You MUST load Extension Lockdown before NSFileRepo (http://www.mediawiki.org/wiki/Extension:Lockdown).');

$wgImgAuthPublicTest = false;		// Must be set to false if you want to use more restrictive than general ['*']['read']
$wgIllegalFileChars = isset($wgIllegalFileChars) ? $wgIllegalFileChars : "";  // For MW Versions <1.16
$wgIllegalFileChars = str_replace(":","",$wgIllegalFileChars);			      // Remove the default illegal char ':' - need it to determine NS

$dir = dirname( __FILE__ ) . '/';

# Internationalisation file
$wgExtensionMessagesFiles['NSFileRepo'] =  $dir . 'NSFileRepo.i18n.php';
$wgExtensionMessagesFiles['img_auth'] =  $dir . 'img_auth.i18n.php';

$wgExtensionFunctions[] = 'NSFileRepoSetup';
$wgExtensionCredits['media'][] = array(
	'path' => __FILE__,
	'name' => 'NSFileRepo',
	'author' => 'Jack D. Pond',
	'version' => '1.4',
	'url' => 'https://www.mediawiki.org/wiki/Extension:NSFileRepo',
	'descriptionmsg' => 'nsfilerepo-desc'
);

/**
 * Classes
 */
$wgAutoloadClasses['NSLocalRepo'] = $dir . 'NSFileRepo_body.php';
$wgAutoloadClasses['NSLocalFile'] = $dir . 'NSFileRepo_body.php';
$wgAutoloadClasses['NSOldLocalFile'] = $dir . 'NSFileRepo_body.php';

/**
 * Set up hooks for NSFileRepo
 */
$wgHooks['UploadForm:BeforeProcessing'][] =  'NSFileRepoNSCheck';
// Note, this must be AFTER lockdown has been included - thus assuming that the
// user has access to files in general + files at this particular namespace.
$wgHooks['userCan'][] = 'NSFileRepolockdownUserCan';
$wgHooks['ImgAuthBeforeStream'][] = 'NSFileRepoImgAuthCheck';

/**
 * Initial setup, add .i18n. messages from $IP/extensions/DiscussionThreading/DiscussionThreading.i18n.php
*/
function NSFileRepoSetup() {
	global $wgLocalFileRepo;
	$wgLocalFileRepo['class'] = "NSLocalRepo";
	RepoGroup::destroySingleton();
}

/**
 * Check for Namespace in Title Line
*/
function NSFileRepoNSCheck( $uploadForm ) {
	$title = Title::newFromText($uploadForm->mDesiredDestName);
	if ( $title->getNamespace() < 100 ) {
		$uploadForm->mDesiredDestName = preg_replace( "/:/", '-', $uploadForm->mDesiredDestName );
	} else {
		$bits = explode( ':', $uploadForm->mDesiredDestName );
		$ns = array_shift( $bits );
		$uploadForm->mDesiredDestName = $ns.":" . implode( "-", $bits );
	}
	return true;
}

/**
 * If Extension:Lockdown has been activated (recommend), check individual namespace protection
 */
function NSFileRepolockdownUserCan( $title, $user, $action, &$result) {
	global $wgWhitelistRead;
	if ( in_array( $title->getPrefixedText(), $wgWhitelistRead ) ) {
		return true;
	} elseif( function_exists( 'lockdownUserCan' ) ) {
		if( $title->getNamespace() == NS_FILE ) {
			$ntitle = Title::newFromText( $title->mDbkeyform );
			return ( $ntitle->getNamespace() < 100 ) ?
				true : lockdownUserCan( $ntitle, $user, $action, $result );
		}
	}
	return true;
}

function NSFileRepoImgAuthCheck( $title, $path, $name, $result ) {
	global $wgContLang;

	# See if stored in a NS path
	$subdirs = explode('/',$path);
	$x = (!is_numeric($subdirs[1]) && ($subdirs[1] == "archive" || $subdirs[1] == "deleted" || $subdirs[1] == "thumb")) ? 2 : 1;
	$x = ($x == 2 && $subdirs[1] == "thumb" && $subdirs[2] == "archive") ? 3 : $x;
	if ( strlen( $subdirs[$x] ) >= 3 && is_numeric( $subdirs[$x] )
		&& $subdirs[$x] >= 100 )
	{
		$title = Title::makeTitleSafe( NS_FILE, $wgContLang->getNsText( $subdirs[$x] ) . ":" . $name );
		if( !$title instanceof Title ) {
			$result = array( 'img-auth-accessdenied', 'img-auth-badtitle', $name );
			return false;
		}
	}
	return true;
}
