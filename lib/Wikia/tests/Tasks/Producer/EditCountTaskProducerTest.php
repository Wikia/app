<?php

namespace Wikia\Tasks\Producer;

use PHPUnit\Framework\TestCase;
use Wikia\Rabbit\TaskPublisher;

class EditCountTaskProducerTest extends TestCase {

	/** @var EditCountTaskProducer $editCountTaskProducer */
	private $editCountTaskProducer;

	protected function setUp() {
		parent::setUp();

		$this->editCountTaskProducer = new EditCountTaskProducer(
			$this->getMockForAbstractClass( TaskPublisher::class )
		);
	}

	public function testShouldCreateOneTaskForMultipleEditsBySingleUser() {
		$user = $this->createConfiguredMock( \User::class, [
			'getId' => 1
		] );

		$this->editCountTaskProducer->incrementFor( $user );
		$this->editCountTaskProducer->incrementFor( $user );

		$tasks = $this->editCountTaskProducer->getTasks();

		$this->assertCount( 1, $tasks, 'Only one task should have been created' );
	}

	public function testShouldCreateOneTaskForMultipleEditsByDifferentUsers() {
		$firstUser = $this->createConfiguredMock( \User::class, [
			'getId' => 1
		] );
		$secondUser = $this->createConfiguredMock( \User::class, [
			'getId' => 1
		] );

		$this->editCountTaskProducer->incrementFor( $firstUser );
		$this->editCountTaskProducer->incrementFor( $secondUser );

		$tasks = $this->editCountTaskProducer->getTasks();

		$this->assertCount( 1, $tasks, 'Only one task should have been created' );
	}


	public function testShouldCreateNoTaskWhenThereWereNoEdits() {
		$tasks = $this->editCountTaskProducer->getTasks();

		$this->assertEmpty( $tasks, 'No tasks should have been created' );
	}
}
