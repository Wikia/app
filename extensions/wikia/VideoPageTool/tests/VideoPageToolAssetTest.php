<?php

/**
 * Class VideoPageToolAssetTest
 *
 * These tests expect to be run against a wiki that has the Video Page Tool extension enabled and, with that,
 * the appropriate DB tables.
 */
class VideoPageToolAssetTest extends WikiaBaseTest {

	/** @var VideoPageToolProgram */
	protected $program;
	protected $programID;

	public function setUp() {
		$language = 'en';
		$date = 158486400; // This is Jan 9th, 1975 a date suitably far in the past but doing well for its age thank you very much

		$this->program = VideoPageToolProgram::newProgram( $language, $date );

		if ( empty($this->program) ) {
			throw new Exception("Failed to load program with lang=$langauge and date=$date");
		}
		$this->program->save();

		$this->programID = $this->program->getProgramId();
	}

	/**
	 * @dataProvider CRUDAssetData
	 */
	public function testCRUDAsset( $type, $order, $data ) {
		$section = $type::SECTION;

		/** @var VideoPageToolAsset $asset */
		$asset = VideoPageToolAsset::newAsset($this->programID, $section, $order );

		$this->assertInstanceOf( $type, $asset, "Failed to create new $type object" );

		$asset->setData($data);

		$status = $asset->save();
		$this->assertTrue( $status->isGood(), 'Failed to save new $type object' );

		// Check getters
		$this->assertEquals( $this->programID, $asset->getProgramId(), 'Got wrong program ID' );
		$this->assertInternalType( 'integer', $asset->getAssetId(), 'Result of getAssetId is not an integer' );
		$this->assertEquals( $section, $asset->getSection(), 'Got wrong section name' );
		$this->assertEquals( $order, $asset->getOrder(), 'Got wrong order number');

	}

	public function CRUDAssetData() {
		return [
			[ 'VideoPageToolAssetFeatured', 1,
				[
					'videoKey'     => 'test_title',
					'displayTitle' => 'Test Display Title',
					'description'  => 'This is a test description',
					'altThumbKey'  => 'Alternate Thumb Title',
				]
			],
			[ 'VideoPageToolAssetCategory', 1,
				[

				]
			],
		];
	}

	public function tearDown() {
		$this->program->delete();
	}
}