<?php
/**
 * Class definition for \Wikia\Search\IndexService\All
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\MediaWikiService;
/**
 * Aggregates all other services into a single request -- good for populating a full index
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class All extends AbstractService
{
	/**
	 * These are the services whose outputs will be aggregated during execute. 
	 * @var array
	 */
	protected $services = array(
			'Wikia\Search\IndexService\DefaultContent'  => null,
			'Wikia\Search\IndexService\BacklinkCount'   => null,
			'Wikia\Search\IndexService\MediaData'       => null,
			'Wikia\Search\IndexService\Metadata'        => null,
			'Wikia\Search\IndexService\Redirects'       => null,
			'Wikia\Search\IndexService\Wam'             => null,
			'Wikia\Search\IndexService\WikiPromoData'   => null,
			'Wikia\Search\IndexService\WikiStats'       => null,
			'Wikia\Search\IndexService\WikiViews'       => null,
			'Wikia\Search\IndexService\VideoViews'      => null // note the order of operations -- AFTER metadata
			);
	
	/**
	 * Invokes a bunch of other services' execute functions
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		if ( $this->currentPageId === null ) {
			throw new \Exception( "This service requires a page ID to be set." );
		}
		$result = array();
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