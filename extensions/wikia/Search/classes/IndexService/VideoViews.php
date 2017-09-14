<?php
/**
 * Class definition for Wikia\Search\IndexService\VideoViews
 */
namespace Wikia\Search\IndexService;
/**
 * This class is intended to serve as a single entry point for updating
 *
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class VideoViews extends AbstractService {
	/**
	 * For a video file, overwrites the 'views' field with the video views, extracted by a different service.
	 * (non-PHPdoc)
	 *
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		$service = $this->getService();
		$results = [];
		if ( $service->pageIdIsVideoFile( $this->currentPageId ) ) {
			$results['views'] = $service->getVideoViewsForPageId( $this->currentPageId );
		}

		return $results;
	}
}
