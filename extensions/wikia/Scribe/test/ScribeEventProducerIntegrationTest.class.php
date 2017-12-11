<?php


class ScribeEventProducerIntegrationTest extends WikiaBaseTest {

	const TEST_PAGE_ID = '1';
	const TEST_REVISION_ID = '2';
	const TEST_TIMESTAMP = '2017-01-02 10:11:12.345';
	const TEST_TITLE_TEXT = 'Test title';
	const TEST_NAMESPACE = 1;
	const TEST_TITLE_DB_KEY = 'Test DB Key';

	public function test() {
		//given
		$sut = new ScribeEventProducer('edit' );

		$titleMethods = [
			'getLatestRevID' => static::TEST_TITLE_TEXT,
			'getText' => static::TEST_TITLE_TEXT,
			'getNamespace' => static::TEST_NAMESPACE,
			'getDBkey' => static::TEST_TITLE_DB_KEY,
			'getId' => 0,
			'isContentPage' => false,
			'isRedirect' => false,
		];

		$title = $this->getMockBuilder(Title::class )->setMethods( array_keys( $titleMethods ) )->getMock();
		$this->setMockMethods( $title, $titleMethods);

		$pageMethods = [
			'getTitle' => $title,
			'getId' => static::TEST_PAGE_ID,
			'getTimestamp' => static::TEST_TIMESTAMP,
		];

		$page = $this->getMockBuilder(Page::class )->setMethods( array_keys( $pageMethods ) )->getMock();
		$this->setMockMethods( $page, $pageMethods );

		$userMethods = [
			'getId' => 0,
			'isAllowed' => false,
			'getTimestamp' => static::TEST_TIMESTAMP,
		];

		$user = $this->getMockBuilder(User::class )->setMethods( array_keys( $userMethods ) )->getMock();
		$this->setMockMethods( $user, $userMethods );

		//when
		$sut->buildEditPackage( $page, $user );
		$sut->sendLog();

		//then

		//todo mock ConnectionBase and assert what is sent

	}

	private function setMockMethods( $mock, $methodValuePairs ) {
		foreach ( $methodValuePairs as $method => $value ) {
			$mock->expects( $this->any() )->method( $method )->willReturn( $value );
		}
	}
}
