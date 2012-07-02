<?php

class RSSHooks {
	/**
	 * Tell the parser how to handle <rss> elements
	 * @param $parser Parser Object
	 */
	static function parserInit( $parser ) {
		# Install parser hook for <rss> tags
		$parser->setHook( 'rss', array( __CLASS__, 'renderRss' ) );
		return true;
	}

	/**
	 * Static function wrapping RSSParser to handle rendering of RSS elements
	 * @param $input String: text inside the tags.
	 * @param $args Array: value associative list of the element attributes and
	 * 						their values.
	 * @param $parser Parser
	 * @param $frame PPFrame parser context
	 */
	static function renderRss( $input, $args, $parser, $frame ) {
		global $wgRSSCacheAge, $wgRSSCacheCompare, $wgRSSNamespaces, $wgRSSAllowedFeeds;

		if ( is_array( $wgRSSNamespaces ) && count( $wgRSSNamespaces ) ) {
			$ns = $parser->getTitle()->getNamespace();
			$checkNS = array_flip( $wgRSSNamespaces );

			if( !isset( $checkNS[$ns] ) ) {
				return wfMsg( 'rss-ns-permission' );
			}
		}

		if ( count( $wgRSSAllowedFeeds ) && !in_array( $input, $wgRSSAllowedFeeds ) ) {
			return wfMsg( 'rss-url-permission' );
		}

		if ( !Http::isValidURI( $input ) ) {
			return wfMsg( 'rss-invalid-url', htmlspecialchars( $input ) );
		}
		if ( $wgRSSCacheCompare ) {
			$timeout = $wgRSSCacheCompare;
		} else {
			$timeout = $wgRSSCacheAge;
		}

		$parser->getOutput()->updateCacheExpiry( $timeout );

		$rss = new RSSParser( $input, $args );

		$status = $rss->fetch();

		# Check for errors.
		if ( !$status->isGood() ) {
			return wfMsg( 'rss-error', htmlspecialchars( $input ), $status->getWikiText() );
		}

		if ( !is_object( $rss->rss ) || !is_array( $rss->rss->items ) ) {
			return wfMsg( 'rss-empty', htmlspecialchars( $input ) );
		}

		return $rss->renderFeed( $parser, $frame );
	}
}
