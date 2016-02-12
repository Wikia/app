<?php

/**
 * Removes invalid title strings from imagelinks table
 * By default runs in dry run mode
 * Do really remove the rows, use --delete option
 */

require_once( getenv( 'MW_INSTALL_PATH' ) !== false ? getenv( 'MW_INSTALL_PATH' ) . '/maintenance/Maintenance.php' : dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class FixImageLinks extends Maintenance {
	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Removes invalid title strings from imagelinks table';
		$this->addOption( 'delete', 'Do real delete. By default performs a dry run.' );
	}

	public function execute() {
		$dryRun = !$this->hasOption( 'delete' );

		echo "Starting processing " . ( $dryRun ? "in dry run mode" : " in REAL DELETION MODE" ) . PHP_EOL . PHP_EOL;

		$invalidTitles = $this->getInvalidTitles();

		if ( $invalidTitles ) {
			echo "Found " . count($invalidTitles) . " invalid entries:" . PHP_EOL;
			foreach($invalidTitles as $invalidTitle) {
				echo "* " . $invalidTitle . PHP_EOL;
			}
			echo PHP_EOL;
			if ( $dryRun ) {
				echo "Skipping deletion - dry run" . PHP_EOL;
			} else {
				$this->performTitlesDeletion( $invalidTitles );
			}
		} else {
			echo "No broken entries found" . PHP_EOL;
		}

		echo "Processing finished" . PHP_EOL;
	}

	/**
	 * Gets all files from imagelinks table that do not have a name yielding valid Title object
	 * Such files break WantedFiles special page
	 * @return array
	 */
	private function getInvalidTitles() {
		$invalidTitles = [];

		$dataSource = new WantedFilesPageWikia();
		$results = $dataSource->reallyDoQuery( false );
		foreach ( $results as $row ) {
			$titleText = $row->title;
			$title = Title::makeTitleSafe( NS_FILE, $titleText );
			if ( !( $title instanceof Title ) ) {
				$invalidTitles [] = $titleText;
			}
		}
		return $invalidTitles;
	}

	/**
	 * Performs deletion of titles from imagelinks table
	 * based on provided list
	 * @param $invalidTitles
	 */
	private function performTitlesDeletion( $invalidTitles ) {
		echo "REALLY DELETING broken entries" . PHP_EOL;

		$db = wfGetDB( DB_MASTER );
		$sql = ( new WikiaSQL() )->DELETE( 'imagelinks' )->WHERE( 'il_to' )->IN( $invalidTitles );

		$status = $sql->run( $db );

		if ( $status ) {
			echo "DELETE finished successfully " . PHP_EOL;
		} else {
			echo "DELETE FAILED!" . PHP_EOL;
		}

		return $status;
	}
}

$maintClass = 'FixImageLinks';
require_once( RUN_MAINTENANCE_IF_MAIN );
