<?php

class SassInlineImageFilterTest extends WikiaBaseTest {
	/**
	 * @dataProvider getProcessData
	 */
	public function testProcess( $input, $output ) {
		$filter = $this->getMockBuilder( 'Wikia\Sass\Filter\InlineImageFilter' )
			->disableOriginalConstructor()
			->setMethods( ['inlineFile'] )
			->getMock();

		$filter
			->method( 'inlineFile' )
			->will( $this->returnCallback( function ( $fileName ) {
				return "\"data:@$fileName@\"";
			} ) );

		$this->assertEquals( $filter->process( $input ), $output );
	}

	public function getProcessData() {
		return [[
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
			'background: url("data:@file.jpg@");'
		], [
			'background: url(file.jpg) centered; /* inline */',
			'background: url("data:@file.jpg@") centered;'
		], [
			'background: #fff url("/file/path/file.jpg") centered; /* inline */',
			'background: #fff url("data:@/file/path/file.jpg@") centered;'
		],
		];
	}

	/**
	 * @dataProvider getInlineFileData
	 */
	public function testInlineFile( $input, $fileContent, $output ) {
		$filter = $this->getMockBuilder( 'Wikia\Sass\Filter\InlineImageFilter' )
			->disableOriginalConstructor()
			->setMethods( ['checkFileExists', 'getFileContent'] )
			->getMock();

		$filter
			->method( 'checkFileExists' )
			->will( $this->returnValue( true ) );
		$filter
			->method( 'getFileContent' )
			->will( $this->returnValue( $fileContent ) );

		$this->assertEquals( $filter->process( $input ), $output );
	}

	public function getInlineFileData() {
		return [
			[
				'background: none;',
				'',
				'background: none;'
			],
			[
				'background: none; /* inline */',
				'',
				'background: none; /* inline */'
			],
			[
				'background: url("file.png");',
				'',
				'background: url("file.png");'
			],
			[
				'background: url("file.jpg"); /* inline */',
				'jpgContent',
				'background: url("data:image/jpeg;base64,anBnQ29udGVudA==");'
			],
			[
				'background: url("file.gif"); /* inline */',
				'gifContent',
				'background: url("data:image/gif;base64,Z2lmQ29udGVudA==");'
			],
			[
				'background: url("file.png"); /* inline */',
				'pngContent',
				'background: url("data:image/png;base64,cG5nQ29udGVudA==");'
			],
			[
				'background: url("file.svg"); /* inline */',
				'<svg>svgContent</svg>',
				'background: url("data:image/svg+xml;charset=utf-8,%3Csvg%3EsvgContent%3C%2Fsvg%3E");'
			],
			[
				'background: #fff url("file.svg") centered; /* inline */',
				'<svg>svgContent</svg>',
				'background: #fff url("data:image/svg+xml;charset=utf-8,%3Csvg%3EsvgContent%3C%2Fsvg%3E") centered;'
			],
		];
	}
}
