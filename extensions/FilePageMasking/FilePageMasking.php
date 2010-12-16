<?php
/*
 This extension masks local links for file description pages by modifying the
 file extension at the end of the description page URL so it does not also look
 like a file.  This makes it easier for search engines and other programs to
 recognize the file description page as HTML rather than assuming it is also a
 file based on its extension.

 By default, extensions of the form ".xxx" are translated to "_xxx".  This only
 occurs for internal links that should target the file description page.  When
 a file description page of the form "_xxx" is requested, this extension
 automatically translates it back to ".xxx" so that Mediawiki will retrieve the
 correct page.   The choice of masking character can be set by changing
 $wgFilePageMaskingCharacter, which defaults to "_".  The setting of this
 variable must be a single character, and must be valid in a URL.

 This extension relies on $wgFileExtensions to determine the list of case
 insensitive file extensions to translate.  On sites where
 $wgStrictFileExtensions is set to false, the user may upload files with
 extensions not considered by $wgFileExtensions.  If this is the case, those
 file extensions will not be masked.
*/

if ( ! defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'FilePageMasking',
	'author' => 'Robert Rohde',
	'version' => '1.0',
	'description' => 'Converts file extensions ".xxx" to "_xxx" on description page links', // kept for b/c
	'descriptionmsg' => 'filepagemasking-desc',
	'path' =>  __FILE__,
	'url' => 'http://www.mediawiki.org/wiki/Extension:FilePageMasking',
);

$wgFilePageMaskingCharacter = '_';

$wgExtensionMessagesFiles['FilePageMasking'] = dirname( __FILE__ ) . "/FilePageMasking.i18n.php";

$wgHooks['GetLocalURL'][] = 'wfFilePageMasking_Mask';
$wgHooks['ArticleFromTitle'][] = 'wfFilePageMasking_Unmask';

/**
 * This hook applies masking to file page links.
 **/
function wfFilePageMasking_Mask( &$title, &$url, $query ) {
	global $wgFileExtensions, $wgFilePageMaskingCharacter;

	if ( $title->getNamespace() == NS_FILE ) {
		$lUrl = strlen( $url );
		foreach ( $wgFileExtensions as $ext ) {
			$lExt = strlen( $ext );
			$p = stripos( $url, "." . $ext, $lUrl - $lExt - 1 );
			if ( $p == $lUrl - $lExt - 1 ) {
				$url[$p] = $wgFilePageMaskingCharacter;
				break;
			}
		}
	}
	return true;
}

/**
 * This hook removes masking to file page requests.
 **/
function wfFilePageMasking_Unmask( &$title, &$article ) {
	global $wgFileExtensions, $wgFilePageMaskingCharacter;

	if ( $title->getNamespace() == NS_FILE ) {
		$name = $title->getDBkey();
		$lName = strlen( $name );
		foreach ( $wgFileExtensions as $ext ) {
			$lExt = strlen( $ext );
			$p = stripos( $name, $wgFilePageMaskingCharacter . $ext, $lName - $lExt - 1 );
			if ( $p == $lName - $lExt - 1 ) {
				$name[$p] = ".";
				$title = Title::newFromText( $name, NS_FILE );
				break;
			}
		}
	}
	return true;
}
