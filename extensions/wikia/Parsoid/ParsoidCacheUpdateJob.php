<?php

class ParsoidCacheUpdateJob extends Job {

	var $type, $table, $start, $end;

	function __construct( $title, $params, $id = 0 ) {
		parent::__construct( 'ParsoidCacheUpdateJob' . $params['type'], $title, $params, $id );
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

	public function run() {
		global $wgUpdateRowsPerJob;

		if ( $this->type === 'invalidate' ) {
			$titles = $this->title->getBacklinkCache()->getLinks( $this->table, $this->start, $this->end );
			$this->invalidateTitles( $titles );
		} else if ( $this->type === 'OnDependencyChange' ) {
			$cache = $this->title->getBacklinkCache();
			$batches = $cache->partition( $this->table, $wgUpdateRowsPerJob );
			$jobs = array();
			foreach ( $batches as $batch ) {
				 list( $start, $end ) = $batch;
				 $jobs[] = new ParsoidCacheUpdateJob( $this->title, array (
				 	'type' => 'invalidate',
				 	'table' => $this->table,
				 	'start' => $start,
				 	'end' => $end
				 ) );
			}
			Job::batchInsert( $jobs );
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
	}

	protected function invalidateTitle( Title $title ) {
		global $wgParsoidCacheServers;

		# First request the new version
		$parsoidInfo = array();
		$parsoidInfo['cacheID'] = $title->getPreviousRevisionID( $title->getLatestRevID() );
		$parsoidInfo['changedTitle'] = $this->title->getPrefixedDBkey();

		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			$requests[] = array(
				'url'     => $this->getParsoidURL( $title, $server ),
				'headers' => array(
					'X-Parsoid: ' . json_encode( $parsoidInfo ),
					// Force implicit cache refresh similar to
					// https://www.varnish-cache.org/trac/wiki/VCLExampleEnableForceRefresh
					'Cache-control: no-cache'
				)
			);
		}
		$this->checkCurlResults( CurlMultiClient::request( $requests ) );

		# And now purge the previous revision so that we make efficient use of
		# the Varnish cache space without relying on LRU. Since the URL
		# differs we can't use implicit refresh.
		$requests = array();
		foreach ( $wgParsoidCacheServers as $server ) {
			// @TODO: this triggers a getPreviousRevisionID() query per server
			$requests[] = array(
				'url' => $this->getParsoidURL( $title, $server, true )
			);
		}
		$options = CurlMultiClient::getDefaultOptions();
		$options[CURLOPT_CUSTOMREQUEST] = "PURGE";
		$this->checkCurlResults( CurlMultiClient::request( $requests, $options ) );
		return $this->getLastError() == null;
	}

}
