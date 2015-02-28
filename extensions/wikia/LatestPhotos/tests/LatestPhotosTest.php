<?php
class LatestPhotosTest extends WikiaBaseTest {

	private $testDate = '1410-02-31';
	const FILENAME = 'LatestPhotosTest.jpg';
	const PREFIX = 'QAImage';

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LatestPhotos.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getTemplateDataDataProvider
	 * @param Array $element
	 * @param Array $expectedResult
	 */
	public function testGetTemplateData($element, $expectedResult) {
		$latestPhotosHelper = new LatestPhotosHelper();
		$mockTimestamp = $this->getGlobalFunctionMock( 'wfTimestamp' );
		$mockTimestamp->expects( $this->any() )
			->method( 'wfTimestamp' )
			->will( $this->returnValue( $this->testDate ) );

		$this->assertEquals($latestPhotosHelper->getTemplateData($element), $expectedResult);
	}

	public function getTemplateDataDataProvider() {
		$fileName = $this->getFileName();
		$file = $this->createFile($fileName);
		return [
			[['foo' => 'bar'], []],
			[['file' => $file], ['image_key' => $fileName, 'date' => $this->testDate]]
		];
	}

	/**
	 * @dataProvider testGetImageDataCorrectElementDataProvider
	 * @param Array $element
	 * @param String $firstKey
	 * @param String $secondKey
	 */
	public function testGetImageDataCorrectElement($element, $firstKey, $secondKey) {
		$latestPhotoHelperMock = $this->getMock('LatestPhotosHelper', ['getTitleFromText']);
		$latestPhotoHelperMock
			->expects($this->any())
			->method('getTitleFromText')
			->willReturn($this->getTitleFromText($this->getFileName()));

		$result = $latestPhotoHelperMock->getImageData($element);
		$this->assertArrayHasKey($firstKey, $result);
		$this->assertArrayHasKey($secondKey, $result);
	}

	public function testGetImageDataCorrectElementDataProvider() {
		return [
			[['title' => 'foo'], 'url', 'file']
		];
	}

	/**
	 * @dataProvider testGetImageDataWrongElementDataProvider
	 * @param Array $element
	 * @param Array $result
	 */
	public function testGetImageDataWrongElement($element, $result) {
		$latestPhotoHelper = new LatestPhotosHelper();
		$this->assertEquals($latestPhotoHelper->getImageData($element), $result);
	}

	public function testGetImageDataWrongElementDataProvider() {
		return [
			[['foo' => 'bar'], []]
		];
	}

	private function createFile($fileName) {
		$file = new WikiaLocalFile(
			$this->getTitleFromText($fileName), RepoGroup::singleton()->getLocalRepo()
		);
		return $file;
	}

	private function getFileName() {
		return self::PREFIX . str_replace( '$1', time(), self::FILENAME );
	}

	private function getTitleFromText($text) {
		return Title::newFromText($text, NS_FILE);
	}
}
