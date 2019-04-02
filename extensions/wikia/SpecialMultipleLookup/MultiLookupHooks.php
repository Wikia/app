<?php

class MultiLookupHooks {
	static public function onContributionsToolLinks( $id, $nt, &$links ) {
		$user = RequestContext::getMain()->getUser();

		if ( $id == 0 && $user->isAllowed( 'multilookup' ) ) {
			$mlTitle = GlobalTitle::newFromText( 'MultiLookup', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL );
			$url = $mlTitle->getFullURL( [
				'wptarget' => $nt->getText(),
			] );
			$attribs = [
				'href' => $url,
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
			$task = \Wikia\Tasks\Tasks\MultiLookupTask::newLocalTask();
			$task->call( 'updateMultiLookup', $ip );
			$task->setQueue( \Wikia\Tasks\Queues\DeferredInsertsQueue::NAME );
			$task->queue();
		}
	}
}
