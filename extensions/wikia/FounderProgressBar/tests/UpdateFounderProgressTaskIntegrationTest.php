<?php

/**
 * @group Integration
 */
class UpdateFounderProgressTaskIntegrationTest extends WikiaDatabaseTest {

	use MockGlobalVariableTrait;

	/** @var FounderProgressBarModel $model */
	private $model;

	/** @var UpdateFounderProgressTask $task */
	private $task;

	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../FounderProgressBar.setup.php';

		$this->model = new FounderProgressBarModel();
		$this->task = new UpdateFounderProgressTask();
	}

	public function testShouldCompleteSingleTask() {
		$this->mockGlobalVariable( 'wgCityId', 1 );

		$this->task->wikiId( 1 );
		$this->task->pushTask( FounderTask::TASKS['FT_MAINPAGE_EDIT'] );
		$this->task->doUpdate();

		$tasks = $this->model->getTasksStatus();

		$this->assertFalse(
			$this->model->wasCompletionTaskFinished(),
			'Completion task should not be finished when there are other tasks to be done'
		);
		$this->assertEquals(
			1,
			$tasks[FounderTask::TASKS['FT_MAINPAGE_EDIT']]->getCompleted(),
			'Newly done task should be completed'
		);

		foreach ( FounderTask::BONUS as $bonus ) {
			$this->assertArrayNotHasKey( $bonus, $tasks, 'Bonus tasks should not be unlocked when there are unskipped tasks to be done' );
		}
	}

	public function testShouldFinishCompletionTaskWhenNoMoreTasksLeft() {
		$this->mockGlobalVariable( 'wgCityId', 1 );

		$this->task->wikiId( 1 );
		$this->task->pushTask( FounderTask::TASKS['FT_MAINPAGE_EDIT'] );
		$this->task->pushTask( FounderTask::TASKS['FT_PHOTO_ADD_10'] );
		$this->task->doUpdate();

		$this->assertTrue(
			$this->model->wasCompletionTaskFinished(),
			'Completion task should be finished when all tasks are done'
		);
	}

	public function testShouldFinishCompletionTasksWhenBonusTasksCompensate() {
		$this->mockGlobalVariable( 'wgCityId', 4 );

		$this->task->wikiId( 4 );
		$this->task->pushTask( FounderTask::TASKS['FT_BONUS_PHOTO_ADD_10'] );
		$this->task->doUpdate();

		$this->assertTrue(
			$this->model->wasCompletionTaskFinished(),
			'Completion task should be finished when bonus tasks compensate for incomplete tasks'
		);
	}

	public function testShouldFinishCompletionTaskWhenOnlyBonusTasksLeft() {
		$this->mockGlobalVariable( 'wgCityId', 2 );

		$this->task->wikiId( 2 );
		$this->task->pushTask( FounderTask::TASKS['FT_MAINPAGE_EDIT'] );
		$this->task->pushTask( FounderTask::TASKS['FT_PHOTO_ADD_10'] );
		$this->task->doUpdate();

		$this->assertTrue(
			$this->model->wasCompletionTaskFinished(),
			'Completion task should be finished when only bonus tasks are left'
		);
	}

	public function testShouldUnlockBonusTasksWhenAllTasksAreCompletedOrSkipped() {
		$this->mockGlobalVariable( 'wgCityId', 3 );

		$this->task->wikiId( 3 );
		$this->task->pushTask( FounderTask::TASKS['FT_THEMEDESIGNER_VISIT'] );
		$this->task->doUpdate();

		$tasks = $this->model->getTasksStatus();

		$this->assertFalse(
			$this->model->wasCompletionTaskFinished(),
			'Completion task should not be finished when some tasks are skipped'
		);

		foreach ( FounderTask::BONUS as $id ) {
			$this->assertTrue( $tasks[$id]->isBonus(), 'Bonus tasks should be unlocked' );
		}
	}

	protected function tearDown() {
		parent::tearDown();

		$this->unsetGlobals();
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/update_founder_progress.yaml' );
	}
}
