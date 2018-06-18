<?php

class ArticleCommentTest extends WikiaBaseTest {
	/**
	 * SUS-1557: Verify ArticleComment::getTransformedParsedText goes through both pre-save processing and wikitext parse
	 * when text is not fetched from DB
	 *
	 * @see ArticleComment::getTransformedParsedText()
	 */
	public function testGetTransformedParsedText() {
		$title = Title::makeTitle( NS_TALK, 'Piła tango' );
		$user = new User;
		$text = 'Grzesiek Kubiak, czyli Kuba rządził naszą podstawówką; Po lekcjach na boisku ganiał za mną z cegłówką.';

		$parserMock = $this->getMock( Parser::class, [ 'parse', 'preSaveTransform' ] );
		$parserOptionsMock = $this->getMockBuilder( ParserOptions::class )
			->disableOriginalConstructor()
			->setMethods( [ 'getUser', 'setEditSection', 'optionsHash' ] )
			->getMock();
		$parserOutputMock = $this->getMock( ParserOutput::class, [ 'getText', 'getHeadItems' ] );

		// ensure parser options do not allow "Section edit" links
		$parserOptionsMock->expects( $this->at( 0 ) )
			->method( 'setEditSection' )
			->with( false );

		$parserOptionsMock->expects( $this->at( 1 ) )
			->method( 'getUser' )
			->willReturn( $user );

		$parserMock->expects( $this->at( 0 ) )
			->method( 'preSaveTransform' )
			->with( $text, $title, $user, $parserOptionsMock )
			->willReturnArgument( 0 );

		// ensure options hash is used for memc key
		$parserOptionsMock->expects( $this->at( 2 ) )
			->method( 'optionsHash' )
			->with( ParserOptions::legacyOptions() )
			->willReturn( (string)mt_rand( 0, 65535 ) );

		$parserMock->expects( $this->at( 1 ) )
			->method( 'parse' )
			->with( $text, $title, $parserOptionsMock )
			->willReturn( $parserOutputMock );

		$parserOutputMock->expects( $this->at( 0 ) )
			->method( 'getText' )
			->willReturn( $text );

		$parserOutputMock->expects( $this->at( 1 ) )
			->method( 'getHeadItems' )
			->willReturn( [] );

		$this->mockClass( ParserOptions::class, $parserOptionsMock, 'newFromContext' );
		$this->mockStaticMethod( ParserPool::class, 'get', $parserMock );
		$this->mockStaticMethod( ParserPool::class, 'release', true );

		$articleComment = new ArticleComment( $title );
		$articleComment->setRawText( $text );
		$returnText = $articleComment->getTransformedParsedText();
	}

	public function makeCommentTitleProvider() {
		yield [ 'Foo_bar', 1234, 'Macbre', 'Foo_bar/@comment-1234-20071201000000' ];
		yield [ 'Foo_bar', 0, '1.2.3.4', 'Foo_bar/@comment-1.2.3.4-20071201000000' ];
	}

	/**
	 * @dataProvider makeCommentTitleProvider
	 * @param string $titleText
	 * @param int $userId
	 * @param string $userName
	 * @param string $expected
	 */
	public function testMakeCommentTitle( string $titleText, int $userId, string $userName, string $expected) {
		$title = $this->mockClassWithMethods( Title::class, [
			'getText' => $titleText
		]);

		$user = $this->mockClassWithMethods( User::class, [
			'isLoggedIn' => $userId > 0,
			'getId' => $userId,
			'getName' => $userName,
		]);

		$this->assertEquals(
			$expected, ArticleCommentsTitle::format( $title, $user, '20071201000000' )
		);
	}
}
