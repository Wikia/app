<?php

class PermissionsTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TemplateClassification.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider displayEntryPointTestData
	 * @param array $testData
	 * @param bool $expected
	 * @param string $message
	 */
	public function testShouldDisplayEntryPoint( $testData, $expected, $message ) {
		$userMock = $this->getMock( 'User', [ 'isLoggedIn' ] );
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( $testData['isLoggedIn'] );

		$titleMock = $this->getMock( 'Title', [ 'userCan' ] );
		$titleMock->mNamespace = $testData['titleNamespace'];

		if ( $testData['isLoggedIn'] ) {
			$invokeUserCan = $this->atLeastOnce();
		} else {
			$invokeUserCan = $this->never();
		}
		$titleMock->expects( $invokeUserCan )
			->method( 'userCan' )
			->willReturn( $testData['canEdit'] );

		$permissions = new Wikia\TemplateClassification\Permissions();
		$this->assertSame( $expected, $permissions->shouldDisplayEntryPoint( $userMock, $titleMock ), $message );
	}

	public function displayEntryPointTestData() {
		return [
			[
				[
					'isLoggedIn' => false,
					'titleNamespace' => NS_TEMPLATE,
					'canEdit' => true,
				],
				false,
				'Anons can edit a template page, but should not be able to edit a classification - user has to be logged in.',
			],
			[
				[
					'isLoggedIn' => true,
					'titleNamespace' => NS_MAIN,
					'canEdit' => true,
				],
				false,
				'Template classification should apply only to the Template namespace.',
			],
			[
				[
					'isLoggedIn' => true,
					'titleNamespace' => NS_TEMPLATE,
					'canEdit' => false,
				],
				false,
				'A logged in user cannot edit a Template - should not be allowed to edit TC as well.',
			],
			[
				[
					'isLoggedIn' => true,
					'titleNamespace' => NS_TEMPLATE,
					'canEdit' => true,
				],
				true,
				'A logged in user can edit a Template - let him do so!',
			],
		];
	}
}
