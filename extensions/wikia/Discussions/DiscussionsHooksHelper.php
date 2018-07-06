<?php

class DiscussionsHooksHelper {
	/**
	 * IRIS-5184: Exclude outgoing links in Forum content from Special:WhatLinksHere
	 * @see SpecialWhatLinksHere::showIndirectLinks()
	 *
	 * @param array $pageLinkCondition
	 */
	public static function onSpecialWhatLinksHereBeforeQuery( array &$pageLinkCondition ) {
		$pageLinkCondition[] = "page_namespace != '" . NS_WIKIA_FORUM_BOARD_THREAD . "'";
	}

	/**
	 * IRIS-5184: Exclude outgoing links in Forum content from Special:WantedPages report
	 * @see WantedPagesPage::getExcludedSourceNamespaces()
	 *
	 * @param int[] $namespaces
	 */
	public static function onWantedPagesGetExcludedSourceNamespaces( array &$namespaces ) {
		$namespaces[] = NS_WIKIA_FORUM_BOARD_THREAD;
	}

	/**
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @param $scripts
	 */
	public static function addDiscussionJsVariable( array &$vars, &$scripts ) {
		global $wgDiscussionsApiUrl;
		$vars['wgDiscussionsApiUrl'] = $wgDiscussionsApiUrl;
	}

	/**
	 * Changing all links to Thread:xxx to blue links
	 * @see WallHooksHelper::onLinkBegin
	 *
	 * @param $skin
	 * @param $target
	 * @param $text
	 * @param $customAttribs
	 * @param $query
	 * @param $options
	 * @param $ret
	 * @internal param \Title $title
	 * @internal param bool $result
	 *
	 * @return true -- because it's a hook
	 */
	public static function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
		global $wgEnableWallEngine;
		// We need this logic only when the Wall extension is disabled
		// This method is a direct copy from WallHooksHelper::onLinkBegin
		if ( !empty( $wgEnableWallEngine ) ) {
			return true;
		}

		if ( !( $target instanceof Title ) ) {
			return true;
		}

		if ( self::isWallNamespace( $target->getNamespace() ) ) {

			// remove "broken" assumption/override
			$brokenKey = array_search( 'broken', $options );
			if ( $brokenKey !== false ) {
				unset( $options[$brokenKey] );
			}

			// make the link "blue"
			$options[] = 'known';
		}

		return true;
	}

	private static function isWallNamespace( $ns ) {
		global $wgWallNS;

		return in_array( MWNamespace::getSubject( $ns ), $wgWallNS );
	}
}
