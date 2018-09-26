<?php
/**
 * Sends informative emails about activity on wikis to their owners. 
 *
 * Usage: SERVER_ID=177 php FounderEmailsMaintenance.php --event=daysPassed|viewsDigest|completeDigest
 *
 * daysPassed - emails to founders of wikis after a number of days of their inactivity
 * viewsDigest - basic information about views
 * completeDigest - complete information about views, edits, etc.
 */
require_once __DIR__ . '/../../../maintenance/Maintenance.php';

class FounderEmailsMaintenance extends Maintenance {

	private $events = [
		'daysPassed',
		'viewsDigest',
		'completeDigest'
	];

	public $noConcurrency = true;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'event', 'Specifies which type of events to process.', true, true, 'e' );
		$this->addOption( 'dry-run', 'Dry-run mode, make no changes' );
	}

	public function execute() {
		if ($this->hasOption('dry-run')) {
			$this->output( "Dry-run mode, no emails will be sent, sleep for 15 seconds!\n" );

			sleep(15);
		} else {
			$event = $this->getOption( 'event' );
			if ( in_array( $event, $this->events ) ) {
				$this->output( "Sending Founder Emails ($event)" . PHP_EOL );
				FounderEmails::getInstance()->processEvents( $event, false );
			} else {
				$this->error(
					sprintf( "Unsupported event type: %s. Supported event types: %s." . PHP_EOL,
						$event, implode( ', ', $this->events )
					)
				);
			}
		}

	}

	/**
	 * Used for allowing concurrent executions of this script with different 'event' options
	 *
	 * @return String
	 */
	public function generateCacheKey() {
		return parent::generateCacheKey() . '_' . $this->getOption( 'event' );
	}
}

$maintClass = 'FounderEmailsMaintenance';
require_once RUN_MAINTENANCE_IF_MAIN;
