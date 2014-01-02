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
