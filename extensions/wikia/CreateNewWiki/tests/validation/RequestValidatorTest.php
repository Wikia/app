<?php

use Wikia\CreateNewWiki\RequestValidator;

class RequestValidatorTest extends WikiaBaseTest {
	/** @var WebRequest|PHPUnit_Framework_MockObject_MockObject $webRequestMock */
	private $webRequestMock;

	/** @var RequestValidator $requestValidator */
	private $requestValidator;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->webRequestMock = $this->createMock( WebRequest::class );

		$this->requestValidator = new RequestValidator();
	}

	/**
	 * @expectedException \Wikia\CreateNewWiki\MissingParamsException
	 *
	 * @dataProvider provideInvalidParams
	 * @param array $params
	 */
	public function testMissingParamsAreNotValid( array $params ) {
		$this->webRequestMock->expects( $this->once() )
			->method( 'getArray' )
			->with( 'data' )
			->willReturn( $params );

		$this->requestValidator->assertValidParams( $this->webRequestMock );
	}

	public function provideInvalidParams() {
		$requiredParamKeys = [
			'wName', 'wDomain', 'wLanguage'
		];

		$data = [];

		foreach ( $requiredParamKeys as $paramKey ) {
			$data[$paramKey] = true;
			yield [ $data ];
		}
	}

	public function testCompleteParamsAreValid() {
		$data = [
			'wName' => true,
			'wDomain' => true,
			'wLanguage' => true,
			'wVertical' => true,
		];

		$this->webRequestMock->expects( $this->once() )
			->method( 'getArray' )
			->with( 'data' )
			->willReturn( $data );

		$result = $this->requestValidator->assertValidParams( $this->webRequestMock );

		$this->assertTrue( $result );
	}
}
