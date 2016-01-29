<?php
/**
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../../usr/wikia/slot1/current/src/maintenance/Maintenance.php' );

class PromoteToCuratedContentMigrator extends Maintenance {

	function execute() {
		global $wgCityId, $wgLang, $wgDBname;

		$cv = new CityVisualization();

		$description = $this->getPromoteDescription( $cv, $wgCityId, $wgLang->getCode() );

		$image = ( new PromoImage( PromoImage::MAIN, $wgDBname ) );
		$corporateWikiId = $cv->getTargetWikiId( $wgLang->getCode() );
		$imageTitle = $image->getOriginFile()->getTitle();
		$imageId = $imageTitle->exists() ? $imageTitle->getArticleID() : null;

		if ( !empty( $imageId ) ) {
			// we are good to go; image exists on the destination wiki
		} else {
			// image does not exist on this community
			// we first need to fetch it from the corporate wiki
			$imageUrl = $image->getOriginFile($corporateWikiId)->getUrl();

			// we need to upload the image to the local wiki or store it in a commonly accessible place...
		}

		$communityDataService = new CommunityDataService( $wgCityId );
		var_dump($communityDataService->get());

		$this->output( "\n" );
		$this->output( "Done\n" );
	}

	/**
	 * @param $cv
	 * @param $wgCityId
	 * @param $wgLang
	 * @return mixed
	 */
	public function getPromoteDescription( $cv, $cityId, $langCode ) {
		$data = $cv->getWikiData( $cityId, $langCode, new WikiGetDataForVisualizationHelper() );

		if ( !empty( $data['description'] ) ) {
			$description = $data['description'];
			return $description;
		}

		return null;
	}
}

$maintClass = 'PromoteToCuratedContentMigrator';
require_once( RUN_MAINTENANCE_IF_MAIN );

