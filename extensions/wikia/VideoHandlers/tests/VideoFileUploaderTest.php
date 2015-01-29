<?php

/**
 * Class VideoFileUploaderTest
 *
 * @group MediaFeatures
 */
class VideoFileUploaderTest extends WikiaBaseTest {

	/**
	 * @dataProvider destinationTitleDataProvider
	 */
	public function testGetNormalizedDestinationTitle( $areIdentical, $title, $expectedTitle ) {
		if ( $areIdentical ) {
			$this->assertEquals( $expectedTitle, $title );
		} else {
			$this->assertNotEquals( $expectedTitle, $title );
		}

		$videoFileUploader = $this->getMock( 'VideoFileUploader', [ 'getSanitizedTitleText' ] );
		$videoFileUploader->expects( $this->once() )
			->method( 'getSanitizedTitleText' )
			->will( $this->returnValue( $title ) );

		$actualTitle = $videoFileUploader->getNormalizedDestinationTitle();

		$this->assertEquals( $expectedTitle, $actualTitle );
	}

	public function destinationTitleDataProvider() {
		return [
			// identical? - original title - normalized (composed) title
			[ true,         "", "" ],
			[ true,         "(S♥C)_-fall_for_you-_AU_(READ_DESCRIPTION!)", "(S♥C)_-fall_for_you-_AU_(READ_DESCRIPTION!)" ],
			[ true,         "plain english", "plain english" ],
			[ true,         "活動期間，大天使、新大天使與限定神（迦梨為通常機率）", "活動期間，大天使、新大天使與限定神（迦梨為通常機率）" ],
			[ true,         "Jak przełączyć się na skórkę Wygodną?", "Jak przełączyć się na skórkę Wygodną?" ],
			[ true,         " blah & @#$(*){}[]IY0987654321/?<>,.^", " blah & @#$(*){}[]IY0987654321/?<>,.^" ],
			[ true,         "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ],
			[ false,        "パズドラ", "パズドラ" ],
			[ false,        "パズドラ_ビギナーズガイド", "パズドラ_ビギナーズガイド"]
		];
	}
}
