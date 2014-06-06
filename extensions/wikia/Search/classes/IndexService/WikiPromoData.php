<?php
/**
 * Class definition for \Wikia\Search\IndexService\WikiPromoData;
 * @author relwell
 *
 */
namespace Wikia\Search\IndexService;
/**
 * Responsible for wiki promo info for a wiki
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class WikiPromoData extends AbstractWikiService
{
	/**
	 * Allows us to cache the result after requesting once
	 * @var array
	 */
	protected $result = array();

    /**
	 * Access the promo text for a given wiki and set it in the document
	 * @return array containing result data
	 */
	public function execute() {
		$service = $this->getService();
		if ( $this->result == array() && $service->isOnDbCluster() ) {
			$detail = $service->getVisualizationInfoForWikiId( $service->getWikiId() );
			$this->result = array(
				'wiki_description_txt' => $detail['desc'],
				'wiki_official_b' => empty( $detail['flags']['official'] ) ? 'false' : 'true',
				'wiki_promoted_b' => empty( $detail['flags']['promoted'] ) ? 'false' : 'true',
			);
		}
		return $this->result;
	}
}
