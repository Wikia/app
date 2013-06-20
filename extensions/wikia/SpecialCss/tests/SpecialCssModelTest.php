<?php
class SpecialCssModelTest extends WikiaBaseTest {
	const FULL_URL_EXAMPLE = 'http://www.wikia.com/wiki/Special:CSS';
	const LOCAL_URL_EXAMPLE = '/wiki/Special:CSS';
	
	protected function setUp () {
		require_once( dirname(__FILE__) . '/../SpecialCssModel.class.php');
	}

	/**
	 * @dataProvider testGetSpecialCssDataProvider
	 */
	public function testGetSpecialCssUrl($fullUrl, $expected) {
		$titleMock = $this->getMock('Title', array('getLocalURL', 'getFullUrl'));
		$titleMock->expects($this->any())
			->method('getLocalURL')
			->will($this->returnValue(self::LOCAL_URL_EXAMPLE));
		$titleMock->expects($this->any())
			->method('getFullUrl')
			->will($this->returnValue(self::FULL_URL_EXAMPLE));
		
		$specialCssModelMock = $this->getMock('SpecialCssModel', array('getSpecialCssTitle'));
		$specialCssModelMock->expects($this->once())
			->method('getSpecialCssTitle')
			->will($this->returnValue($titleMock));

		$result = $specialCssModelMock->getSpecialCssUrl($fullUrl);
		$this->assertEquals($expected, $result);
	}

	public function testGetSpecialCssDataProvider() {
		return [
			[true, self::FULL_URL_EXAMPLE],
			[false, self::LOCAL_URL_EXAMPLE]
		];
	}

	/**
	 * @dataProvider testGetCssFileContentDataProvider
	 */
	public function testGetCssFileContent($expected, $articleContent) {
		if (isset($articleContent)) {
			$fileArticle = $this->getMock('Article', array('getContent'), [new Title()]);
			$fileArticle->expects($this->any())
				->method('getContent')
				->will($this->returnValue($articleContent));
		} else {
			$fileArticle = null;
		}

		$specialCssModelMock = $this->getMock('SpecialCssModel', array('getCssFileArticle'));
		$specialCssModelMock->expects($this->any())
			->method('getCssFileArticle')
			->will($this->returnValue($fileArticle));

		$this->assertEquals($expected, $specialCssModelMock->getCssFileContent());
	}

	public function testGetCssFileContentDataProvider() {
		return [
			['', null],
			['test content', 'test content']
		];
	}

	/**
	 * @param String $title
	 * @param String $expected
	 * 
	 * @dataProvider testGetAfterLastSlashTextDataProvider
	 */
	public function testGetAfterLastSlashText($title, $expected) {
		$getAfterLastSlashTextMethod = new ReflectionMethod('SpecialCssModel', 'getAfterLastSlashText');
		$getAfterLastSlashTextMethod->setAccessible(true);
		
		$this->assertEquals( $expected, $getAfterLastSlashTextMethod->invoke( new SpecialCssModel(), $title ) );
	}
	
	public function testGetAfterLastSlashTextDataProvider() {
		return [
			[
				'title' => '',
				'expected' => '',
			],
			[
				'title' => 'Technical_Update:_November_20,_2012',
				'expected' => 'Technical_Update:_November_20,_2012',
			],
			[
				'title' => 'DaNASCAT/Technical_Update:_November_20,_2012',
				'expected' => 'Technical_Update:_November_20,_2012',
			],
			[
				'title' => 'DaNASCAT/Technical_Update:_November_20,_2012#Major_Bugs_Fixed',
				'expected' => 'Technical_Update:_November_20,_2012#Major_Bugs_Fixed',
			],
			[
				'title' => 'User_blog:DaNASCAT/Technical_Update:_November_21,_2012',
				'expected' => 'Technical_Update:_November_21,_2012',
			],
			[
				'title' => 'Rappy 4187/Technical_Update:_November_22,_2012',
				'expected' => 'Technical_Update:_November_22,_2012',
			],
			[
				'title' => 'Test page/Rappy 4187/Technical_Update:_November_22,_2012',
				'expected' => 'Technical_Update:_November_22,_2012',
			],
		];
	}

