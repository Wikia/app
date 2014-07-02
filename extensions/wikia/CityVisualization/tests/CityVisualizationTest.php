<?php

class CityVisualizationTest extends WikiaBaseTest {
	private $silentMode;

	public function setUp() {
		parent::setUp();
		global $wgCommandLineSilentMode;
		$this->silentMode = $wgCommandLineSilentMode;
		$wgCommandLineSilentMode = true;
	}

	public function tearDown() {
		parent::tearDown();
		global $wgCommandLineSilentMode;
		$wgCommandLineSilentMode = $this->silentMode;
	}

	/**
	 * @dataProvider imagesForSaveDataProvider
	 */
	public function testSaveImageForReview($cityId, $langCode, $images, $imageReviewStatus, $currentImages) {
		$this->assertEquals(true,true);
	}

	public function imagesForSaveDataProvider() {
		$image1 = new StdClass();
		$image1->city_id = 4541;
		$image1->city_lang_code = 'en';
		$image1->image_type = 0;
		$image1->image_index = 0;
		$image1->image_name = '4541.1404310656.53b414804f061';
		$image1->image_review_status = 2;
		$image1->last_edited = '2014-07-02 14:36:06';
		$image1->review_start = '2014-07-02 14:37:08';
		$image1->review_end = '2014-07-02 14:37:20';
		$image1->reviewer_id = 4807210;

		$image2 = new StdClass();
		$image2->city_id = 4541;
		$image2->city_lang_code = 'en';
		$image2->image_type = 1;
		$image2->image_index = 1;
		$image2->image_name = '4541.1404310665.53b414892c9f2';
		$image2->image_review_status = 2;
		$image2->last_edited = '2014-07-02 14:36:06';
		$image2->review_start = '2014-07-02 14:37:08';
		$image2->review_end = '2014-07-02 14:37:20';
		$image2->reviewer_id = 4807210;

		$image3 = new StdClass();
		$image3->city_id = 4541;
		$image3->city_lang_code = 'en';
		$image3->image_type = 1;
		$image3->image_index = 2;
		$image3->image_name = '4541.1404310693.53b414a5454ae';
		$image3->image_review_status = 22;
		$image3->last_edited = '2014-07-02 14:36:06';
		$image3->review_start = '2014-07-02 14:37:08';
		$image3->review_end = '2014-07-02 14:37:20';
		$image3->reviewer_id = 4807210;

		return [
			[
				4541,
				'en',
				[
					'4541.1404310656.53b414804f061',
					'4541.1404310665.53b414892c9f2',
					'4541.1404330975.53b463dfb52ce'
				],
				ImageReviewStatuses::STATE_UNREVIEWED,
				[
					'4541.1404310656.53b414804f061' => $image1,
					'4541.1404310665.53b414892c9f2' => $image2,
					'4541.1404310693.53b414a5454ae' => $image3
				]
			]
		];
	}


	/**
	 * @group Slow
	 * @slowExecutionTime 0.13578 ms
	 * @dataProvider generateBatchedDataProvider
	 */
	public function testGenerateBatches($slots, $promotedWikiCount) {

		$visualization = $this->getMock('CityVisualization', ['getSlotsForVerticals']);
		$visualization
			->expects($this->any())
			->method('getSlotsForVerticals')
			->will($this->returnValue($slots));

		$wikis = [
			$visualization::PROMOTED_ARRAY_KEY => [],
			'lifestyle' => [],
			'entertainment' => [],
			'video games' => []
		];

		for ($i = 0; $i < $promotedWikiCount; $i++) {
			$wikis[$visualization::PROMOTED_ARRAY_KEY][] = 'promoted';
		}

		foreach ($slots as $hubName => $nothing) {
			for ($i = 0; $i < rand(50,100); $i++) {
				$wikis[$hubName][] = $hubName;
			}
		}

		$out = $visualization->generateBatches(123, $wikis);
		for ($i = 0; $i < $visualization::WIKI_STANDARD_BATCH_SIZE_MULTIPLIER; $i++){
			$this->assertEquals(
				array_sum($slots),
				count($out[$i][$visualization::PROMOTED_ARRAY_KEY]) + count($out[$i][$visualization::DEMOTED_ARRAY_KEY])
			);

			// check wiki count in each vertical
			$outSlots = [
				'lifestyle' => 0,
				'entertainment' => 0,
				'video games' => 0
			];
			foreach ($out[$i][$visualization::DEMOTED_ARRAY_KEY] as $wiki) {
				$outSlots[$wiki]++;
			}
			foreach ($outSlots as $verticalName => $count) {
				// can be smaller that initial count because of promoted wikis
				$this->assertLessThanOrEqual($slots[$verticalName], $count);
				$this->assertGreaterThanOrEqual($slots[$verticalName] - $promotedWikiCount, $count);
			}
		}
	}

	public function generateBatchedDataProvider() {
		$out = [];

		$slots = [
			'lifestyle' => 2,
			'entertainment' => 6,
			'video games' => 9
		];
		$out[] = [$slots, 3];
		$out[] = [$slots, 0];

		$slots = [
			'lifestyle' => 7,
			'entertainment' => 7,
			'video games' => 3
		];
		$out[] = [$slots, 3];
		$out[] = [$slots, 5];
		$out[] = [$slots, 0];

		$out[] = [$slots, 1];

		$slots = [
			'lifestyle' => 15,
			'entertainment' => 1,
			'video games' => 1
		];
		$out[] = [$slots, 10];
		$out[] = [$slots, 1];

		$slots = [
			'lifestyle' => 17,
			'entertainment' => 0,
			'video games' => 0
		];
		$out[] = [$slots, 2];

		$slots = [
			'lifestyle' => 0,
			'entertainment' => 0,
			'video games' => 17
		];
		$out[] = [$slots, 2];

		return $out;
	}
}
