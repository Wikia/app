<?php
/**
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class HeroImageToCuratedContentMigrator extends Maintenance {

	function execute() {
		global $wgCityId;
		$commData = new CommunityDataService($wgCityId);
		$curatedData = $commData->getCuratedContentData();

		$wikiData = new WikiDataModel(Title::newMainPage()->getText());
		$wikiData->getFromProps();
//
//		$this->output($wikiData->description."\n");
//		$this->output($wikiData->getImageName()."\n");
//		$this->output($wikiData->cropPosition."\n");
//		$this->output(Title::newFromText($wikiData->getImageName(), NS_IMAGE)->getArticleID());

		if (!empty($commData->getCommunityDescription())) {
			$curatedData['community_data']['description'] = $wikiData->description;
		}
		if (!empty($commData->getCommunityImageId())) {
			$curatedData['community_data']['image_id'] = Title::newFromText($wikiData->getImageName(), NS_IMAGE)->getArticleID();
		}
		$this -> output($curatedData);
//		$commData->setCuratedContent($curatedData);
	}
}

$maintClass = 'HeroImageToCuratedContentMigrator';
require_once( RUN_MAINTENANCE_IF_MAIN );
