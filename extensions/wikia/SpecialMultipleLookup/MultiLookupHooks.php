<?php

class MultiLookupHooks {
	static public function onContributionsToolLinks( $id, $nt, &$links ) {
		$user = RequestContext::getMain()->getUser();

		if ( $id == 0 && $user->isAllowed( 'multilookup' ) ) {
			$attribs = [
				'href' => 'http://community.wikia.com/wiki/Special:MultiLookup?wptarget=' . urlencode( $nt->getText() ),
				'title' => wfMessage( 'multilookupselectuser' )->text(),
			];

			$links[] = Html::element( 'a', $attribs, wfMessage( 'multilookup' )->text() );
		}

		return true;
	}

	/**
	 * Update MultiLookup with IP activity each time an event is saved to Recent Changes
	 * @param RecentChange $recentChange
	 */
	static public function onRecentChangeSave( RecentChange $recentChange ) {
		$ip = $recentChange->getUserIp();

		if ( IP::isIPAddress( $ip ) ) {
			global $wgCityId;

			$task = ( new \Wikia\Tasks\Tasks\MultiLookupTask() )
				->wikiId( $wgCityId );
			$task->call( 'updateMultiLookup', $ip );
			$task->queue();
		}
	}
}
