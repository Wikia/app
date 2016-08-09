<?php

/**
 * Class WikiaExternalImageList
 * Hook handlers related to the global external image whitelist
 */
class WikiaExternalImageList {
	/**
	 * @var int COMMUNITY_WIKI_ID Community Central wiki id
	 */
	const COMMUNITY_WIKI_ID = 177;

	/**
	 * @var string GLOBAL_WHITELIST_PAGE Title of the MediaWiki page that serves as the global external image whitelist
	 */
	const GLOBAL_WHITELIST_PAGE = 'Global external image whitelist';

	/**
	 * Hook: outputMakeExternalImage
	 * Checks the given URL against the global external image whitelist file
	 * Whitelist entries are treated the same way as MediaWiki:External image whitelist
	 *
	 * @param string $url
	 * @return bool Whether the URL matches an item in the global external image whitelist
	 */
	public static function onOutputMakeExternalImage( &$url ) {
		$listPage = GlobalTitle::newFromTextCached( static::GLOBAL_WHITELIST_PAGE, NS_MEDIAWIKI, static::COMMUNITY_WIKI_ID );
		$list = explode( "\n", $listPage->getContent() ?? '' );

		// Handle whitelist items in the same way as MediaWiki:External image whitelist
		// Remove blank entries/comments
		$i = 0;
		foreach ( $list as $entry ) {
			if ( strpos( $entry, '#' ) === 0 || $entry === '' ) {
				unset( $list[$i] );
			}
			$i++;
		}

		// Combine and evaluate the list as a single regular expression
		$combinedRegex = implode( '|', $list );
		$combinedRegex = str_replace( '/', '\\/', $combinedRegex );

		return (bool) preg_match( '/(' . $combinedRegex . ')/i', $url );
	}
}
