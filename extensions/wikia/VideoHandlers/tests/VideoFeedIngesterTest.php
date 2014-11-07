<?php
/**
 * Class VideoFeedIngester
 *
 * @group MediaFeatures
 */
class VideoFeedIngesterTest extends WikiaBaseTest {

	/**
	 * Ooyala has to be loaded before providers which load their content onto Ooyala (aka, remote assets),
	 * otherwise videos can be uploaded more than once.
	 * See VID-1871 for more information.
	 */
	public function testOoyalaLoadedBeforeRemoteAssets() {
		$providers = FeedIngesterFactory::getActiveProviders();
		$ooyalaIndex = array_search( FeedIngesterFactory::PROVIDER_OOYALA, $providers );
		$screenplayIndex = array_search( FeedIngesterFactory::PROVIDER_SCREENPLAY, $providers );
		$ivaIndex = array_search( FeedIngesterFactory::PROVIDER_IVA, $providers );

		$this->assertTrue( $ooyalaIndex > $screenplayIndex, 'Ooyala should be loaded before screenplay' );
		$this->assertTrue( $ooyalaIndex < $ivaIndex, 'Ooyala should be loaded before iva' );
	}
}