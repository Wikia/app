<?php
namespace Extensions\Wikia\ArticleComments\Hooks;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Action;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\Check\Check;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\Check\CheckFactory;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;

class UserCanTest extends \WikiaBaseTest {
	/** @var CheckFactory|\PHPUnit_Framework_MockObject_MockObject $checkFactoryMock */
	private $checkFactoryMock;

	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactoryMock */
	private $dependencyFactoryMock;

	/** @var UserCan $userCan */
	private $userCan;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../src/autoload.php';

		$this->dependencyFactoryMock = $this->createMock( DependencyFactory::class );
		$this->checkFactoryMock = $this->getMockBuilder( CheckFactory::class )
			->setConstructorArgs( [ $this->dependencyFactoryMock ] )
			->getMock();

		$this->dependencyFactoryMock->expects( $this->once() )
			->method( 'getCommentsNamespaces' )
			->willReturn( [ NS_TALK ] );

		$this->userCan = new UserCan( $this->dependencyFactoryMock );
	}

	/**
	 * MAIN-10378: Test that the hook handler does not modify result and outcome
	 * for non comment namespaces.
	 *
	 * @dataProvider provideDataWithNonCommentNamespaces
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param null $result
	 */
	public function testReturnsTrueAndDoesNotTouchResultForNonCommentNamespacesAndTalkPages(
		\Title $title, \User $user, string $action, $result
	) {
		$this->dependencyFactoryMock->expects( $this->never() )
			->method( 'newCheckFactory' );

		$outcome = $this->userCan->process( $title, $user, $action, $result );

		$this->assertTrue( $outcome );
		$this->assertNull( $result );
	}

	public function provideDataWithNonCommentNamespaces() {
		$title = new \Title();
		$user = new \User();
		$action = 'edit';
		$result = null;

		foreach ( \MWNamespace::getValidNamespaces() as $nsIndex ) {
			$title->mNamespace = $nsIndex;
			yield [ $title, $user, $action, $result ];
		}

		$title->mNamespace = NS_TALK;
		foreach ( [ 'Talk:Foobar', 'Talk:Bar', 'Talk:Warszawa' ] as $text ) {
			$title->mTextform = $text;
			yield [ $title, $user, $action, $result ];
		}
	}

	/**
	 * MAIN-10378: Test that the hook handler creates and executes a check for supported actions
	 * for comment namespaces.
	 *
	 * @dataProvider provideDataWithActions
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param null $result
	 */
	public function testCreatesCheckAndSetsAndReturnsCheckResultForComments(
		\Title $title, \User $user, string $action, $result
	) {
		$expectedCheckResult = true;
		$checkMock = $this->getMockForAbstractClass( Check::class, [], '', false );

		$checkMock->expects( $this->once() )
			->method( 'process' )
			->with( $title, $user )
			->willReturn( $expectedCheckResult );

		$this->dependencyFactoryMock->expects( $this->once() )
			->method( 'newCheckFactory' )
			->willReturn( $this->checkFactoryMock );

		$this->checkFactoryMock->expects( $this->once() )
			->method( 'newActionCheck' )
			->with( $action )
			->willReturn( $checkMock );


		$outcome = $this->userCan->process( $title, $user, $action, $result );

		$this->assertEquals( $expectedCheckResult, $outcome );
		$this->assertEquals( $expectedCheckResult, $result );
	}

	public function provideDataWithActions() {
		$title = new \Title();
		$title->mNamespace = NS_TALK;
		$title->mTextform = 'Talk:FooBar/@comment-2013045';
		$user = new \User();
		$result = null;

		$actions = [
			Action::EDIT, Action::MOVE, Action::MOVE_TARGET,
			Action::CREATE, Action::DELETE, Action::UNDELETE
		];

		foreach ( $actions as $action ) {
			yield [ $title, $user, $action, $result ];
		}
	}

	/**
	 * @dataProvider provideDataWithUnsupportedActions
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param $result
	 */
	public function testReturnsTrueAndDoesNotModifyResultForUnsupportedActionsInCommentNamespaces(
		\Title $title, \User $user, string $action, $result
	) {
		$this->dependencyFactoryMock->expects( $this->once() )
			->method( 'newCheckFactory' )
			->willReturn( $this->checkFactoryMock );

		$this->checkFactoryMock->expects( $this->once() )
			->method( 'newActionCheck' )
			->with( $action )
			->willReturn( null );


		$outcome = $this->userCan->process( $title, $user, $action, $result );

		$this->assertTrue( $outcome );
		$this->assertNull( $result );
	}

	public function provideDataWithUnsupportedActions() {
		$title = new \Title();
		$title->mNamespace = NS_TALK;
		$title->mTextform = 'Talk:Foo/@comment-201305';
		$user = new \User();
		$result = null;

		$actions = [ 'karamba', 'alamakota', 'chryzantemy złociste' ];
		foreach ( $actions as $action ) {
			yield [ $title, $user, $action, $result ];
		}
	}
}
