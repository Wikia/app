<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Action;

class BlogArticleCheckFactoryTest extends \WikiaBaseTest {
	/** @var BlogArticleCheckFactory $blogArticleCheckFactory */
	private $blogArticleCheckFactory;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->blogArticleCheckFactory = new BlogArticleCheckFactory( new DependencyFactory() );
	}

	/**
	 * @dataProvider provideActionsAndExpectedCheckClasses
	 * @param string $action
	 * @param string $expectedCheckClass
	 */
	public function testNewActionCheckReturnsCorrectCheckForSupportedActions(
		string $action, string $expectedCheckClass
	) {
		$check = $this->blogArticleCheckFactory->newActionCheck( $action );

		$this->assertInstanceOf( $expectedCheckClass, $check );
	}

	public function provideActionsAndExpectedCheckClasses(): array {
		return [
			[ Action::CREATE, BlogArticleCreateActionCheck::class ],
			[ Action::EDIT, BlogArticleEditActionCheck::class ],
			[ Action::MOVE, BlogArticleMoveActionCheck::class ],
			[ Action::MOVE_TARGET, BlogArticleMoveActionCheck::class ],
			[ Action::PROTECT, BlogArticleProtectActionCheck::class ],
		];
	}

	/**
	 * @dataProvider provideUnsupportedActions
	 * @param string $action
	 */
	public function testNewActionCheckReturnsNullForUnsupportedActions( string $action ) {
		$check = $this->blogArticleCheckFactory->newActionCheck( $action );

		$this->assertNull( $check );
	}

	public function provideUnsupportedActions(): array {
		return [
			[ 'karamba' ],
			[ 'alamakota' ],
			[ 'chryzantemy złociste' ],
		];
	}
}
