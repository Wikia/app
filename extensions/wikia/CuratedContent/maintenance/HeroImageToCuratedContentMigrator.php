<?php
/**
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

//Migrates image and description from hero module to curated content.

class HeroImageToCuratedContentMigrator extends Maintenance {

	function execute() {
		global $wgCityId;
		$commData = new CommunityDataService($wgCityId);
		$curatedData = $commData->getCuratedContentData();

		$wikiData = new WikiDataModel(Title::newMainPage()->getText());
		$wikiData->getFromProps();

		// migrate description if there is no description in community data
		if (empty($commData->getCommunityDescription()) && !empty($wikiData->description)) {
			$curatedData['community_data']['description'] = $wikiData->description;
		}

		$heroImage = Title::newFromText($wikiData->getImageName(), NS_IMAGE);
		// migrate image if there is no image in community data
		if (empty($commData->getCommunityImageId()) && !empty($heroImage)) {
			$curatedData['community_data']['image_id'] = $heroImage->getArticleID();
		}

		$commData->setCuratedContent($curatedData);
	}
}

$maintClass = 'HeroImageToCuratedContentMigrator';
require_once( RUN_MAINTENANCE_IF_MAIN );
