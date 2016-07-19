<?php

namespace DMCARequest\Test;

use DMCARequest\DMCARequestHelper;

class DMCARequestHelperTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../DMCARequest.setup.php';
		parent::setUp();
	}

	public function testSetNoticeData() {
		$helper = new DMCARequestHelper();

		$initialData = [
			'type' => 1,
			'email' => 'example@example.com',
		];

		$helper->setNoticeData( $initialData );

		$amendedData = [
			'email' => 'example+two@example.com',
			'name' => 'Reporter',
		];

		$helper->setNoticeData( $amendedData );

		$expectedResult = [
			'type' => 1,
			'email' => 'example+two@example.com',
			'name' => 'Reporter',
		];

		$this->assertEquals( $expectedResult, $helper->getNoticeData() );
	}

	public function testSaveNotice() {
		$noticeId = 4;
		$timestamp = wfTimestamp( TS_DB );

		$helper = new DMCARequestHelper();

		$noticeData = [
			'type' => 2,
			'fullname' => 'Example User',
			'email' => 'example@example.com',
			'address' => '123 Some Road',
			'telephone' => '123456789',
			'original_urls' => 'http://www.wikia.com',
			'infringing_urls' => 'http://www.wikia.com',
			'comments' => '',
			'signature' => 'Example User',
		];

		$expectedDBData = [
			'dmca_date' => $timestamp,
			'dmca_requestor_type' => 2,
			'dmca_fullname' => 'Example User',
			'dmca_email' => 'example@example.com',
			'dmca_address' => '123 Some Road',
			'dmca_telephone' => '123456789',
			'dmca_original_urls' => 'http://www.wikia.com',
			'dmca_infringing_urls' => 'http://www.wikia.com',
			'dmca_comments' => '',
			'dmca_signature' => 'Example User',
		];

		$dbMock = $this->getMock( '\DatabaseMysqli', [ 'insert', 'insertId' ] );

		$dbMock->expects( $this->once() )
			->method( 'insertId' )
			->will( $this->returnValue( $noticeId ) );

		$dbMock->expects( $this->once() )
			->method( 'insert' )
			->with( 'dmca_request', $expectedDBData, 'DMCARequest\DMCARequestHelper::saveNotice' )
			->will( $this->returnValue( true ) );

		$this->mockGlobalFunction( 'wfGetDB', $dbMock );
		$this->mockGlobalFunction( 'wfTimestamp', $timestamp );

		$helper->setNoticeData( $noticeData );

		$result = $helper->saveNotice();

		$newNoticeData = $helper->getNoticeData();

		$this->assertTrue( $result );
		$this->assertEquals( $newNoticeData['id'], $noticeId );
	}
}
