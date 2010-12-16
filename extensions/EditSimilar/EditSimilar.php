<?php
/**
 * Extension that suggests editing of similar articles upon saving an article
 *
 * @file
 * @ingroup Extensions
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @copyright Copyright © 2008, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) )
	die( "This is not a valid entry point.\n" );

// Internationalization file
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['EditSimilar'] = $dir . 'EditSimilar.i18n.php';
$wgAutoloadClasses['EditSimilar'] = $dir . 'EditSimilar.class.php';

// maximum number of results to choose from
$wgEditSimilarMaxResultsPool = 50;

// maximum number of results to display in text
$wgEditSimilarMaxResultsToDisplay = 3;

// show message per specified number of edits
$wgEditSimilarCounterValue = 1;

// Hooked functions
$wgHooks['ArticleSaveComplete'][] = 'wfEditSimilarCheck';
$wgHooks['OutputPageBeforeHTML'][] = 'wfEditSimilarViewMesg';
$wgHooks['GetPreferences'][] = 'wfEditSimilarToggle';

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'EditSimilar',
	'version' => '1.20',
	'author' => array( 'Bartek Łapiński', 'Łukasz Garczewski' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:EditSimilar',
	'description' => 'Encourages users to edit a page similar (by categories) to the one they just had edited.',
	'descriptionmsg' => 'editsimilar-desc',
);

// check if we had the extension enabled at all and if this is in a content namespace
function wfEditSimilarCheck( $article ) {
	global $wgUser, $wgContentNamespaces;

	$namespace = $article->getTitle()->getNamespace();
	if ( ( 1 == $wgUser->getOption( 'edit-similar', 1 ) ) && ( in_array( $namespace, $wgContentNamespaces ) ) ) {
		$_SESSION['ES_saved'] = 'yes';
	}
	return true;
}

// view message depending on settings and the relevancy of the results
function wfEditSimilarViewMesg( &$out ) {
	global $wgTitle, $wgUser, $wgEditSimilarAlwaysShowThanks;

	wfLoadExtensionMessages( 'EditSimilar' );

	if ( !empty( $_SESSION['ES_saved'] ) && ( 1 == $wgUser->getOption( 'edit-similar', 1 ) ) && $out->isArticle() ) {
		if ( EditSimilar::checkCounter() ) {
			$message_text = '';
			$article_title = $wgTitle->getText();
			// here we'll populate the similar articles and links
			$instance = new EditSimilar( $wgTitle->getArticleId(), 'category' );
			$similarities = $instance->getSimilarArticles();

			if ( !empty( $similarities ) ) {
				global $wgLang;

				if ( $instance->mSimilarArticles ) {
					$message_text = wfMsgExt(
						'editsimilar-thanks',
						array( 'parsemag' ),
						$wgLang->listToText( $similarities ),
						count( $similarities )
					);
				} else { // the articles we found were rather just articles needing attention
					$message_text = wfMsgExt(
						'editsimilar-thanks-notsimilar',
						array( 'parsemag' ),
						$wgLang->listToText( $similarities ),
						count( $similarities )
					);
				}
			} else {
				if ( $wgUser->isLoggedIn() && !empty( $wgEditSimilarAlwaysShowThanks ) ) {
					$message_text = wfMsg( 'editsimilar-thankyou', $wgUser->getName() );
				}
			}

			if ( '' != $message_text ) {
				EditSimilar::showMessage( $message_text, $article_title );
			}
		}
		// display that only once
		$_SESSION['ES_saved'] = '';
	}
	return true;
}

/**
 * Adds the new toggle to Special:Preferences for enabling EditSimilar extension on a per-user basis
 *
 * @param $user User object
 * @param $preferences Preferences object
 * @return true
 */
function wfEditSimilarToggle( $user, &$preferences ) {
	wfLoadExtensionMessages( 'EditSimilar' );

	$preferences['edit-similar'] = array(
		'type' => 'toggle',
		'section' => 'editing',
		'label-message' => 'tog-edit-similar',
	);
	return true;
}