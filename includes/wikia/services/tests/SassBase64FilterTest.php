<?php

class SassBase64FilterTest extends WikiaBaseTest
{
	/**
	 * @dataProvider getProcessData
	 */
	public function testProcess($input, $output) {
		$filter = $this->getMockBuilder( 'Wikia\Sass\Filter\Base64Filter' )
			->disableOriginalConstructor()
			->setMethods( [ 'encodeFile' ] )
			->getMock();

		$filter
			->method( 'encodeFile' )
			->will  ( $this->returnCallback( function($fileName) { return "data:@$fileName@"; } ) );

		$this->assertEquals( $filter->process( $input ), $output );
	}

	public function getProcessData() {
		return [ [
				'background: none;',
				'background: none;'
			], [
				'background: url("file.png");',
				'background: url("file.png");'
			], [
				'background: none; /* base64 */',
				'background: none; /* base64 */'
			], [
				'background: url("file.jpg"); /* base64 */',
				'background: url(data:@file.jpg@);'
			], [
				'background: url(file.jpg) centered; /* base64 */',
				'background: url(data:@file.jpg@) centered;'
			], [
				'background: #fff url("/file/path/file.jpg") centered; /* base64 */',
				'background: #fff url(data:@/file/path/file.jpg@) centered;'
			],
			];
	}
}
