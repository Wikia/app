<?php

use PHPUnit\Framework\TestCase;
use Wikia\Tasks\Tasks\MaintenanceTask;
use Wikia\Util\AssertionException;

/**
 * @group MaintenanceTask
 */
class MaintenanceTaskTest extends TestCase {

	/**
	 * @param string $script
	 * @param bool $valid
	 * @dataProvider validatePathProvider
	 */
	function testValidatePath( string $script, bool $valid ) {
		if ( $valid ) {
			$this->assertTrue( MaintenanceTask::validatePath( $script ) );
		}
		else {
			$this->expectException( AssertionException::class );
			MaintenanceTask::validatePath( $script );
		}
	}

	function validatePathProvider() {
		// the path should be relative to app's root directory
		yield [ 'maintenance/maintenanceTaskScheduler.php', true ];
		yield [ '/home/kopytko/Wikia/git/app/maintenance/maintenanceTaskScheduler.php', false ];

		yield [ '/foo/bar/test.php', false ];
	}

}
