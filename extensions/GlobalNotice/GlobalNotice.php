<?php
/**
 * GlobalNotice -- global (undismissable) sitenotice for wiki farms
 *
 * @file
 * @ingroup Extensions
 * @version 0.3
 * @author Misza <misza@shoutwiki.com>
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @copyright Copyright © 2010 Misza
 * @copyright Copyright © 2010-2011 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:GlobalNotice Documentation
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'GlobalNotice',
	'version' => '0.3',
	'author' => array( 'Misza', 'Jack Phoenix' ),
	'description' => 'Global sitenotice for wiki farms',
	'url' => 'https://www.mediawiki.org/wiki/Extension:GlobalNotice',
);

$wgHooks['SiteNoticeAfter'][] = 'wfGlobalNotice';
/**
 * @param $siteNotice String: existing site notice (if any) to manipulate or
 * append to
 * @return Boolean: true
 */
function wfGlobalNotice( &$siteNotice ) {
	global $wgLang, $wgUser;

	// It is possible that there is a global notice (for example, for all
	// French-speaking users) *and* a forced global notice (for everyone,
	// informing them of planned server maintenance etc.)
	//
	// We append whatever we have to this variable and if right before
	// returning this variable is non-empty, we wrap the local site-notice in
	// a div with id="localSiteNotice" because users may want to hide global
	// notices (or forced global notices...that'd be quite dumb though)
	//
	// Come to think of it...on ShoutWiki, the $siteNotice variable will never
	// be empty because SendToAFriend hooks into SiteNoticeAfter hook, too, and
	// appends its HTML to it.
	$ourSiteNotice = '';

	// "Forced" globalnotice -- a site-wide notice shown for *all* users,
	// no matter what their language is
	// Used only for things like server migration notices etc.
	//
	// So, once again I find it that MediaWiki sucks. Adding 'parse' to the
	// options array adds <p> tags around the message, EVEN IF THE MESSAGE IS
	// EMPTY! This causes wfEmptyMsg() to think that the message has some
	// content, when in fact it doesn't.
	$forcedNotice = wfMsgExt(
		'forced-globalnotice',
		array( 'language' => 'en' )
	);
	if ( !wfEmptyMsg( 'forced-globalnotice', $forcedNotice ) ) {
		$ourSiteNotice .= '<div style="text-align: center;" id="forcedGlobalNotice">' .
			wfMsgExt(
				'forced-globalnotice',
				array( 'parse', 'language' => 'en' )
			) . '</div>';
	}

	// Global notice, depending on the user's language
	// This can be used to show language-specific stuff to users with a certain
	// interface language (i.e. "We need more French translators! Pouvez-vous nous aider ?")
	$globalNotice = wfMsgExt(
		'globalnotice',
		array( 'language' => $wgLang->getCode() )
	);
	if ( !wfEmptyMsg( 'globalnotice', $globalNotice ) ) {
		// Give the global notice its own ID and center it
		$ourSiteNotice .= '<div style="text-align: center;" id="globalNotice">' .
			wfMsgExt(
				'globalnotice',
				array( 'parse', 'language' => $wgLang->getCode() )
			) . '</div>';
	}

	// Group-specific global notices
	foreach( array( 'sysop', 'bureaucrat', 'bot', 'rollback' ) as $group ) {
		$messageName = 'globalnotice-' . $group;
		$globalNoticeForGroup = wfMsgExt(
			$messageName,
			array( 'language' => $wgLang->getCode() )
		);
		$isMember = in_array( $group, $wgUser->getEffectiveGroups() );
		if ( !wfEmptyMsg( $messageName, $globalNoticeForGroup ) && $isMember ) {
			// Give the global notice its own ID and center it
			$ourSiteNotice .= '<div style="text-align: center;" id="globalNoticeForGroup">' .
				wfMsgExt(
					$messageName,
					array( 'parse', 'language' => $wgLang->getCode() )
				) . '</div>';
		}
	}

	// If we have something to display, wrap the local sitenotice in a pretty
	// div and copy $ourSiteNotice to $siteNotice
	if ( !empty( $ourSiteNotice ) ) {
		$ourSiteNotice .= '<!-- end GlobalNotice --><div id="localSiteNotice">' . $siteNotice . '</div>';
		$siteNotice = $ourSiteNotice;
	}

	return true;
}

//$wgHooks['EditPage::showEditForm:initial'][] = 'wfGlobalNoticeOnEditPage';
/**
 * Show an annoying notice when editing MediaWiki:Forced-globalnotice because
 * that message is Serious Business™.
 * Disabled for production, might be too annoying -- but I just wanted to code
 * this feature. :)
 *
 * @param $editPage Object: instance of EditPage class
 * @return Boolean: true
function wfGlobalNoticeOnEditPage( &$editPage ) {
	// only initialize this when editing pages in MediaWiki namespace
	if( $editPage->mTitle->getNamespace() != 8 ) {
		return true;
	}

	// Show an annoying notice when editing MediaWiki:Forced-globalnotice
	// I considered using confirm() JS but it doesn't allow CSS properties
	// AFAIK and no CSS properties = less obtrusive notice = bad, so I ditched
	// that idea.
	if ( $editPage->mTitle->getDBkey() == 'Forced-globalnotice' ) {
		$editPage->editFormPageTop .= '<span style="color: red;">Hey, hold it right there!</span><br />
The value of this message is shown to <b>all users</b>, no matter what is their language. This can be <u>extremely</u> annoying.<br />
<span style="text-transform: uppercase; font-size: 20px;">Only use this for really important things, like server maintenance notices!</span><br />
Understood?
<br /><br />

<a href="#" onclick="document.getElementById( \'wpTextbox1\' ).style.display = \'block\'; return false;">Yes!</a>';
		// JavaScript must be injected here, wpTextbox1 doesn't exist before...
		$editPage->editFormTextAfterWarn .= '<script type="text/javascript">
			document.getElementById( \'wpTextbox1\' ).style.display = \'none\';
		</script>';
	}

	return true;
}
*/