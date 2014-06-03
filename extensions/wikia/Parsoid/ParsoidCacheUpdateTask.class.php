<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Queues\ParsoidPurgePriorityQueue;

class ParsoidCacheUpdateTask extends BaseTask {
	/**
	 * find which articles depend on this resource being changed
	 *
	 * @param string $table db table to check. ex: 'imagelinks', 'templatelinks'
	 * @return array list of task ids that will purge the dependencies in parsoid
	 */
	public function findDependencies( $table ) {
		global $wgCityId;

		$cache = $this->title->getBacklinkCache();
		$batches = $cache->partition( $table, 20 );
		$taskLists = [ ];
		foreach ( $batches as $batch ) {
			list( $start, $end ) = $batch;
			$task = (new ParsoidCacheUpdateTask())->title($this->title);
			$taskLists[ ] = ( new AsyncTaskList() )
				->setPriority(ParsoidPurgePriorityQueue::NAME)
				->wikiId($wgCityId)
				->add( $task->call( 'onDependencyChange', $table, $start, $end ) );
		}

		$result = [];
		if (!empty($taskLists)) {
			$result = AsyncTaskList::batch( $taskLists );
		}

		return $result;
	}

	public function onDependencyChange( $table, $start, $end ) {
		$titles = $this->title->getBacklinkCache()->getLinks( $table, $start, $end );

		return $this->invalidateTitles( $table, $titles );
	}

	public function onEdit() {
		return $this->invalidateTitle( $this->title );
	}

	protected function getParsoidURL( Title $title, $prev = false ) {
		global $wgVisualEditorParsoidURL;

		$oldid = $prev ? $title->getPreviousRevisionID( $title->getLatestRevID() ) : $title->getLatestRevID();

		return $wgVisualEditorParsoidURL . '/' . wfExpandUrl( wfScript( 'api' ) ) . '/' .
			wfUrlencode( $title->getPrefixedDBkey() ) . '?oldid=' . $oldid;
	}

	protected function checkCurlResults( $results ) {
		foreach ( $results as $k => $result ) {
			if ( $results[ $k ][ 'error' ] != null ) {
				throw new Exception( $results[ $k ][ 'error' ] );
			}
		}

		return true;
	}

	protected function invalidateTitles( $table, $titles ) {
		global $wgParsoidCacheServers, $wgContentNamespaces;

		$parsoidInfo = array();
		$parsoidInfo[ 'changedTitle' ] = $this->title->getPrefixedDBkey();
		$parsoidInfo[ 'mode' ] = $table == 'templatelinks' ? 'templates' : 'files';

		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			foreach ( $titles as $key => $title ) {
				/** @var Title $title */
				if ( !in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
					continue;
				}
				$singleUrl = $this->getParsoidURL( $title );
				$parsoidInfo[ 'cacheID' ] = $title->getLatestRevID();
				$requests[ ] = array(
					'url' => $singleUrl,
					'headers' => array(
						'X-Parsoid: ' . json_encode( $parsoidInfo ),
						// Force implicit cache refresh similar to
						// https://www.varnish-cache.org/trac/wiki/VCLExampleEnableForceRefresh
						'Cache-control: no-cache'
					)
				);
				$this->wikiaLog( array( "action" => "invalidateTitles", "get_url" => $singleUrl ) );
			}
		}

		return $this->checkCurlResults( CurlMultiClient::request( $requests ) );
	}

	protected function invalidateTitle( Title $title ) {
		global $wgParsoidCacheServers, $wgContentNamespaces;

		if ( !in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			return false;
		}

		# First request the new version
		$parsoidInfo = array();
		$parsoidInfo[ 'cacheID' ] = $title->getPreviousRevisionID( $title->getLatestRevID() );
		$parsoidInfo[ 'changedTitle' ] = $this->title->getPrefixedDBkey();

		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			$singleUrl = $this->getParsoidURL( $title );
			$requests[ ] = array( 'url' => $singleUrl, 'headers' => array( 'X-Parsoid: ' . json_encode( $parsoidInfo ), // Force implicit cache refresh similar to
				// https://www.varnish-cache.org/trac/wiki/VCLExampleEnableForceRefresh
				'Cache-control: no-cache' ) );
			$this->wikiaLog( array( "action" => "invalidateTitle", "get_url" => $singleUrl ) );
		}
		$this->checkCurlResults( CurlMultiClient::request( $requests ) );

		# And now purge the previous revision so that we make efficient use of
		# the Varnish cache space without relying on LRU. Since the URL
		# differs we can't use implicit refresh.
		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			// @TODO: this triggers a getPreviousRevisionID() query per server
			$singleUrl = $this->getParsoidURL( $title, true );
			$requests[ ] = array( 'url' => $singleUrl );
			$this->wikiaLog( array( "action" => "invalidateTitle", "purge_url" => $singleUrl ) );
		}
		$options = CurlMultiClient::getDefaultOptions();
		$options[ CURLOPT_CUSTOMREQUEST ] = "PURGE";

		return $this->checkCurlResults( CurlMultiClient::request( $requests, $options ) );
	}

	private function wikiaLog( $data ) {
		WikiaLogger::instance()->debug( "ParsoidCacheUpdateTask", $data );
	}
}