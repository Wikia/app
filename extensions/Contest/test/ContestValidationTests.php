<?php

/**
 * Contest form field validation tests cases.
 *
 * @ingroup Contest
 * @since 0.1
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ContestValidationTests extends MediaWikiTestCase {

	/**
	 * Tests @see SpecialMyContests::::validateSubmissionField
	 */
	public function testURLValidation() {
		$tests = array(
			'https://github.com/JeroenDeDauw/smwcon/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b' => true,
			'https://github.com/Jeroen-De-Dauw42/smwcon_-42/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b' => true,
//			'https://github.com/JeroenDeDauw$/smwcon/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b' => false,
//			'https://github.com/JeroenDeDauw/smwcon/tree3/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b' => false,
//			'https://github.com/JeroenDeDauw/smwcon/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53' => false,
//			'https://github.com/JeroenDeDauw/smwcon/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53ba' => false,
//			'https://github.com/JeroenDeDauw/smwc*/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b' => false,
			'in ur unit test, being quite silly' => false,
			'   https://github.com/JeroenDeDauw/smwcon/tree/f9b26ec4ba1101b1f5d4ef76b7ae6ad3dabfb53b   ' => true,
			'' => true,
			'   ' => true,
			'https://github.com/JeroenDeDauw/smwcon' => true,
			'https://github.com/JeroenDeDauw' => true,
			'https://gitorious.org/statusnet' => true,
			'https://gitorious.org/statusnet/mainline/merge_requests/2224' => true,
		);

		foreach ( $tests as $test => $isValid ) {
			if ( $isValid ) {
				$this->assertEquals( true, SpecialMyContests::validateSubmissionField( $test ) );
			}
			else {
				$this->assertFalse( SpecialMyContests::validateSubmissionField( $test ) === true );
			}
		}
	}

	/**
	 * Tests @see ContestDBObject::select and @see ContestDBObject::count
	 */
	public function testObjectSelectCount() {
		$classes = array( 'Contest', 'ContestChallenge' );

		foreach ( $classes as $class ) {
			// $this->assertEquals( count( $class::s()->select() ), $class::s()->count() );
		}
	}

}
