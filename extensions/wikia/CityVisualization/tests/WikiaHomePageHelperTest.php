<?php

class WikiaHomePageHelperTest extends WikiaBaseTest {
	public function testPreparePromotedBatchesForVisualization() {
		/* @var WikiaHomePageHelper $WHPHelper */
		$WHPHelper = $this->getMock('WikiaHomePageHelper', ['getImageUrl']);
		$WHPHelper
			->expects($this->any())
			->method('getImageUrl')
			->will($this->returnValue('image.jpg'));

		$batches = [
			WikiaHomePageHelper::PROMOTED_ARRAY_KEY => [],
			WikiaHomePageHelper::DEMOTED_ARRAY_KEY => []
		];

		for ($i = 0; $i < 3; $i++) {
			$batches[WikiaHomePageHelper::PROMOTED_ARRAY_KEY][] = [
				'wiki_name' => 'promoted',
				'wikiurl' => 'promoted_url',
				'main_image' => 'image'
			];
		}

		for ($i = 0; $i < 14; $i++) {
			$batches[WikiaHomePageHelper::DEMOTED_ARRAY_KEY][] = [
				'wiki_name' => 'normal',
				'wikiurl' => 'normal_url',
				'main_image' => 'image'
			];
		}

		$out = $WHPHelper->prepareBatchesForVisualization([$batches]);
		$this->assertEquals('promoted', $out[0][$WHPHelper::SLOTS_BIG_ARRAY_KEY][0]['wiki_name']);
		$this->assertEquals('promoted', $out[0][$WHPHelper::SLOTS_BIG_ARRAY_KEY][1]['wiki_name']);
		$this->assertEquals('promoted', $out[0][$WHPHelper::SLOTS_MEDIUM_ARRAY_KEY][0]['wiki_name']);

		for ($i = 0; $i < 14; $i++) {
			$this->assertEquals('normal', $out[0][$WHPHelper::SLOTS_SMALL_ARRAY_KEY][0]['wiki_name']);
		}

	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0126 ms
	 */
	public function testPrepareBatchesForVisualization() {
		/* @var WikiaHomePageHelper $WHPHelper */
		$WHPHelper = $this->getMock('WikiaHomePageHelper', ['getImageUrl']);
		$WHPHelper
			->expects($this->any())
			->method('getImageUrl')
			->will($this->returnValue('image.jpg'));

		$batches = [
			WikiaHomePageHelper::PROMOTED_ARRAY_KEY => [],
			WikiaHomePageHelper::DEMOTED_ARRAY_KEY => []
		];

		for ($i = 0; $i < 17; $i++) {
			$batches[WikiaHomePageHelper::DEMOTED_ARRAY_KEY][] = [
				'wiki_name' => 'normal',
				'wikiurl' => 'normal_url',
				'main_image' => 'image'
			];
		}

		$out = $WHPHelper->prepareBatchesForVisualization([$batches]);
		$this->assertEquals('normal', $out[0][$WHPHelper::SLOTS_BIG_ARRAY_KEY][0]['wiki_name']);
		$this->assertEquals('normal', $out[0][$WHPHelper::SLOTS_BIG_ARRAY_KEY][1]['wiki_name']);
		$this->assertEquals('normal', $out[0][$WHPHelper::SLOTS_MEDIUM_ARRAY_KEY][0]['wiki_name']);

		for ($i = 0; $i < 14; $i++) {
			$this->assertEquals('normal', $out[0][$WHPHelper::SLOTS_SMALL_ARRAY_KEY][0]['wiki_name']);
		}

	}

	public function testPrepareOnePromotedBatchesForVisualization() {
		/* @var WikiaHomePageHelper $WHPHelper */
		$WHPHelper = $this->getMock('WikiaHomePageHelper', ['getImageUrl']);
		$WHPHelper
			->expects($this->any())
			->method('getImageUrl')
			->will($this->returnValue('image.jpg'));

		$batches = [
			WikiaHomePageHelper::PROMOTED_ARRAY_KEY => [],
			WikiaHomePageHelper::DEMOTED_ARRAY_KEY => []
		];

		for ($i = 0; $i < 1; $i++) {
			$batches[WikiaHomePageHelper::PROMOTED_ARRAY_KEY][] = [
				'wiki_name' => 'promoted',
				'wikiurl' => 'promoted_url',
				'main_image' => 'image'
			];
		}

		for ($i = 0; $i < 16; $i++) {
			$batches[WikiaHomePageHelper::DEMOTED_ARRAY_KEY][] = [
				'wiki_name' => 'normal',
				'wikiurl' => 'normal_url',
				'main_image' => 'image'
			];
		}

		$out = $WHPHelper->prepareBatchesForVisualization([$batches]);
		$promotedCount = 0;
		if ($out[0][$WHPHelper::SLOTS_BIG_ARRAY_KEY][0]['wiki_name'] == 'promoted') {
			$promotedCount++;
		}
		if ($out[0][$WHPHelper::SLOTS_BIG_ARRAY_KEY][1]['wiki_name'] == 'promoted') {
			$promotedCount++;
		}
		if ($out[0][$WHPHelper::SLOTS_MEDIUM_ARRAY_KEY][0]['wiki_name'] == 'promoted') {
			$promotedCount++;
		}
		$this->assertEquals(1, $promotedCount);
		for ($i = 0; $i < 14; $i++) {
			$this->assertEquals('normal', $out[0][$WHPHelper::SLOTS_SMALL_ARRAY_KEY][0]['wiki_name']);
		}

	}
}
