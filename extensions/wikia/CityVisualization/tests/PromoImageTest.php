<?php

class PromoImageTest extends WikiaBaseTest {

	private static function ensureSampleData( $cityId ) {
		$db = wfGetDB( DB_MASTER, array(), F::app()->wg->ExternalSharedDB );

		$numFound = ( new WikiaSQL() )->SELECT( "city_id" )
			->FROM( PromoImage::TABLE_CITY_VISUALIZATION_XWIKI )
			->WHERE( "city_id" )->EQUAL_TO( $cityId )
			->run( $db )->numRows();
		if ( $numFound == 0 ) {
			$sql = new WikiaSQL();
			$sql->INSERT( PromoImage::TABLE_CITY_VISUALIZATION_XWIKI )
				->SET( 'city_id', $cityId )
				->SET( 'city_lang_code', "en" )
				->SET( 'city_Vertical', 2 )
				->SET( 'city_headline', "test321" )
				->SET( 'city_description', "test123" )
				->SET( 'city_flags', "0" );
			return $sql->run( $db );
		} else {
			return true;
		}
	}

	/**
	 * @group Slow
	 */
	public function testSampleFlow() {
		//FIXME: mark this test as a integration
		$WIKI_ID = 203236; // mediawiki119
		self::ensureSampleData( $WIKI_ID );

		$promoHelper = PromoImage::forWikiId( PromoImage::MAIN, $WIKI_ID );
		$img = $promoHelper->createNewImage();
		$srcFile = GlobalFile::newFromText( "Wiki-wordmark.png", 831 ); // get wordmark from muppets

		$this->assertEquals( $img->uploadByUrl( $srcFile->getUrl() ), UPLOAD_ERR_OK ); // upload muppets wordmark
		$promoHelper->insertImageIntoDB( $img, ImageReviewStatuses::STATE_APPROVED );

		$beforeCulling = $promoHelper->getApprovedImage( true );
		$promoHelper->demoteOldImages( ImageReviewStatuses::STATE_APPROVED );
		$reviewed = $promoHelper->getApprovedImage( true );

		$this->assertEquals( $img->getUrl(), $reviewed->getUrl() );
		$this->assertEquals( $beforeCulling->getUrl(), $reviewed->getUrl() );
	}

	/**
	 * @group Slow
	 */
	public function testFilterNewFiles() {
		$WIKI_ID = 203236; // mediawiki119
		self::ensureSampleData( $WIKI_ID );

		$promoHelper = PromoImage::forWikiId( PromoImage::MAIN, $WIKI_ID );
		$img = $promoHelper->createNewImage();
		$srcFile = GlobalFile::newFromText( "Wiki-wordmark.png", 831 ); // get wordmark from muppets
		$this->assertEquals( $img->uploadByUrl( $srcFile->getUrl() ), UPLOAD_ERR_OK ); // upload muppets wordmark
		$promoHelper->insertImageIntoDB( $img, ImageReviewStatuses::STATE_APPROVED );

		$sampleImageList = [ $img->getName(), "some_name" ];
		$filteredList = $promoHelper->filterOnlyNewImageNames( $sampleImageList );

		$this->assertEquals( count( $filteredList ), 1 );
		$this->assertEquals( $filteredList[0], "some_name" );
	}
}