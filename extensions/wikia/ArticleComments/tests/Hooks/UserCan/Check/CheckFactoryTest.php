<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Action;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;

class CheckFactoryTest extends \WikiaBaseTest {
	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactoryMock */
	private $dependencyFactoryMock;

	/** @var CheckFactory $checkFactory */
	private $checkFactory;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->dependencyFactoryMock = $this->createMock( DependencyFactory::class );
		$this->checkFactory = new CheckFactory( $this->dependencyFactoryMock );
	}

	/**
	 * MAIN-10378: Test that the correct check class is produced for supported actions.
	 *
	 * @dataProvider provideActionsAndExpectedCheckClasses
	 * @param string $action
	 * @param string $expectedCheckClass
	 */
	public function testNewActionCheckReturnsCorrectCheckForSupportedActions(
		string $action, string $expectedCheckClass
	) {
		$check = $this->checkFactory->newActionCheck( $action );

		$this->assertInstanceOf( $expectedCheckClass, $check );
	}

	public function provideActionsAndExpectedCheckClasses(): array {
		return [
			[ Action::CREATE, CreateActionCheck::class ],
			[ Action::EDIT, EditActionCheck::class ],
			[ Action::DELETE, DeleteActionCheck::class ],
			[ Action::UNDELETE, DeleteActionCheck::class ],
			[ Action::MOVE, MoveActionCheck::class ],
			[ Action::MOVE_TARGET, MoveActionCheck::class ],
		];
	}

	/**
	 * MAIN-10378: Test that null is produced for unsupported actions.
	 *
	 * @dataProvider provideUnsupportedActions
	 * @param string $action
	 */
	public function testNewActionCheckReturnsNullForUnsupportedActions( string $action ) {
		$check = $this->checkFactory->newActionCheck( $action );

		$this->assertNull( $check );
	}

	public function provideUnsupportedActions(): array {
		return [
			[ 'karamba' ],
			[ 'alamakota' ],
			[ 'chryzantemy złociste' ]
		];
	}
}
