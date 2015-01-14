<?php

class SassInlineImageFilterTest extends WikiaBaseTest
{
	/**
	 * @dataProvider getProcessData
	 */
	public function testProcess($input, $output) {
		$filter = $this->getMockBuilder( 'Wikia\Sass\Filter\InlineImageFilter' )
			->disableOriginalConstructor()
			->setMethods( [ 'inlineFile' ] )
			->getMock();

		$filter
			->method( 'inlineFile' )
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
				'background: none; /* inline */',
				'background: none; /* inline */'
			], [
				'background: url("file.jpg"); /* inline */',
				'background: url(data:@file.jpg@);'
			], [
				'background: url(file.jpg) centered; /* inline */',
				'background: url(data:@file.jpg@) centered;'
			], [
				'background: #fff url("/file/path/file.jpg") centered; /* inline */',
				'background: #fff url(data:@/file/path/file.jpg@) centered;'
			],
			];
	}
}
