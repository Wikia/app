<?php
/**
 * An extension that allows users to upload multiple files at once.
 *
 * @file
 * @ingroup Extensions
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:MultiUpload Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// change this parameter to limit the # of files one can upload
$wgMaxUploadFiles = isset( $wgMaxUploadFiles ) ? intval( $wgMaxUploadFiles ) : 5;

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'MultipleUpload',
	'author' => 'Travis Derouin',
	'version' => '2.1',
	'descriptionmsg' => 'multiupload-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MultiUpload',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['MultipleUpload'] = $dir . 'MultiUpload.body.php';
$wgAutoloadClasses['MultipleUploadForm'] = $dir . 'MultiUpload.body.php';
$wgExtensionMessagesFiles['MultiUpload'] = $dir . 'MultiUpload.i18n.php';
$wgExtensionMessagesFiles['MultiUploadAlias'] = $dir . 'MultiUpload.alias.php';
$wgSpecialPages['MultipleUpload'] = 'MultipleUpload';
$wgSpecialPageGroups['MultipleUpload'] = 'media';

// Hooked functions
$wgHooks['SkinTemplateToolboxEnd'][]  = 'wfMultiUploadToolbox';
$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'wfSpecialMultiUploadNav';

// Add the link to Special:MultipleUpload to all SkinTemplate-based skins for users with the 'upload' user right
function wfSpecialMultiUploadNav( Skin $skin, &$nav_urls, &$oldid, &$revid ): bool {

	if ( $skin->getUser()->isAllowed( 'upload' ) ) {
		$nav_urls['multiupload'] = [
			'text' => $skin->msg( 'multiupload_link' )->escaped(),
			'href' => Skin::makeSpecialUrl( 'MultipleUpload' ),
		];
	}

	return true;
}

// Add the link to Special:MultipleUpload to SkinTemplate based skins
function wfMultiUploadToolbox( $monobook ): bool {
	if ( isset( $monobook->data['nav_urls']['multiupload'] ) )  {
		if ( $monobook->data['nav_urls']['multiupload']['href'] == '' ) {
			?><li id="t-ismultiupload"><?php echo $monobook->msg( 'multiupload-toolbox' ); ?></li><?php
		} else {
			?><li id="t-multiupload"><?php
				?><a href="<?php echo htmlspecialchars( $monobook->data['nav_urls']['multiupload']['href'] ) ?>"><?php
					echo $monobook->msg( 'multiupload-toolbox' );
				?></a><?php
			?></li><?php
		}
	}
	return true;
}

