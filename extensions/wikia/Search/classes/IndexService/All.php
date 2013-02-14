<?php
/**
 * Class definition for \Wikia\Search\IndexService\All
 */
namespace Wikia\Search\IndexService;
use Wikia\Search\MediaWikiInterface;
/**
 * Aggregates all other services into a single request -- good for populating a full index
 * @author relwell
 */
class All extends AbstractService
{
	protected $services = array(
			'DefaultContent'  => null,
			'BacklinkCount'   => null,
			'MediaData'       => null,
			'Metadata'        => null,
			'Redirects'       => null,
			'Wam'             => null,
			'WikiPromoData'   => null,
			'WikiStats'       => null,
			'WikiViews'       => null
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
				$service = Factory::getInstance()->get( $serviceName );
				$this->services[$serviceName] = $service;
			}
			$subResult = $service->setPageId( $this->currentPageId )->execute();
			if ( is_array( $subResult ) ) {
    			$result = array_merge( $result, $subResult );
			}
		}
		return $result;
	}
	
}