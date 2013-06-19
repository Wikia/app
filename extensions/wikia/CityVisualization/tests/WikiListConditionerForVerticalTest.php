<?php

class WikiListConditionerForVerticalTest extends WikiaBaseTest {

	public function testGetPromotionCondition() {
		$conditioner = new WikiListConditionerForCollection([]);

		$isPromoted = false;
		$this->assertEquals(
			false,
			$conditioner->getPromotionCondition( $isPromoted ),
			'WikiListConditionerForCollection::getPromotionCondition returns false for promoted Wiki'
		);

		$isPromoted = true;
		$this->assertEquals(
			false,
			$conditioner->getPromotionCondition( $isPromoted ),
			'WikiListConditionerForCollection::getPromotionCondition returns false for promoted Wiki'
		);
	}

}
