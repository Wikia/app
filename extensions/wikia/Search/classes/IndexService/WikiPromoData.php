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
		wfProfileIn(__METHOD__);
		if ( $this->result == array() && $this->service->getGlobal( 'EnableWikiaHomePageExt' ) ) {
			$homepageHelper = new \WikiaHomePageHelper();
			$detail = $homepageHelper->getWikiInfoForVisualization( $this->service->getWikiId(), $this->service->getLanguageCode() );
			$this->result = array(
				'wiki_description_txt' => $detail['description'],
				'wiki_new_b' => empty( $detail['new'] ) ? 'false' : 'true',
				'wiki_hot_b' => empty( $detail['hot'] ) ? 'false' : 'true',
				'wiki_official_b' => empty( $detail['official'] ) ? 'false' : 'true',
				'wiki_promoted_b' => empty( $detail['promoted'] ) ? 'false' : 'true',
			);
		}
		wfProfileOut(__METHOD__);
		return $this->result;
	}
}
