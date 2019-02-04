<?php

class CachedRedirects {
	/**
	 * Hook to clear caches for linked materials
	 *
	 * @param Title $title -- instance of Title class
	 * @param User $user -- current user
	 * @param string $reason -- undeleting reason
	 *
	 * @return true -- because it's hook
	 */
	public static function onUndeleteComplete( Title $title, $user, $reason ) {
		if ( $title->getNamespace() == NS_FILE ) {
			self::purgeRedir( $title );
		} else {
			self::doClearLinkedFilesCache( $title->getArticleID() );
		}

		return true;
	}

	/**
	 * Hook to clear caches for linked materials
	 *
	 * @param Title $title -- instance of Title class
	 * @param User $user -- current user
	 * @param string $reason -- undeleting reason
	 *
	 * @return true -- because it's hook
	 */
	public static function onArticleDeleteComplete( WikiPage $page, $user, $reason, $id, $links ) {
		self::doClearLinkedFilesCache( $page->mTitle->getArticleID(), $links );

		return true;
	}


	/**
	 * Hook to fetch linked materials
	 *
	 * @param $id Int: page_id value of the page being deleted
	 * @param $links container for links
	 */
	public static function onGetFileLinks( $id, &$links ) {
		$links = self::getFileLinks( $id );
	}


	/**
	 * Hook to clear cache for redirect
	 *
	 * @param Title $title -- instance of Title class
	 *
	 */
	private static function purgeRedir( $title ) {
		global $wgMemc, $wgCityId;
		$redirKey = wfMemcKey( 'redir', $title->getPrefixedText() );
		$wgMemc->delete( $redirKey );
		$title->invalidateCache();
		$task = ( new \Wikia\Tasks\Tasks\HTMLCacheUpdateTask() )
			->wikiId( $wgCityId )
			->title( $title );
		$task->call( 'purge', 'imagelinks' );
		$task->queue();
	}


	/**
	 * getFileLinks get links to material
	 *
	 * @param $id Int: page_id value of the page being deleted
	 */
	public static function getFileLinks( $id ) {
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->select( [ 'imagelinks' ], [ 'il_to' ], [ 'il_from' => $id ], __METHOD__,
			[ 'ORDER BY' => 'il_to', ] );
	}

	/**
	 * Clear memcache redirs before db changed
	 *
	 * @param $id Int: page_id value of the page being deleted
	 */
	public static function doClearLinkedFilesCache( $id, $results = null ) {
		global $wgCityId;
		if ( is_null( $results ) ) {
			$results = self::getFileLinks( $id );
		}
		foreach ( $results as $row ) {
			$title = Title::makeTitleSafe( NS_FILE, $row->il_to );
			self::purgeRedir( $title );
			$title->invalidateCache();
			$task = ( new \Wikia\Tasks\Tasks\HTMLCacheUpdateTask() )
				->wikiId( $wgCityId )
				->title( $title );
			$task->call( 'purge', 'imagelinks' );
			$task->queue();
		}
	}


}
