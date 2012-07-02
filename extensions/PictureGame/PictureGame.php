<?php
/**
 * PictureGame extension - allows making picture games
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author Ashish Datta <ashish@setfive.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:PictureGame Documentation
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'PictureGame',
	'version' => '2.0',
	'author' => array( 'Aaron Wright', 'Ashish Datta', 'David Pean', 'Jack Phoenix' ),
	'description' => 'Allows making picture games',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PictureGame'
);

// ResourceLoader support for MediaWiki 1.17+
$pictureGameResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'PictureGame/picturegame',
	'position' => 'top' // available since r85616
);

$wgResourceModules['ext.pictureGame'] = $pictureGameResourceTemplate + array(
	//'styles' => '', // @todo
	'scripts' => 'PictureGame.js',
	'messages' => array(
		'picturegame-js-edit', 'picturegame-js-error-title',
		'picturegame-js-error-upload-imgone',
		'picturegame-js-error-upload-imgtwo', 'picturegame-js-editing-imgone',
		'picturegame-js-editing-imgtwo'
	)
);

$wgResourceModules['ext.pictureGame.lightBox'] = $pictureGameResourceTemplate + array(
	'scripts' => 'LightBox.js'
);

// picturegame_images.flag used to be an enum() and that sucked, big time
define( 'PICTUREGAME_FLAG_NONE', 0 );
define( 'PICTUREGAME_FLAG_FLAGGED', 1 );
define( 'PICTUREGAME_FLAG_PROTECT', 2 );

// Set up the new special page and autoload classes
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['PictureGame'] = $dir . 'PictureGame.i18n.php';
$wgExtensionMessagesFiles['PictureGameAlias'] = $dir . 'PictureGame.alias.php';
$wgAutoloadClasses['PictureGameHome'] = $dir . 'PictureGameHome.body.php';
$wgSpecialPages['PictureGameHome'] = 'PictureGameHome';

// Upload form
$wgAutoloadClasses['SpecialPictureGameAjaxUpload'] = $dir . 'AjaxUploadForm.php';
$wgAutoloadClasses['PictureGameAjaxUploadForm'] = $dir . 'AjaxUploadForm.php';
$wgAutoloadClasses['PictureGameUpload'] = $dir . 'AjaxUploadForm.php';
$wgSpecialPages['PictureGameAjaxUpload'] = 'SpecialPictureGameAjaxUpload';

// For example: 'edits' => 5 if you want to require users to have at least 5
// edits before they can create new picture games.
$wgCreatePictureGameThresholds = array();

// New user right, required to delete/protect picture games
$wgAvailableRights[] = 'picturegameadmin';
$wgGroupPermissions['sysop']['picturegameadmin'] = true;
$wgGroupPermissions['staff']['picturegameadmin'] = true;

// Hooked function
$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] = 'wfAddPictureGameContentActions';

// Custom content actions for quiz game
function wfAddPictureGameContentActions( $skin, $content_actions ) {
	global $wgUser, $wgRequest, $wgPictureGameID, $wgTitle;

	// Add edit page to content actions but only for Special:PictureGameHome
	// and only when $wgPictureGameID is set so that we don't show the "edit"
	// tab when there is no data in the database
	if(
		$wgRequest->getVal( 'picGameAction' ) != 'startCreate' &&
		$wgUser->isAllowed( 'picturegameadmin' ) &&
		$wgTitle->isSpecial( 'PictureGameHome' ) && !empty( $wgPictureGameID )
	) {
		$pic = SpecialPage::getTitleFor( 'PictureGameHome' );
		$content_actions['edit'] = array(
			'class' => ( $wgRequest->getVal( 'picGameAction' ) == 'editItem' ) ? 'selected' : false,
			'text' => wfMsg( 'edit' ),
			'href' => $pic->getFullURL( 'picGameAction=editPanel&id=' . $wgPictureGameID ), // @bug 2457, 2510
		);
	}

	// If editing, make special page go back to quiz question
	if( $wgRequest->getVal( 'picGameAction' ) == 'editItem' ) {
		$pic = SpecialPage::getTitleFor( 'QuizGameHome' );
		$content_actions[$wgTitle->getNamespaceKey()] = array(
			'class' => 'selected',
			'text' => wfMsg( 'nstab-special' ),
			'href' => $pic->getFullURL( 'picGameAction=renderPermalink&id=' . $wgPictureGameID ),
		);
	}

	return true;
}

// For the Renameuser extension
$wgHooks['RenameUserSQL'][] = 'wfPictureGameOnUserRename';

function wfPictureGameOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['picturegame_images'] = array( 'username', 'userid' );
	$renameUserSQL->tables['picturegame_votes'] = array( 'username', 'userid' );
	return true;
}