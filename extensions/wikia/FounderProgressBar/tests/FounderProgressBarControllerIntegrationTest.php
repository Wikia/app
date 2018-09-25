<?php

/**
 * @group Integration
 */
class FounderProgressBarControllerIntegrationTest extends WikiaDatabaseTest {

	use MockGlobalVariableTrait;

	/** @var FounderProgressBarModel $model */
	private $model;

	protected function setUp() {
		parent::setUp();

		$this->model = new FounderProgressBarModel();
	}

	/**
	 * @dataProvider provideBonusTaskIds
	 * @param int $taskId
	 */
	public function testShouldNotAllowToSkipBonusTask( int $taskId ) {
		$this->mockGlobalVariable( 'wgCityId', 1 );

		$data = $this->sendRequest( [ 'task_id' => $taskId, 'task_skipped' => 1 ] );
		$tasks = $this->model->getTasksStatus();

		$this->assertEquals( 'error', $data['result'] );
		$this->assertArrayNotHasKey( 'bonus_tasks_unlocked', $data );

		$this->assertFalse( $tasks[$taskId]->wasSkipped(), 'Bonus task should not have been skipped' );
	}

	public function provideBonusTaskIds() {
		require_once __DIR__ . '/../FounderProgressBar.setup.php';

		foreach ( FounderTask::BONUS as $taskId ) {
			yield [ $taskId ];
		}
	}

	public function testShouldUnlockBonusTasksAfterSkipIfAllTasksAreCompleteOrSkipped() {
		$this->mockGlobalVariable( 'wgCityId', 2 );

		$id = FounderTask::TASKS['FT_MAINPAGE_EDIT'];
		$data = $this->sendRequest( [ 'task_id' => $id, 'task_skipped' => 1 ] );
		$tasks = $this->model->getTasksStatus();

		$this->assertEquals( 'OK', $data['result'] );
		$this->assertTrue( $data['bonus_tasks_unlocked'], 'Bonus tasks should have been unlocked' );

		$this->assertTrue( $tasks[$id]->wasSkipped(), 'Task should have been skipped' );

		foreach ( FounderTask::BONUS as $taskId ) {
			$this->assertArrayHasKey( $taskId, $tasks, 'Bonus tasks should have been unlocked' );
		}
	}

	public function testShouldNotUnlockBonusTasksAfterSkipIfThereAreTasksNotSkippedOrCompleted() {
		$this->mockGlobalVariable( 'wgCityId', 3 );

		$id = FounderTask::TASKS['FT_THEMEDESIGNER_VISIT'];
		$data = $this->sendRequest( [ 'task_id' => $id, 'task_skipped' => 1 ] );
		$tasks = $this->model->getTasksStatus();

		$this->assertEquals( 'OK', $data['result'] );
		$this->assertFalse( $data['bonus_tasks_unlocked'], 'Bonus tasks should not have been unlocked' );

		$this->assertTrue( $tasks[$id]->wasSkipped(), 'Task should have been skipped' );

		foreach ( FounderTask::BONUS as $taskId ) {
			$this->assertArrayNotHasKey( $taskId, $tasks, 'Bonus tasks should not have been unlocked' );
		}
	}

	private function sendRequest( array $params ): array {
		return F::app()->sendExternalRequest( FounderProgressBarController::class, 'skipTask', $params )->getData();
	}

	protected function tearDown() {
		parent::tearDown();

		$this->unsetGlobals();
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/controller.yaml' );
	}
}
