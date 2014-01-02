<?php
/**
 * A special page to create a new article using the easy-to-use interface at
 * Special:CreatePage.
 *
 * @file
 * @ingroup Extensions
 * @version 3.91 (r15554)
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright Copyright © 2007-2008 Wikia Inc.
 * @copyright Copyright © 2009-2011 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:CreateAPage Documentation
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CreateAPage',
	'author' => array(
		'Bartek Łapiński', 'Łukasz Garczewski', 'Przemek Piotrowski',
		'Jack Phoenix'
	),
	'version' => '3.91',
	'description' => '[[Special:CreatePage|Easy to use interface]] for creating new articles',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CreateAPage',
);

// Autoload classes and set up the new special page(s)
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CreateAPage'] = $dir . 'CreateAPage.i18n.php';
$wgAutoloadClasses['EasyTemplate'] = $dir . 'EasyTemplate.php'; // @todo FIXME: kill templates and remove this class
$wgAutoloadClasses['CreateMultiPage'] = $dir . 'CreateMultiPage.php';
$wgAutoloadClasses['CreatePage'] = $dir . 'SpecialCreatePage.body.php';
$wgAutoloadClasses['CreatePageEditor'] = $dir . 'CreatePageEditor.php';
$wgAutoloadClasses['CreatePageMultiEditor'] = $dir . 'CreatePageEditor.php';
$wgAutoloadClasses['CreatePageCreateplateForm'] = $dir . 'CreatePageCreateplateForm.php';
$wgAutoloadClasses['CreatePageImageUploadForm'] = $dir . 'CreatePageImageUploadForm.php';
$wgAutoloadClasses['PocketSilentArticle'] = $dir . 'CreatePageEditor.php';
$wgSpecialPages['CreatePage'] = 'CreatePage';
$wgSpecialPageGroups['CreatePage'] = 'pagetools';

// Load AJAX functions, too
require_once $dir . 'SpecialCreatePage_ajax.php';

// ResourceLoader support for MediaWiki 1.17+
$wgResourceModules['ext.createAPage'] = array(
	'styles' => 'CreatePage.css',
	'scripts' => 'js/CreateAPage.js',
	'messages' => array(
		'createpage-insert-image', 'createpage-upload-aborted',
		'createpage-img-uploaded', 'createpage-login-required',
		'createpage-login-href', 'createpage-login-required2',
		'createpage-give-title', 'createpage-img-uploaded',
		'createpage-article-exists', 'createpage-article-exists2',
		'createpage-title-invalid', 'createpage-please-wait',
		'createpage-show', 'createpage-hide',
		'createpage-must-specify-title', 'createpage-unsaved-changes',
		'createpage-unsaved-changes-details'
	),
	'dependencies' => array( 'jquery.ui', 'jquery.ui.dialog' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'CreateAPage',
	'position' => 'top' // available since r85616
);

// Our only configuration setting -- use CreateAPage on redlinks (i.e. clicking
// on a redlink takes you to index.php?title=Special:CreatePage&Createtitle=Title_of_our_page
// instead of taking you to index.php?title=Title_of_our_page&action=edit&redlink=1)
$wgCreatePageCoverRedLinks = false;

// Hooked functions
$wgHooks['EditPage::showEditForm:initial'][] = 'wfCreatePagePreloadContent';
$wgHooks['CustomEditor'][] = 'wfCreatePageRedLinks';
$wgHooks['ConfirmEdit::onConfirmEdit'][] = 'wfCreatePageConfirmEdit'; // ConfirmEdit CAPTCHA

$wgHooks['GetPreferences'][] = 'wfCreatePageToggle';

// handle ConfirmEdit CAPTCHA, only for CreatePage, which will be treated a bit differently (edits in special page)
function wfCreatePageConfirmEdit( &$captcha, &$editPage, $newtext, $section, $merged, &$result ) {
	global $wgTitle, $wgCreatePageCoverRedLinks;

	// Enable only if the configuration global is set to true,
	// only for Special:CreatePage and only when ConfirmEdit is installed
	$canonspname = array_shift(SpecialPageFactory::resolveAlias( $wgTitle->getDBkey() ));
	if ( !$wgCreatePageCoverRedLinks ) {
		return true;
	}
	if ( $canonspname != 'CreatePage' ) {
		return true;
	}
	if ( !class_exists( 'SimpleCaptcha' ) ) {
		return true;
	}

	if( $captcha->shouldCheck( $editPage, $newtext, $section, $merged ) ) {
		if( $captcha->passCaptcha() ) {
			$result = true;
			return false;
		} else {
			// display CAP page
			$mainform = new CreatePageCreatePlateForm();
			$mainform->showForm( '', false, array( &$captcha, 'editCallback' ) );
			$editor = new CreatePageMultiEditor( $_SESSION['article_createplate'] );
			$editor->generateForm( $newtext );

			$result = false;
			return false;
		}
	} else {
		return true;
	}
}

// when AdvancedEdit button is used, the existing content is preloaded
function wfCreatePagePreloadContent( $editpage ) {
	global $wgRequest;
	if( $wgRequest->getCheck( 'createpage' ) ) {
		$editpage->textbox1 = $_SESSION['article_content'];
	}
	return true;
}

function wfCreatePageRedLinks( $article, $user ) {
	global $wgRequest, $wgContentNamespaces, $wgCreatePageCoverRedLinks;

	if ( !$wgCreatePageCoverRedLinks ) {
		return true;
	}

	$namespace = $article->getTitle()->getNamespace();
	if (
		( $user->getOption( 'createpage-redlinks', 1 ) == 0 ) ||
		!in_array( $namespace, $wgContentNamespaces )
	)
	{
		return true;
	}

	// nomulti should always bypass that (this is for AdvancedEdit mode)
	if (
		$article->getTitle()->exists() ||
		( $wgRequest->getVal( 'editmode' ) == 'nomulti' )
	)
	{
		return true;
	} else {
		if ( $wgRequest->getCheck( 'wpPreview' ) ) {
			return true;
		}
		$mainform = new CreatePageCreateplateForm();
		$mainform->mTitle = $wgRequest->getVal( 'title' );
		$mainform->mRedLinked = true;
		$mainform->showForm( '' );
		$mainform->showCreateplate( true );
		return false;
	}
}

/**
 * Adds a new toggle into Special:Preferences when $wgCreatePageCoverRedLinks
 * is set to true.
 *
 * @param $user Object: current User object
 * @param $preferences Object: Preferences object
 * @return Boolean: true
 */
function wfCreatePageToggle( $user, &$preferences ) {
	global $wgCreatePageCoverRedLinks;
	if ( $wgCreatePageCoverRedLinks ) {
		$preferences['create-page-redlinks'] = array(
			'type' => 'toggle',
			'section' => 'editing/advancedediting',
			'label-message' => 'tog-createpage-redlinks',
		);
	}
	return true;
}

// Restore what we temporarily encoded
// moved from CreateMultiPage.php
function wfCreatePageUnescapeKnownMarkupTags( &$text ) {
	$text = str_replace( '<!---pipe--->', '|', $text );
}