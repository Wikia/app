<?php
namespace Wikia\Tasks;

use PHPUnit\Framework\TestCase;
use Wikia\Tasks\Queues\ParsoidPurgePriorityQueue;
use Wikia\Tasks\Queues\ParsoidPurgeQueue;
use Wikia\Tasks\Queues\PriorityQueue;
use Wikia\Tasks\Queues\PurgeQueue;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Queues\RefreshTemplateLinksQueue;
use Wikia\Tasks\Queues\SMWQueue;

class AsyncTaskListTest extends TestCase {
	/** @var AsyncTaskList $asyncTaskList */
	private $asyncTaskList;

	protected function setUp() {
		parent::setUp();

		$this->asyncTaskList = new AsyncTaskList();
	}

	/**
	 * @dataProvider provideQueue
	 *
	 * @param string $queueName
	 * @param string $expectedQueueClass
	 */
	public function testSetQueueName( string $queueName, string $expectedQueueClass ) {
		$this->asyncTaskList->setQueueName( $queueName );

		$this->assertAttributeInstanceOf( $expectedQueueClass, 'queue', $this->asyncTaskList );
	}

	public function provideQueue() {
		yield [ 'whatever', Queue::class ];
		yield [ SMWQueue::NAME, SMWQueue::class ];
		yield [ PurgeQueue::NAME, PurgeQueue::class ];
		yield [ PriorityQueue::NAME, PriorityQueue::class ];
		yield [ ParsoidPurgeQueue::NAME, ParsoidPurgeQueue::class ];
		yield [ ParsoidPurgePriorityQueue::NAME, ParsoidPurgePriorityQueue::class ];
		yield [ RefreshTemplateLinksQueue::NAME, RefreshTemplateLinksQueue::class ];
	}

	public function testPrioritize() {
		$this->asyncTaskList->prioritize();

		$this->assertAttributeInstanceOf( PriorityQueue::class, 'queue', $this->asyncTaskList );
	}
}
