<?php
/**
 * User: artur
 * Date: 13.05.13
 * Time: 10:41
 */

class RevisionServiceCacheWrapper implements IRevisionService {
	private $revisionService;
	private $cacheTime;
	private $cacheKey;

	function __construct( IRevisionService $revisionService, $cacheTime ) {
		$this->cacheTime = $cacheTime;
		$this->revisionService = $revisionService;
		$this->cacheKey = "RevisionServiceCacheWrapper_" . F::app()->wg->DBname;
	}


	public function getLatestRevisions() {
		return WikiaDataAccess::cache( $this->cacheKey, $this->cacheTime, function() {
			return $this->revisionService->getLatestRevisions();
		});
	}

	public function getCacheTime() {
		return $this->cacheTime;
	}

	public function setCacheTime($cacheTime) {
		$this->cacheTime = $cacheTime;
	}
}
