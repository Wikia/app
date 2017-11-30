<?php

use PHPUnit\Framework\TestCase;

class PhalanxMatchParamsTest extends TestCase {
	/** @var PhalanxMatchParams $phalanxMatchParams */
	private $phalanxMatchParams;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Phalanx_setup.php';

		$this->phalanxMatchParams = new PhalanxMatchParams();
	}

	/**
	 * @dataProvider provideQueryParams
	 * @param int $wiki
	 * @param string $langCode
	 * @param string $type
	 * @param string $content
	 * @param string $user
	 * @param int $userId
	 */
	public function testBuildQueryParams(
		int $wiki, string $langCode, string $type, string $content, string $user, int $userId
	) {
		$this->phalanxMatchParams
			->cityId( $wiki )
			->langCode( $langCode )
			->type( $type )
			->content( $content )
			->userName( $user )
			->userId( $userId );

		$this->assertEquals(
			"content=$content&lang=$langCode&type=$type&user=$user&userId=$userId&wiki=$wiki",
			$this->phalanxMatchParams->buildQueryParams()
		);
	}

	public function provideQueryParams(): Generator {
		yield [ 177, 'en', 'user', 'karamba', 'TestUser', 3208 ];
		yield [ 831, 'de', 'title', 'loremipsum', 'Wikia', 3435 ];
		yield [ 3274367567, 'ru', 'content', 'alamakota', 'blah', 173268 ];
	}

	public function testMultiContentParam() {
		$content = [ 'foo', 'bar' ];
		$this->phalanxMatchParams->content( $content );

		$this->assertEquals(
			'content=foo&content=bar',
			$this->phalanxMatchParams->buildQueryParams()
		);

		$content = [ 'baz', 'bar', 'bar' ];

		$this->phalanxMatchParams->content( $content );

		$this->assertEquals(
			'content=baz&content=bar',
			$this->phalanxMatchParams->buildQueryParams()
		);
	}

	public function testNullKeysAreNotParsed() {
		$this->assertEmpty( $this->phalanxMatchParams->buildQueryParams() );
	}
}
