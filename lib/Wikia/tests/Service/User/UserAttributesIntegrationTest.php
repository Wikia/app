<?php
namespace Wikia\Service\User\Attributes;

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use PHPUnit\Framework\TestCase;
use Wikia\Domain\User\Attribute;
use Wikia\Factory\ServiceFactory;

/**
 * @group Integration
 */
class UserAttributesIntegrationTest extends TestCase {
	use \HttpIntegrationTest;

	/** @var UserAttributes $userAttributes */
	private $userAttributes;

	/** @var int $testUserId */
	private $testUserId = 123;

	protected function setUp() {
		parent::setUp();

		$serviceFactory = new ServiceFactory();
		$serviceFactory->providerFactory()->setUrlProvider( $this->getMockUrlProvider() );

		$this->userAttributes = $serviceFactory->attributesFactory()->userAttributes();
	}

	public function testLoadAndSaveMultipleAttributes() {
		$readExp = Phiremock::onRequest( 'GET', "/user/{$this->testUserId}" )
			->thenRespond( 200, file_get_contents( __DIR__ . '/fixtures/sample_attributes.json' ) );

		$this->getMockServer()->createExpectation( $readExp );

		$patchRequest =
			A::patchRequest()
				->andUrl( Is::equalTo( "/user/{$this->testUserId}" ) )
				->andHeader( 'Content-Type', Is::equalTo( 'application/x-www-form-urlencoded' ) )
				->andBody( Is::containing( 'attribute_one=test&attribute_two=other' ) );

		$writeExp = Phiremock::on( $patchRequest )->thenRespond( 200, file_get_contents( __DIR__ . '/fixtures/sample_attributes.json' ) );

		$this->getMockServer()->createExpectation( $writeExp );

		$this->assertEquals(
			'some default',
			$this->userAttributes->getAttribute( $this->testUserId, 'attribute_one' )
		);
		$this->assertEquals(
			'other default',
			$this->userAttributes->getAttribute( $this->testUserId, 'attribute_two' )
		);
		$this->assertEquals(
			'unchanged',
			$this->userAttributes->getAttribute( $this->testUserId, 'attribute_three' )
		);
		
		$this->userAttributes->setAttribute( $this->testUserId, new Attribute( 'attribute_one', 'test' ) );
		$this->userAttributes->setAttribute( $this->testUserId, new Attribute( 'attribute_two', 'other' ) );
		
		$this->userAttributes->save( $this->testUserId );

		$this->assertEquals(
			'test',
			$this->userAttributes->getAttribute( $this->testUserId, 'attribute_one' )
		);
		$this->assertEquals(
			'other',
			$this->userAttributes->getAttribute( $this->testUserId, 'attribute_two' )
		);
		$this->assertEquals(
			'unchanged',
			$this->userAttributes->getAttribute( $this->testUserId, 'attribute_three' )
		);

		$this->assertEquals( 1, $this->getMockServer()->countExecutions( $patchRequest ) );
	}
}
