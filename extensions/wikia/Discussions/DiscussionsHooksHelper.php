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
	 * @see WantedPagesPage::getQueryInfo()
	 *
	 * @param WantedPagesPage $wantedPagesPage
	 * @param array $queryInfo
	 */
	public static function onWantedPagesGetQueryInfo( $wantedPagesPage, array &$queryInfo ) {
		$queryInfo['conds'][] = "pg2.page_namespace != '" . NS_WIKIA_FORUM_BOARD_THREAD . "'";
	}

	/**
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @param $scripts
	 */
	public static function addDiscussionJsVariable( array &$vars, &$scripts ) {
		global $wgDiscussionsApiUrl;
		$vars['wgDiscussionsApiUrl'] = $wgDiscussionsApiUrl;
	}
}
