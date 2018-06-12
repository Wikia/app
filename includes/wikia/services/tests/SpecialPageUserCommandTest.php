<?php

use PHPUnit\Framework\TestCase;

class SpecialPageUserCommandTest extends TestCase {

	/** @var RequestContext $requestContext */
	private $requestContext;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
	}

	/**
	 * @dataProvider providePages
	 *
	 * @param string $page
	 * @throws MWException
	 */
	public function testSpecialPrefixIndex( string $page ) {
		$this->requestContext->setTitle( Title::newFromText( $page ) );

		$specialPageUserCommand = new SpecialPageUserCommand( 'SpecialPage:PrefixIndex' );
		$specialPageUserCommand->setContext( $this->requestContext );

		$data = $specialPageUserCommand->getRenderData();

		$this->assertStringEndsWith("Special:PrefixIndex/$page", $data['href'] );
	}

	/**
	 * @dataProvider providePages
	 *
	 * @param string $page
	 * @throws MWException
	 */
	public function testSpecialRecentChangesLinked( string $page ) {
		$this->requestContext->setTitle( Title::newFromText( $page ) );

		$specialPageUserCommand = new SpecialPageUserCommand( 'SpecialPage:RecentChangesLinked' );
		$specialPageUserCommand->setContext( $this->requestContext );

		$data = $specialPageUserCommand->getRenderData();

		$this->assertStringEndsWith("Special:RecentChangesLinked/$page", $data['href'] );
	}

	public function providePages() {
		yield [ 'Thread:1234' ];
		yield [ 'User:Test' ];
		yield [ 'Anakin_Skywalker' ];
		yield [ 'Gzik' ];
	}

	/**
	 * @dataProvider provideUsers
	 * @param string $userName
	 */
	public function testSpecialContributions( string $userName ) {
		$user = User::newFromName( $userName );
		$this->requestContext->setUser( $user );

		$specialPageUserCommand = new SpecialPageUserCommand( 'SpecialPage:Contributions' );
		$specialPageUserCommand->setContext( $this->requestContext );

		$data = $specialPageUserCommand->getRenderData();

		$this->assertStringEndsWith( "Special:Contributions/$userName", $data['href'] );
	}

	public function provideUsers() {
		yield [ 'Test_user' ];
		yield [ 'Foo' ];
	}

	public function testNonContextAwareSpecialPageHref() {
		$specialPageUserCommand = new SpecialPageUserCommand( 'SpecialPage:RecentChanges' );
		$specialPageUserCommand->setContext( $this->requestContext );

		$data = $specialPageUserCommand->getRenderData();

		$this->assertStringEndsWith( 'Special:RecentChanges', $data['href'] );
	}
}
