<?php
namespace Extensions\Wikia\Blogs\Hooks;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Action;
use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogArticleCheckFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogCommentCheckFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Check\Check;

class UserCanTest extends \WikiaBaseTest {
	/** @var BlogArticleCheckFactory|\PHPUnit_Framework_MockObject_MockObject $blogArticleCheckFactoryMock */
	private $blogArticleCheckFactoryMock;

	/** @var BlogCommentCheckFactory|\PHPUnit_Framework_MockObject_MockObject $blogCommentCheckFactoryMock */
	private $blogCommentCheckFactoryMock;

	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactoryMock */
	private $dependencyFactoryMock;

	/** @var UserCan $userCan */
	private $userCan;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../src/autoload.php';

		$this->blogArticleCheckFactoryMock = $this->createMock( BlogArticleCheckFactory::class );
		$this->blogCommentCheckFactoryMock = $this->createMock( BlogCommentCheckFactory::class );

		$this->dependencyFactoryMock = $this->createMock( DependencyFactory::class );
		$this->userCan = new UserCan( $this->dependencyFactoryMock );
	}

	/**
	 * @dataProvider provideSupportedActionsOnBlogArticles
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param $result
	 */
	public function testCreatesCheckAndSetsAndReturnsCheckResultForSupportedActionsOnBlogs(
		\Title $title, \User $user, string $action, $result
	) {
		$expectedCheckResult = true;
		$checkMock = $this->getMockForAbstractClass( Check::class, [], '', false );

		$checkMock->expects( $this->once() )
			->method( 'process' )
			->with( $title, $user )
			->willReturn( $expectedCheckResult );

		if ( $title->inNamespace( NS_BLOG_ARTICLE ) ) {
			$checkFactoryMock = $this->blogArticleCheckFactoryMock;
			$this->dependencyFactoryMock->expects( $this->once() )
				->method( 'newBlogArticleCheckFactory' )
				->willReturn( $checkFactoryMock );
		} else {
			$checkFactoryMock = $this->blogCommentCheckFactoryMock;
			$this->dependencyFactoryMock->expects( $this->once() )
				->method( 'newBlogCommentCheckFactory' )
				->willReturn( $checkFactoryMock );
		}

		$checkFactoryMock->expects( $this->once() )
			->method( 'newActionCheck' )
			->with( $action )
			->willReturn( $checkMock );

		$outcome = $this->userCan->process( $title, $user, $action, $result );

		$this->assertEquals( $expectedCheckResult, $outcome );
		$this->assertEquals( $expectedCheckResult, $result );
	}

	public function provideSupportedActionsOnBlogArticles() {
		$title = new \Title();
		$user = new \User();
		$result = null;

		$actions = [
			Action::CREATE, Action::EDIT, Action::PROTECT,
		    Action::MOVE, Action::MOVE_TARGET
		];

		foreach ( [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ] as $ns ) {
			$title->mNamespace = $ns;
			foreach ( $actions as $action ) {
				yield [ $title, $user, $action, $result ];
			}
		}
	}

	/**
	 * @dataProvider provideUnsupportedActionsOnBlogArticles
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param $result
	 */
	public function testReturnsTrueAndDoesNotModifyResultsForUnsupportedActionsOnBlogPages(
		\Title $title, \User $user, string $action, $result
	) {
		if ( $title->inNamespace( NS_BLOG_ARTICLE ) ) {
			$checkFactoryMock = $this->blogArticleCheckFactoryMock;
			$this->dependencyFactoryMock->expects( $this->once() )
				->method( 'newBlogArticleCheckFactory' )
				->willReturn( $checkFactoryMock );
		} else {
			$checkFactoryMock = $this->blogCommentCheckFactoryMock;
			$this->dependencyFactoryMock->expects( $this->once() )
				->method( 'newBlogCommentCheckFactory' )
				->willReturn( $checkFactoryMock );
		}

		$checkFactoryMock->expects( $this->once() )
			->method( 'newActionCheck' )
			->with( $action )
			->willReturn( null );

		$outcome = $this->userCan->process( $title, $user, $action, $result );

		$this->assertTrue( $outcome );
		$this->assertNull( $result );
	}

	public function provideUnsupportedActionsOnBlogArticles() {
		$title = new \Title();
		$user = new \User();
		$result = null;

		$actions = [ 'karamba', 'alamakota', 'chryzantemy złociste' ];

		foreach ( [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ] as $ns ) {
			$title->mNamespace = $ns;
			foreach ( $actions as $action ) {
				yield [ $title, $user, $action, $result ];
			}
		}
	}

	/**
	 * @dataProvider provideNonBlogPages
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param $result
	 */
	public function testReturnsTrueAndDoesNotModifyResultForNonBlogPages(
		\Title $title, \User $user, string $action, $result
	) {
		$this->dependencyFactoryMock->expects( $this->never() )
			->method( 'newBlogArticleCheckFactory' );

		$this->dependencyFactoryMock->expects( $this->never() )
			->method( 'newBlogCommentCheckFactory' );

		$outcome = $this->userCan->process( $title, $user, $action, $result );

		$this->assertTrue( $outcome );
		$this->assertNull( $result );
	}

	public function provideNonBlogPages() {
		$title = new \Title();
		$user = new \User();
		$action = 'edit';
		$result = null;

		foreach ( [ NS_MAIN, NS_TALK ] as $ns ) {
			$title->mNamespace = $ns;
			yield [ $title, $user, $action, $result ];
		}
	}
}
