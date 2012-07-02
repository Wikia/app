<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class ExportMoodBar extends Maintenance {
	protected $fields = array(
			'id',
			'timestamp',
			'type',
			'namespace',
			'page',
			'own-talk',
			'usertype',
			'user',
			'user-editcount',
			'editmode',
			'bucket',
			'system',
			'locale',
			'useragent',
			'comment',
		);

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Exports MoodBar feedback";
		$this->addOption( 'since-id', 'Get feedback after this ID' );
		$this->addOption( 'since-time', 'Get feedback after this time' );
	}

	public function execute() {
		$dbr = wfGetDB( DB_SLAVE );
		$lastRowCount = 1;
		$fh = fopen('php://stdout', 'w');

		$offsetCond = array( 1 );

		if ( $this->getOption('since-id') ) {
			$offsetCond[] = 'mbf_id > '.$dbr->addQuotes( $this->getArg('since-id') );
		}

		if ( $this->getOption('since-time') ) {
			$ts = $dbr->timestamp( $this->getArg('since-id') );
			$offsetCond[] = 'mbf_timestamp > '.$dbr->addQuotes( $ts );
		}

		fputcsv( $fh, $this->fields );
		$lastId = 0;

		while ( $lastRowCount > 0 ) {
			$res = $dbr->select(
					array('moodbar_feedback','user'),
					'*',
					$offsetCond,
					__METHOD__,
					array( 'LIMIT' => 500 ),
					array(
						'user' => array(
							'left join',
							'user_id=mbf_user_id'
						)
					)
				);

			$lastRowCount = $dbr->numRows( $res );

			foreach( $res as $row ) {
				$this->outputRow( $fh, $row );
				$lastId = $row->mbf_id;
			}

			$offsetCond = 'mbf_id > ' . $dbr->addQuotes( $lastId );
		}
	}

	protected function outputRow( $fh, $row ) {
		//if there is an exception when setting this single record
		//record it so it won't stop the outputting of other records
		try {
			$item = MBFeedbackItem::load( $row );
			
			$user = User::newFromRow( $row );
			$outData = array();
	
			foreach( $this->fields as $field ) {
				$outData[] = MoodBarFormatter::getInternalRepresentation( $item, $field );
			}
		}
		catch (Exception $e) {
			$outData[] = wfMessage('moodbar-feedback-load-record-error')->escaped();
		}

		fputcsv( $fh, $outData );
	}
}

$maintClass = "ExportMoodBar";
require_once( DO_MAINTENANCE );
