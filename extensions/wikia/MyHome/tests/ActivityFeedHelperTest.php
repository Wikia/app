<?php

class ActivityFeedHelperTest extends WikiaBaseTest {

	public function testFilterTextBetweenTags() {
		$testCases = array(
			array(
				'in' => '<div>foo</div><noscript>test</noscript>',
				'out' => '<div>foo</div>',
			),
			array(
				'in' => '<figcaption class="thumbcaption"><span itemprop="geo" itemscope itemtype="http://data-vocabulary.org/Geo">52° 24.479\' N 16° 56.164\' E<meta itemprop="latitude" content="52.407991"><meta itemprop="longitude" content="16.936064"></span></figcaption>',
				'out' => '',
			),
			array(
				'in' => '<figcaption class="thumbcaption">Powódź w 1888.</figcaption><div class="picture-attribution"><img src="http://images.wikia.com/common/avatars/thumb/a/af/2240397.png/16px-2240397.png?cb=1320183718" width="16" height="16" class="avatar" alt="Shareif" />Dodane przez <a href="/wiki/U%C5%BCytkownik:Shareif">Shareif</a></div>',
				'out' => '',
			)
		);

		foreach($testCases as $testCase) {
			$this->assertEquals($testCase['out'], ActivityFeedHelper::filterTextBetweenTags($testCase['in']));
		}
	}
}