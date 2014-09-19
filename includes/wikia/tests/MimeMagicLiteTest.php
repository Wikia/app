<?php

class MimeMagicLiteTest extends WikiaBaseTest {

	/**
	 * Make sure the mime types returned by MimeMagicLite are the same as those by MimeMagic
	 *
	 * @param string $typeName
	 * @param Array $types an array of mime types
	 * @dataProvider validMimeTypesProvider
	 */
	function testMimeTypeOfName($typeName, $types) {
		$lite = new MimeMagicLite();

		$this->assertEquals( $types, $lite->mMediaTypes[$typeName], $typeName );
	}

	function validMimeTypesProvider() {
		$mimeTypes = new MimeMagic();
		foreach ( $mimeTypes->mMediaTypes as $typeName => $types ) {
			$data[] = [$typeName, $types];
		}

		return $data;
	}
}
