<?php

namespace Wikia\Search\IndexService;

use Exception;

/**
 * Aggregates all other services into a single request -- good for populating a full index.
 *
 * This is a copy paste from All.php, which has been adjusted for Unified Search purposes.
 * This class is not meant to stay, rather than that it's meant to be a stage in the migration to use Unified Search
 * rather than Solr.
 * @package Search
 * @subpackage IndexService
 */
class AllUnifiedSearch extends AbstractService {
	/**
	 * These are the services whose outputs will be aggregated during execute.
	 *
	 * @var array
	 */
	protected $services = [
		'Wikia\Search\IndexService\FullContent' => null,
		'Wikia\Search\IndexService\BacklinkCount' => null,
		'Wikia\Search\IndexService\MediaData' => null,
		'Wikia\Search\IndexService\Metadata' => null,
		'Wikia\Search\IndexService\WikiViews' => null,
		'Wikia\Search\IndexService\VideoViews' => null, // note the order of operations -- AFTER metadata
	];

	/**
	 * Invokes a bunch of other services' execute functions
	 *
	 * @throws Exception
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		if ( $this->currentPageId === null ) {
			throw new Exception( "This service requires a page ID to be set." );
		}
		$result = [];
		foreach ( $this->services as $serviceName => $service ) {
			if ( $service === null ) {
				$service = new $serviceName();
				$this->services[$serviceName] = $service;
			}
			$subResult = $service->setPageId( $this->currentPageId )->getResponse();
			if ( is_array( $subResult ) ) {
				$result = array_merge( $result, $subResult );
			}
		}

		return $result;
	}

}
