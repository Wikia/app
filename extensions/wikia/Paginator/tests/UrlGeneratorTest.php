<?php

namespace Wikia\Paginator;

class UrlGeneratorTest extends \WikiaBaseTest {
	public function dataProviderGetUrlForPage() {
		return [
			// Invalid page number
			[ '', 'pageUrlParam', 1, 'a', null, 'InvalidArgumentException' ],
			[ '', 'pageUrlParam', 1, [], null, 'InvalidArgumentException' ],
			[ '', 'pageUrlParam', 1, 2, null, 'InvalidArgumentException' ],
			[ '', 'pageUrlParam', 1, null, null, 'InvalidArgumentException' ],

			// Empty URL
			[ '', 'pageUrlParam', 0, 1, '' ],
			[ '', 'pageUrlParam', 1, 1, '' ],
			[ '', 'pageUrlParam', 2, 1, '' ],
			[ '', 'pageUrlParam', 2, 2, '?pageUrlParam=2' ],
			[ '', 'pageUrlParam', 10, 1, '' ],
			[ '', 'pageUrlParam', 10, 5, '?pageUrlParam=5' ],
			[ '', 'pageUrlParam', 10, 10, '?pageUrlParam=10' ],

			// Full URL
			[ 'http://wikia.com/WAM', 'pageUrlParam', 0, 1, 'http://wikia.com/WAM' ],
			[ 'http://wikia.com/WAM', 'pageUrlParam', 1, 1, 'http://wikia.com/WAM' ],
			[ 'http://wikia.com/WAM', 'pageUrlParam', 2, 1, 'http://wikia.com/WAM' ],
			[ 'http://wikia.com/WAM', 'pageUrlParam', 2, 2, 'http://wikia.com/WAM?pageUrlParam=2' ],
			[ 'http://wikia.com/WAM', 'pageUrlParam', 10, 1, 'http://wikia.com/WAM' ],
			[ 'http://wikia.com/WAM', 'pageUrlParam', 10, 5, 'http://wikia.com/WAM?pageUrlParam=5' ],
			[ 'http://wikia.com/WAM', 'pageUrlParam', 10, 10, 'http://wikia.com/WAM?pageUrlParam=10' ],

			// Partial URL
			[ '/WAM', 'pageUrlParam', 0, 1, '/WAM' ],
			[ '/WAM', 'pageUrlParam', 1, 1, '/WAM' ],
			[ '/WAM', 'pageUrlParam', 2, 1, '/WAM' ],
			[ '/WAM', 'pageUrlParam', 2, 2, '/WAM?pageUrlParam=2' ],
			[ '/WAM', 'pageUrlParam', 10, 1, '/WAM' ],
			[ '/WAM', 'pageUrlParam', 10, 5, '/WAM?pageUrlParam=5' ],
			[ '/WAM', 'pageUrlParam', 10, 10, '/WAM?pageUrlParam=10' ],

			// Partial URL with one param
			[ '/WAM?sort=desc', 'pageUrlParam', 0, 1, '/WAM?sort=desc' ],
			[ '/WAM?sort=desc', 'pageUrlParam', 1, 1, '/WAM?sort=desc' ],
			[ '/WAM?sort=desc', 'pageUrlParam', 2, 1, '/WAM?sort=desc' ],
			[ '/WAM?sort=desc', 'pageUrlParam', 2, 2, '/WAM?sort=desc&pageUrlParam=2' ],
			[ '/WAM?sort=desc', 'pageUrlParam', 10, 1, '/WAM?sort=desc' ],
			[ '/WAM?sort=desc', 'pageUrlParam', 10, 5, '/WAM?sort=desc&pageUrlParam=5' ],
			[ '/WAM?sort=desc', 'pageUrlParam', 10, 10, '/WAM?sort=desc&pageUrlParam=10' ],

			// Partial URL with two params
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 0, 1, '/WAM?sort=desc&hub=tv' ],
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 1, 1, '/WAM?sort=desc&hub=tv' ],
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 2, 1, '/WAM?sort=desc&hub=tv' ],
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 2, 2, '/WAM?sort=desc&hub=tv&pageUrlParam=2' ],
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 10, 1, '/WAM?sort=desc&hub=tv' ],
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 10, 5, '/WAM?sort=desc&hub=tv&pageUrlParam=5' ],
			[ '/WAM?sort=desc&hub=tv', 'pageUrlParam', 10, 10, '/WAM?sort=desc&hub=tv&pageUrlParam=10' ],

			// Empty URL with one param
			[ '?sort=desc', 'pageUrlParam', 0, 1, '?sort=desc' ],
			[ '?sort=desc', 'pageUrlParam', 1, 1, '?sort=desc' ],
			[ '?sort=desc', 'pageUrlParam', 2, 1, '?sort=desc' ],
			[ '?sort=desc', 'pageUrlParam', 2, 2, '?sort=desc&pageUrlParam=2' ],
			[ '?sort=desc', 'pageUrlParam', 10, 1, '?sort=desc' ],
			[ '?sort=desc', 'pageUrlParam', 10, 5, '?sort=desc&pageUrlParam=5' ],
			[ '?sort=desc', 'pageUrlParam', 10, 10, '?sort=desc&pageUrlParam=10' ],

			// Empty URL with two params
			[ '?sort=desc&hub=tv', 'pageUrlParam', 0, 1, '?sort=desc&hub=tv' ],
			[ '?sort=desc&hub=tv', 'pageUrlParam', 1, 1, '?sort=desc&hub=tv' ],
			[ '?sort=desc&hub=tv', 'pageUrlParam', 2, 1, '?sort=desc&hub=tv' ],
			[ '?sort=desc&hub=tv', 'pageUrlParam', 2, 2, '?sort=desc&hub=tv&pageUrlParam=2' ],
			[ '?sort=desc&hub=tv', 'pageUrlParam', 10, 1, '?sort=desc&hub=tv' ],
			[ '?sort=desc&hub=tv', 'pageUrlParam', 10, 5, '?sort=desc&hub=tv&pageUrlParam=5' ],
			[ '?sort=desc&hub=tv', 'pageUrlParam', 10, 10, '?sort=desc&hub=tv&pageUrlParam=10' ],

			// Special case: 0 items in total, requesting first pageUrlParam
		];
	}

	/**
	 * @param $url
	 * @param $pageParam
	 * @param $pagesCount
	 * @param $pageNumber
	 * @param $expectedUrl
	 * @param $exceptionClass
	 *
	 * @dataProvider dataProviderGetUrlForPage
	 */
	public function testGetUrlForPage( $url, $pageParam, $pagesCount, $pageNumber, $expectedUrl, $exceptionClass = null ) {
		$urlGenerator = new UrlGenerator( $url, $pageParam, $pagesCount );
		if ( $exceptionClass ) {
			$this->setExpectedException( $exceptionClass );
			$urlGenerator->getUrlForPage( $pageNumber );
		} else {
			$this->assertEquals( $expectedUrl, $urlGenerator->getUrlForPage( $pageNumber ) );
		}
	}
}
