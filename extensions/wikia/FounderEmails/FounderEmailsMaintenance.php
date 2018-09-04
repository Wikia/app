<?php
/**
 * Sends informative emails about activity on wikis to their owners. 
 *
 * Usage: SERVER_ID=177 php FounderEmailsMaintenance.php --event=daysPassed|viewsDigest|completeDigest
 */
require_once __DIR__ . '/../../../maintenance/Maintenance.php';

class FounderEmailsMaintenance extends Maintenance {

	private $events = [
		'daysPassed',
		'viewsDigest',
		'completeDigest'
	];

	public function __construct() {
		parent::__construct();
		$this->addOption( 'event', 'Specifies which type of events to process.', true, true, 'e' );
	}

	public function execute() {
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

$maintClass = 'FounderEmailsMaintenance';
require_once RUN_MAINTENANCE_IF_MAIN;