	public function testRemoveHeadline() {
		$getRemoveHeadlineMethod = new ReflectionMethod('SpecialCssModel', 'removeHeadline');
		$getRemoveHeadlineMethod->setAccessible(true);

		$text = '===Headline===\nLorem ipsum dolor sit amet, consectetur adipiscing elit. === Sed sodales ===, nisi eu 
				sagittis vulputate, erat lectus adipiscing dui, a rutrum nunc nisi non lorem. 
				===Nam ullamcorper ===nibh at justo === lacinia mattis===. ====Nulla====vulputate nulla at orci rhoncus, non eleifend ante porttitor.';
		
		$expected = '\nLorem ipsum dolor sit amet, consectetur adipiscing elit. , nisi eu 
				sagittis vulputate, erat lectus adipiscing dui, a rutrum nunc nisi non lorem. 
				nibh at justo . ==vulputate nulla at orci rhoncus, non eleifend ante porttitor.';
		
		$this->assertEquals( $expected, $getRemoveHeadlineMethod->invoke( new SpecialCssModel(), $text ) );
	}
	
	public function testAddAnchorToPostUrl() {
		$addAnchorToPostUrlMethod = new ReflectionMethod('SpecialCssModel', 'addAnchorToPostUrl');
		$addAnchorToPostUrlMethod->setAccessible(true);

		$text = '===Headline with more text===\nLorem ipsum dolor sit amet, consectetur adipiscing elit. === Sed sodales ===, nisi eu 
				sagittis vulputate, erat lectus adipiscing dui, a rutrum nunc nisi non lorem. 
				===Nam ullamcorper ===nibh at justo === lacinia mattis===. ====Nulla====vulputate nulla at orci rhoncus, non eleifend ante porttitor.';

		$expected = '#Headline_with_more_text';
		
		$this->assertEquals( $expected, $addAnchorToPostUrlMethod->invoke( new SpecialCssModel(), $text ) );
	}

	/**
	 * @param String $titleText
	 * @param String $fallbackUser
	 * @param String $expected
	 *
	 * @dataProvider testGetUserFromTitleTextDataProvider
	 */
	public function testGetUserFromTitleText($titleText, $fallbackUser, $expected) {
		$getUserFromTitleTextMethod = new ReflectionMethod('SpecialCssModel', 'getUserFromTitleText');
		$getUserFromTitleTextMethod->setAccessible(true);

		$this->assertEquals( $expected, $getUserFromTitleTextMethod->invoke( new SpecialCssModel(), $titleText, $fallbackUser ) );
	}
	
	public function testGetUserFromTitleTextDataProvider() {
		return [
			[
				'titleText' => '',
				'fallbackUser' => 'User',
				'expected' => 'User',
			],
			[
				'titleText' => 'Technical_Update:_November_20,_2012',
				'fallbackUser' => 'User',
				'expected' => 'User',
			],
			[
				'titleText' => 'DaNASCAT/Technical_Update:_November_20,_2012',
				'fallbackUser' => 'User',
				'expected' => 'DaNASCAT',
			],
			[
				'titleText' => 'DaNASCAT/Technical_Update:_November_20,_2012#Major_Bugs_Fixed',
				'fallbackUser' => 'User',
				'expected' => 'DaNASCAT',
			],
			[
				'titleText' => 'User_blog:DaNASCAT/Technical_Update:_November_21,_2012',
				'fallbackUser' => 'User',
				'expected' => 'DaNASCAT',
			],
			[
				'titleText' => 'Rappy 4187/Technical_Update:_November_22,_2012',
				'fallbackUser' => 'User',
				'expected' => 'Rappy 4187',
			],
			[
				'titleText' => 'Test page/Rappy 4187/Technical_Update:_November_22,_2012',
				'fallbackUser' => 'User',
				'expected' => 'Rappy 4187',
			],
		];
	}
}
