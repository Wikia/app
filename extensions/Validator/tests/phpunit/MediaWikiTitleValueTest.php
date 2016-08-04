<?php

namespace ParamProcessor\Tests;

use ParamProcessor\MediaWikiTitleValue;

/**
 * @covers ParamProcessor\MediaWikiTitleValue
 *
 * @group Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MediaWikiTitleValueTest extends \PHPUnit_Framework_TestCase {

	public function testGivenValidPage_getValueWorks(  ) {
		$titleValue = new MediaWikiTitleValue( \Title::newFromText( 'Foobar' ) );
		$this->assertSame( 'Foobar', $titleValue->getValue()->getFullText() );
	}

}
