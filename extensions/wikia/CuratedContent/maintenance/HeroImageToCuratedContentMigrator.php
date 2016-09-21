<?php
/**
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

//Migrates image and description from hero module to curated content.

class HeroImageToCuratedContentMigrator extends Maintenance {
	function __construct() {
		$this->addOption( 'dry-run', 'just show curated content data after migration but dont save it' );
		parent::__construct();
	}

	function execute() {
		global $wgCityId;
		$dryRun = $this->hasOption('dry-run');

		$commData = new CommunityDataService($wgCityId);
		$curatedData = $commData->getCuratedContentData();

		if ($dryRun) {
			$this->output("\ndry run for ".$wgCityId."\n");
			$this->output("curated content before migration:\n".json_encode($curatedData)."\n");
		}

		$wikiData = new WikiDataModel(Title::newMainPage()->getText());
		$wikiData->getFromProps();

		// migrate description if there is no description in community data
		if (empty($commData->getCommunityDescription()) && !empty($wikiData->description)) {
			$curatedData['community_data']['description'] = $wikiData->description;
		}

		$heroImage = Title::newFromText($wikiData->getImageName(), NS_FILE);
		// migrate image if there is no image in community data
		if (empty($commData->getCommunityImageId()) && !empty($heroImage)) {
			$curatedData['community_data']['image_id'] = $heroImage->getArticleID();
		}

		if ($dryRun) {
			$this->output("\ncurated content after migration:\n".json_encode($curatedData)."\n");
		} else {
			$commData->setCuratedContent($curatedData, "migrating data from Hero Module");
		}
	}
}

$maintClass = 'HeroImageToCuratedContentMigrator';
require_once( RUN_MAINTENANCE_IF_MAIN );
