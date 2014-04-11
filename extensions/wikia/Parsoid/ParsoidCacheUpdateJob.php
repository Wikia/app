<?php

use Wikia\Logger\WikiaLogger;

class ParsoidCacheUpdateJob extends Job {

	var $type, $table, $start, $end;

	function __construct( $title, $params, $id = 0 ) {
		parent::__construct( 'ParsoidCacheUpdateJob', $title, $params, $id );
		$this->type = $params['type'];
		if ( isset( $params['table'] ) ) {
			$this->table = $params['table'];
		}
		if ( isset( $params['start'] ) ) {
			$this->start = $params['start'];
		}
		if ( isset( $params['end'] ) ) {
			$this->end = $params['end'];
		}
	}

	public function wikiaLog( $data ) {
		WikiaLogger::instance()->debug( "ParsoidCacheUpdateJob", $data );
	}

	public function run() {
		$this->wikiaLog( array( "action" => "run", "type" => $this->type ) );

		if ( $this->type === 'OnDependencyChange' ) {
			if ( isset( $this->start ) && isset( $this->end ) ) {
				$titles = $this->title->getBacklinkCache()->getLinks( $this->table, $this->start, $this->end );
				$this->invalidateTitles( $titles );
			} else {
				$cache = $this->title->getBacklinkCache();
				$batches = $cache->partition( $this->table, 50 );
				$jobs = array();
				foreach ( $batches as $batch ) {
					 list( $start, $end ) = $batch;
					 $jobs[] = new ParsoidCacheUpdateJob( $this->title, array (
					 	'type' => 'OnDependencyChange',
					 	'table' => $this->table,
					 	'start' => $start,
					 	'end' => $end
					 ) );
				}
				Job::batchInsert( $jobs );
			}
		} else if ( $this->type === 'OnEdit' ) {
			$this->invalidateTitle( $this->title );
		}
	}

	protected function getParsoidURL( Title $title, $server, $prev = false ) {
		global $wgParsoidWikiPrefix, $wgVisualEditorParsoidURL;

		$oldid = $prev ?
			$title->getPreviousRevisionID( $title->getLatestRevID() ) :
			$title->getLatestRevID();

		return $wgVisualEditorParsoidURL . '/' . wfExpandUrl( wfScript( 'api' ) ) . '/' .
			wfUrlencode( $title->getPrefixedDBkey() ) . '?oldid=' . $oldid;
	}

	protected function checkCurlResults( $results ) {
		foreach( $results as $k => $result ) {
			if ($results[$k]['error'] != null) {
				$this->setLastError($results[$k]['error']);
				return false;
			}
		}
		return true;
	}

	protected function invalidateTitles( $titles ) {
		global $wgParsoidCacheServers, $wgContentNamespaces;

		$parsoidInfo = array();
		$parsoidInfo['changedTitle'] = $this->title->getPrefixedDBkey();
		$parsoidInfo['mode'] = $this->table == 'templatelinks' ? 'templates' : 'files';

		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			foreach ( $titles as $key => $title ) {
				if ( !in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
					continue;
				}
				$singleUrl = $this->getParsoidURL( $title, $server );
				$parsoidInfo['cacheID'] = $title->getLatestRevID();
				$requests[] = array(
					'url'     => $singleUrl,
					'headers' => array(
						'X-Parsoid: ' . json_encode( $parsoidInfo ),
						// Force implicit cache refresh similar to
						// https://www.varnish-cache.org/trac/wiki/VCLExampleEnableForceRefresh
						'Cache-control: no-cache'
					)
				);
				$this->wikiaLog( array(
					"action" => "invalidateTitles",
					"get_url" => $singleUrl
				) );
			}
		}

		$this->checkCurlResults( CurlMultiClient::request( $requests ) );
		return $this->getLastError() == null;
	}

	protected function invalidateTitle( Title $title ) {
		global $wgParsoidCacheServers, $wgContentNamespaces;

		if ( !in_array( $title->getNamespace(), $wgContentNamespaces ) ) {
			return;
		}

		# First request the new version
		$parsoidInfo = array();
		$parsoidInfo['cacheID'] = $title->getPreviousRevisionID( $title->getLatestRevID() );
		$parsoidInfo['changedTitle'] = $this->title->getPrefixedDBkey();

		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			$singleUrl = $this->getParsoidURL( $title, $server );
			$requests[] = array(
				'url'     => $singleUrl,
				'headers' => array(
					'X-Parsoid: ' . json_encode( $parsoidInfo ),
					// Force implicit cache refresh similar to
					// https://www.varnish-cache.org/trac/wiki/VCLExampleEnableForceRefresh
					'Cache-control: no-cache'
				)
			);
			$this->wikiaLog( array(
				"action" => "invalidateTitle",
				"get_url" => $singleUrl
			) );
		}
		$this->checkCurlResults( CurlMultiClient::request( $requests ) );

		# And now purge the previous revision so that we make efficient use of
		# the Varnish cache space without relying on LRU. Since the URL
		# differs we can't use implicit refresh.
		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			// @TODO: this triggers a getPreviousRevisionID() query per server
			$singleUrl = $this->getParsoidURL( $title, $server, true );
			$requests[] = array(
				'url' => $singleUrl
			);
			$this->wikiaLog( array(
				"action" => "invalidateTitle",
				"purge_url" => $singleUrl
			) );
		}
		$options = CurlMultiClient::getDefaultOptions();
		$options[CURLOPT_CUSTOMREQUEST] = "PURGE";
		$this->checkCurlResults( CurlMultiClient::request( $requests, $options ) );
		return $this->getLastError() == null;
	}

}
