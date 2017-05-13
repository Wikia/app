<?php

class BlogArticleTest extends WikiaBaseTest {
	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../BlogArticle.php';
	}

	/**
	 * @dataProvider provideBlogTitlesAndExpectedOwnerNames
	 * @param Title $blogTitle
	 * @param string $expectedOwnerName
	 */
	public function testGetBlogOwner( Title $blogTitle, string $expectedOwnerName ) {
		$blogArticle = new BlogArticle( $blogTitle );

		$actualOwnerName = $blogArticle->getBlogOwner();

		$this->assertEquals( $expectedOwnerName, $actualOwnerName );
	}

	public function provideBlogTitlesAndExpectedOwnerNames() {
		$map = [
			'User_blog:John_Doe/Lorem_ipsum_dolor_sit_amet' => 'John Doe',
		    'User_blog:Sobieski/blog' => 'Sobieski',
		];

		foreach ( $map as $blogTitleText => $expectedOwnerName ) {
			yield [ Title::newFromText( $blogTitleText ), $expectedOwnerName ];
		}
	}
}
