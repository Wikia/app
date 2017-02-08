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
		$parserMock = $this->getMock( Parser::class, [ 'parser', 'preSaveTransform' ] );
		$parserOptionsMock = $this->getMock( ParserOptions::class, [ 'setEditSection', 'optionsHash' ] );

		// ensure parser options do not allow "Section edit" links
		$parserOptionsMock->expects( $this->at( 0 ) )
			->method( 'setEditSection' )
			->with( false );


		$parserOptionsMock->expects( $this->at( 1 ) )
			->method( 'getUser' )
			->willReturn( $user );

		$parserMock->expects( $this->at( 0 ) )
			->method( 'preSaveTransform' )
			->with( $text, $title, $user, $text )
			->willReturnArgument( 3 );

		// ensure options hash is used for memc key
		$parserOptionsMock->expects( $this->at( 2 ) )
			->method( 'optionsHash' )
			->with( ParserOptions::legacyOptions() )
			->willReturn( 'foo' );

		$parserMock->expects( $this->at( 1 ) )
			->method( 'parse' )
			->with( $text, $title, $parserOptionsMock )
			->willReturnArgument( 0 );

		$this->mockClass( ParserOptions::class, $parserOptionsMock, 'newFromContext' );
		$this->mockStaticMethod( ParserPool::class, 'get', $parserMock );
		$this->mockStaticMethod( ParserPool::class, 'release', true );

		$articleComment = new ArticleComment( $title );
		$articleComment->setRawText( $text );
		$returnText = $articleComment->getTransformedParsedText();
	}
}
