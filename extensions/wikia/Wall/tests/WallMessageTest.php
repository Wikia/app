<?php
class WallMessageTest extends WikiaBaseTest {

	/**
	 * Forum main board title can have a slightly different name that the ac title itself, the article comment parent
	 * title takes precedence over the ac itself
	 */
	public function testGetWallUsesWallMainTitle() {
		$acTitle = Title::newFromText( 'ArticleCommentTitle/@comment/xxx' );
		$wallTitle = Title::newFromText( 'MessageWallTitle' );  // this takes precedence
		$wmMock = $this->getMock( 'WallMessage', [ 'getArticleTitle' ], [ $acTitle ] );
		$wmMock->expects( $this->any() )
			->method( 'getArticleTitle' )
			->will( $this->returnValue( $wallTitle ) );
		$this->assertEquals( $wmMock->getWallOwner()->getName(), 'MessageWallTitle' );
	}

	/**
	 * if article comment/title is not in database yet, we should use the article comment title's text as a fallback
	 * to return wall owner name
	 */
	public function testGetWallOwnerACFallback() {
		$acTitle = Title::newFromText( 'ArticleCommentTitle/@comment/xxx' );
		$wallTitle = Title::newFromText( 'Empty' );  // it means we couldn't fetch the main wall/forum title from db
		$wmMock = $this->getMock( 'WallMessage', [ 'getArticleTitle' ], [ $acTitle ] );
		$wmMock->expects( $this->any() )
			->method( 'getArticleTitle' )
			->will( $this->returnValue( $wallTitle ) );
		$this->assertEquals( $wmMock->getWallOwner()->getName(), 'ArticleCommentTitle' );

	}

}
