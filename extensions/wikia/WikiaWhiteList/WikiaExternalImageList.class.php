<?php

/**
 * Class WikiaExternalImageList
 * Hook handlers related to the global external image whitelist
 */
class WikiaExternalImageList {

	/**
	 * @var string GLOBAL_WHITELIST_PAGE Title of the MediaWiki page that serves as the global external image whitelist
	 */
	const GLOBAL_WHITELIST_PAGE = 'Global external image whitelist';

	/**
	 * Hook: outputMakeExternalImage
	 * Checks the given URL against the global external image whitelist file
	 * Whitelist entries are treated the same way as MediaWiki:External image whitelist
	 *
	 * @param string $url URL to be matched against the global external image whitelist
	 * @return bool Whether the URL matches an item in the global external image whitelist
	 */
	public static function onOutputMakeExternalImage( &$url ) {
		$listPage = GlobalTitle::newFromTextCached( static::GLOBAL_WHITELIST_PAGE, NS_MEDIAWIKI, Wikia::COMMUNITY_WIKI_ID );
		$list = explode( "\n", $listPage->getContent() ?? '' );

		// Handle whitelist items in the same way as MediaWiki:External image whitelist
		// Remove blank entries/comments
		$list = array_filter( $list, function ( $entry ) {
			return ( strpos( $entry, '#' ) !== 0 && $entry !== '' );
		} );

		// Combine and evaluate the list as a single regular expression
		$combinedRegex = implode( '|', $list );

		// Escape slashes
		$combinedRegex = str_replace( '/', '\\/', $combinedRegex );

		return preg_match( '/(' . $combinedRegex . ')/i', $url ) === 1;
	}
}
