<?php
/**
 * Handle global interwikis and local interlanguage links without adding the
 * interwiki table to $wgSharedTables.
 * If we add 'interwiki' to $wgSharedTables, it will mess up inter*language*
 * links.
 * For example, on fi.24.shoutwiki.com, [[fr:]] should point to
 * fr.24.shoutwiki.com, not to fr.shoutwiki.com.
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @date 3 April 2011 (original patch dated July 12/13, 2009)
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 * @link http://www.mediawiki.org/wiki/Extension:ShoutWiki_Interwiki_Magic Documentation
 * @see http://bugzilla.shoutwiki.com/show_bug.cgi?id=12
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point to MediaWiki.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'ShoutWiki Interwiki Magic',
	'version' => '1.0',
	'author' => 'Jack Phoenix',
	'description' => 'Handle global interwikis and local interlanguage links',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ShoutWiki_Interwiki_Magic',
);

// This hook was added in r84173, on 17:51, 17 March 2011
$wgHooks['InterwikiLoadPrefix'][] = 'wfShoutWikiInterwikiMagic';

/**
 * This function does all the magic for non-language interwikis, i.e. stuff
 * that is /not/ something like "en", "fr", etc.
 *
 * @param $prefix String: interwiki prefix we are looking for
 * @param $iwData Array: output array describing the interwiki with keys
 *                       iw_url, iw_local, iw_trans and optionally iw_api and
 *                       iw_wikiid.
 * @return Boolean: true by default, false when fetching interwikis from the
 *                  shared database ($wgSharedDB)
 */
function wfShoutWikiInterwikiMagic( $prefix, &$iwData ) {
	global $wgContLang, $wgSharedDB;
	if( !$wgContLang->getLanguageName( $prefix ) ) {
		$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );
		$res = $dbr->select(
			'interwiki',
			'*',
			array( 'iw_prefix' => $prefix ),
			__METHOD__
		);
		$iwData = $dbr->fetchRow( $res );
		// docs/hooks.txt says: Return true without providing an interwiki to
		// continue interwiki search.
		// At this point, we can safely return false because we know that we
		// have something
		return false;
	}
	return true;
}