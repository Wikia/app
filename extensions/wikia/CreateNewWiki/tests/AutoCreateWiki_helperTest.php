<?

class AutoCreateWikiTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';

		parent::setUp();

		$userMock = $this->getMock('stdClass', array('getGroups'));
		$userMock->expects($this->any())
			->method('getGroups')
			->will($this->returnValue(array()));

		$this->mockGlobalVariable('wgUser', $userMock);
	}

	/**
	 * @dataProvider getDomainCheckData
	 */
	public function testCheckDomainIsCorrect($domainName, $lang, $isCorrect, $expectedErrorKey) {

		if (!$isCorrect) {
			$this->getGlobalFunctionMock( 'wfMsg' )
				->expects( $this->exactly( 1 ) )
				->method( 'wfMsg' )
				->with( $this->equalTo( $expectedErrorKey ) )
				->will( $this->returnValue( 'mocked-string' ) );
		}

		$autoCreateWikiMock = $this->getMock('AutoCreateWiki', array('checkBadWords', 'checkDomainExists', 'getLanguageNames'));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('checkBadWords')
			->will($this->returnValue(true));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('checkDomainExists')
			->will($this->returnValue(false));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('getLanguageNames')
			->will($this->returnValue(
				array(
					'pl' => 'pl',
					'en' => 'en',
					'def' => 'def',
					'zzz' => 'zzz',
				)
			)
		);

		$result = $autoCreateWikiMock::checkDomainIsCorrect($domainName, $lang);

		if ($isCorrect) {
			$this->assertEquals('', $result);
		} else {
			$this->assertEquals('mocked-string', $result);
		}
	}

	function getDomainCheckData() {
		return array(
			array('asd', 'pl', true, null),
			array('asd', 'pl', true, null),
			array('as-d', 'en', true, null),
			array('asd', 'en', true, null),
			array('asd', 'pl', true, null),
			array('asd-', 'pl', false, 'autocreatewiki-bad-name'),
			array('asd-', 'pl', false, 'autocreatewiki-bad-name'),
			array('as)d', 'pl', false, 'autocreatewiki-bad-name'),
			array('as<d', 'pl', false, 'autocreatewiki-bad-name'),
			array('as$d', 'pl', false, 'autocreatewiki-bad-name'),
			array('as@d', 'pl', false, 'autocreatewiki-bad-name'),
			array('', 'pl', false, 'autocreatewiki-empty-field'),
			array('a', 'pl', false, 'autocreatewiki-name-too-short'),
			array('012345678901234567890123456789012345678901234567890', 'pl', false, 'autocreatewiki-name-too-long'),
			array('def', 'pl', false, 'autocreatewiki-violate-policy'),
			array('zzz', 'en', false, 'autocreatewiki-violate-policy'),
		);
	}

	function testCheckDomainIsCorrectBadWords() {
		$this->getGlobalFunctionMock( 'wfMsg' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMsg' )
			->with( $this->equalTo( 'autocreatewiki-violate-policy' ) )
			->will( $this->returnValue( 'mocked-string' ) );

		$autoCreateWikiMock = $this->getMock('AutoCreateWiki', array('checkBadWords', 'getLanguageNames'));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('checkBadWords')
			->will($this->returnValue(false));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('getLanguageNames')
			->will($this->returnValue(
				array(
					'pl' => 'pl',
				)
			)
		);

		$result = $autoCreateWikiMock::checkDomainIsCorrect('woohooo', 'pl');

		$this->assertEquals('mocked-string', $result);
	}

	function testCheckDomainIsCorrectDomainExists() {
		$this->getGlobalFunctionMock( 'wfMsg' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMsg' )
			->with( $this->equalTo( 'autocreatewiki-name-taken' ) )
			->will( $this->returnValue( 'mocked-string' ) );

		$autoCreateWikiMock = $this->getMock('AutoCreateWiki', array('checkBadWords', 'getLanguageNames', 'checkDomainExists'));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('checkBadWords')
			->will($this->returnValue(true));
		$autoCreateWikiMock->staticExpects($this->any())
			->method('getLanguageNames')
			->will($this->returnValue(
				array(
					'pl' => 'pl',
				)
			)
		);
		$autoCreateWikiMock->staticExpects($this->any())
			->method('checkDomainExists')
			->will($this->returnValue(true));

		$result = $autoCreateWikiMock::checkDomainIsCorrect('woohooo', 'pl');

		$this->assertEquals('mocked-string', $result);
	}

}