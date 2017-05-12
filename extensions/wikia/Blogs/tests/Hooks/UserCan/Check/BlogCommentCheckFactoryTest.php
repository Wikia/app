<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Action;

class BlogCommentCheckFactoryTest extends \WikiaBaseTest {
	/** @var BlogCommentCheckFactory $blogCommentCheckFactory */
	private $blogCommentCheckFactory;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->blogCommentCheckFactory = new BlogCommentCheckFactory( new DependencyFactory() );
	}

	/**
	 * @dataProvider provideActionsAndExpectedCheckClasses
	 * @param string $action
	 * @param string $expectedCheckClass
	 */
	public function testNewActionCheck( string $action, string $expectedCheckClass ) {
		$check = $this->blogCommentCheckFactory->newActionCheck( $action );

		$this->assertInstanceOf( $expectedCheckClass, $check );
	}

	public function provideActionsAndExpectedCheckClasses(): array {
		return [
			[ Action::CREATE, BlogCommentCreateActionCheck::class ]
		];
	}
}
