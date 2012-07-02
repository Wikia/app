<?php

/**
 * Tests for the Education Program extension.
 *
 * @ingroup EducationProgram
 * @since 0.1
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPTests extends MediaWikiTestCase {

	/**
	 * Tests @see EPUtils::getKeyPrefixedValues
	 */
	public function testGetKeyPrefixedValues() {
		$input = array(
			'key' => 'value',
			' key   ' => ' value ',
			'- key 2 -' => '- value 2 -',
		);
		
		$output = array(
			'key' => 'key - value',
			' key   ' => ' key    -  value ',
			'- key 2 -' => '- key 2 - - - value 2 -',
		);

		// TODO: test this test
		$this->assertEquals( $output, EPUtils::getKeyPrefixedValues( $input ) );
	}

}
