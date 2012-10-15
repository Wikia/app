<?php

/**
 * SurveyQuestion test case.
 *
 * @ingroup Survey
 * @since 0.1
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SurveyQuestionTest extends MediaWikiTestCase {

	/**
	 * Tests SurveyQuestion::newFromUrlData and SurveyQuestion::toUrlData
	 */
	public function testQuestionUrlSerialization() {
		$question = new SurveyQuestion( 9001, 42, 'ohai there!', 0, true );

		$this->assertEquals(
			$question,
			SurveyQuestion::newFromUrlData( $question->toUrlData() ),
			"Serializaion test failed at " . __METHOD__
		);
	}

}
