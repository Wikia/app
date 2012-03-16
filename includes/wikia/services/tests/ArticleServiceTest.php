<?php

class ArticleServiceTest extends WikiaBaseTest {
	const TEST_CITY_ID = 79860;

	public function setUp() {
		parent::setUp();
	}

	protected function setUpMock($cacheParams = null) {
		// mock cache
		$memcParams = array(
			'set' => null,
			'get' => null,
		);
		if (is_array($cacheParams)) {
			$memcParams = $memcParams + $cacheParams;
		}
		$this->setUpMockObject('stdClass', $memcParams, false, 'wgMemc');
		$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);
		$this->mockApp();
	}

	protected function setUpMockObject($objectName, $objectParams = null, $needSetInstance = false, $globalVarName = null, $callOriginalConstructor = true, $globalFunc = array()) {
		$mockObject = $objectParams;
		if (is_array($objectParams)) {
			// extract params from methods
			$objectValues = array(); // $objectValues is stored in $objectParams[params]
			$methodParams = array();
			foreach ($objectParams as $key => $value) {
				if ($key == 'params' && !empty($value)) {
					$objectValues = array($value);
				} else {
					$methodParams[$key] = $value;
				}
			}
			$methods = array_keys($methodParams);

			// call original contructor or not
			if ($callOriginalConstructor) {
				$mockObject = $this->getMock($objectName, $methods, $objectValues);
			} else {
				$mockObject = $this->getMock($objectName, $methods, $objectValues, '', false);
			}

			foreach ($methodParams as $method => $value) {
				if ($value === null) {
					$mockObject->expects($this->any())
						->method($method);
				} else {
					if (is_array($value) && array_key_exists('mockExpTimes', $value) && array_key_exists('mockExpValues', $value)) {
						if ($value['mockExpValues'] == null) {
							$mockObject->expects($this->exactly($value['mockExpTimes']))
								->method($method);
						} else {
							$mockObject->expects($this->exactly($value['mockExpTimes']))
								->method($method)
								->will($this->returnValue($value['mockExpValues']));

						}
					} else {
						$mockObject->expects($this->any())
							->method($method)
							->will($this->returnValue($value));
					}
				}
			}
		}

		// mock global variable
		if (!empty($globalVarName)) {
			$this->mockGlobalVariable($globalVarName, $mockObject);
		}

		// mock global function
		if (!empty($globalFunc)) {
			$this->mockGlobalFunction($globalFunc['name'], $mockObject, $globalFunc['time']);
		}

		// set instance
		if ($needSetInstance) {
			$this->mockClass($objectName, $mockObject);
		}
	}


	/**
	 * @dataProvider getTextSnippetDataProvider
	 * @param $snippetLength maximum length of text snippet to be pulled
	 * @param $rawArticleText raw text of article to be snippeted
	 * @param $expSnippetText expected output text snippet
	 */
	public function testGetTextSnippetTest($snippetLength, $articleText, $expSnippetText) {
		$this->setUpMockObject('Title', array('newFromText' => null), true);
		$this->setUpMockObject('Article', array(
			'getContent' => $articleText,
			'getTitle' => F::build('Title')
		), true, null, false);
		$this->setUpMock();

		// test
		$articleService = F::build('ArticleService');
		$articleMock = F::build('Article');
		$snippetText = $articleService->getTextSnippet($snippetLength);

		$this->assertEquals($expSnippetText, $snippetText);

	}

	public function getTextSnippetDataProvider() {
		/**
		 * @todo: add more test sets
		 */
		return array(
			array( // article is empty
				100,
				'',
				''
			),
			array( // article is plain text
				100,
				'This is the test line',
				'This is the test line',
			),
			array( // article is very long
				100,
				'This is the test line that is very long and should be cut off at some point to avoid generating too long snippets',
				'This is the test line that is very long and should be cut off at some point to avoid generating...',
			),
		);
	}


}