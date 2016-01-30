<?php

class ContentReviewModuleControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "{$IP}/skins/oasis/modules/ContentReviewModuleController.class.php";
		parent::setUp();
	}

	/**
	 * @param $latestRevisionId
	 * @param $pageStatus
	 * @param $expectedStatus
	 *
	 * @dataProvider latestRevisionStatusDataProvider
	 */
	public function testGetLatestRevisionStatus( $latestRevisionId, $pageStatus, $expectedStatus ) {
		$controllerMock = $this->getControllerMock( $expectedStatus );
		$latestRevisionStatus = $controllerMock->getLatestRevisionStatusTemplateData( $latestRevisionId, $pageStatus );

		$this->assertEquals(
			$expectedStatus,
			$latestRevisionStatus['statusKey']
		);
	}

	/**
	 * @param $pageStatus
	 * @param $expectedStatus
	 *
	 * @dataProvider lastRevisionStatusDataProvider
	 */
	public function testGetLastRevisionStatus( $pageStatus, $expectedStatus ) {
		$controllerMock = $this->getControllerMock( $expectedStatus );
		$lastRevisionStatus = $controllerMock->getLastRevisionStatus( $pageStatus );

		$this->assertEquals(
			$expectedStatus,
			$lastRevisionStatus['statusKey']
		);
	}

	/**
	 * @param $pageStatus
	 * @param $expectedStatus
	 *
	 * @dataProvider liveRevisionStatusDataProvider
	 */
	public function testGetLiveRevisionStatus( $pageStatus, $expectedStatus ) {
		$controllerMock = $this->getControllerMock( $expectedStatus );
		$liveRevisionStatus = $controllerMock->getLiveRevisionStatus( $pageStatus );

		$this->assertEquals(
			$expectedStatus,
			$liveRevisionStatus['statusKey']
		);
	}

	private function getControllerMock( $expectedStatus ) {
		$controllerMock = $this->getMockBuilder( 'ContentReviewModuleController' )
			->setMethods( [
				'createRevisionLink',
				'createRevisionTalkpageLink',
			] )
			->getMock();

		if ( $expectedStatus !== ContentReviewModuleController::STATUS_NONE ) {
			$controllerMock->expects( $this->once() )
				->method( 'createRevisionLink' );
		} else {
			$controllerMock->expects( $this->never() )
				->method( 'createRevisionLink' );
		}

		if ( $expectedStatus !== ContentReviewModuleController::STATUS_REJECTED ) {
			$controllerMock->expects( $this->never() )
				->method( 'createRevisionTalkpageLink' );
		} else {
			$controllerMock->expects( $this->once() )
				->method( 'createRevisionTalkpageLink' );
		}

		return $controllerMock;
	}

	public function latestRevisionStatusDataProvider() {
		return [
			[
				0,
				[],
				ContentReviewModuleController::STATUS_NONE
			],
			[
				1491141,
				[
					'liveId' => 1491141,
					'lastReviewedId' => 1491141,
					'lastReviewedStatus' => 3,
				],
				ContentReviewModuleController::STATUS_LIVE
			],
			[
				1491141,
				[
					'liveId' => 1491120,
					'latestId' => 1491141,
					'latestStatus' => 1,
					'lastReviewedId' => 1491130,
					'lastReviewedStatus' => 4,
				],
				ContentReviewModuleController::STATUS_AWAITING
			],
			[
				1491141,
				[
					'liveId' => 1491120,
					'latestId' => 1491141,
					'latestStatus' => 2,
					'lastReviewedId' => 1491130,
					'lastReviewedStatus' => 4,
				],
				ContentReviewModuleController::STATUS_AWAITING
			],
			[
				1491141,
				[
					'liveId' => 1491120,
					'lastReviewedId' => 1491141,
					'lastReviewedStatus' => 4,
				],
				ContentReviewModuleController::STATUS_REJECTED
			],

			[
				1491141,
				[
					'liveId' => 1491120,
					'lastReviewedId' => 1491131,
					'lastReviewedStatus' => 4,
				],
				ContentReviewModuleController::STATUS_UNSUBMITTED
			],
		];
	}

	public function lastRevisionStatusDataProvider() {
		return [
			[
				[],
				ContentReviewModuleController::STATUS_NONE
			],
			[
				[
					'lastReviewedId' => 1491131,
					'lastReviewedStatus' => 3,
				],
				ContentReviewModuleController::STATUS_APPROVED
			],
			[
				[
					'lastReviewedId' => 1491131,
					'lastReviewedStatus' => 4,
				],
				ContentReviewModuleController::STATUS_REJECTED
			],
		];
	}

	public function liveRevisionStatusDataProvider() {
		return [
			[
				[],
				ContentReviewModuleController::STATUS_NONE
			],
			[
				[
					'liveId' => 1491131,
				],
				ContentReviewModuleController::STATUS_LIVE
			],
		];
	}
}
