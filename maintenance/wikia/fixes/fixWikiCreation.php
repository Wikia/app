<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class FixWikiCreation extends Maintenance {
	// defaults
	private $debug = false;
	private $listMode = false;
	private $wikiaID = 0;
	private $days = 1;
	private $fix = false;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'debug', 'Enable debug log' );
		$this->addOption( 'wikia', 'Wiki ID to fix' );
		$this->addOption( 'list', 'Create list of Wikis to fix');
		$this->addOption( 'days', 'Number of days to check' );
		$this->addOption( 'tables', 'Comma separated list of tables to check' );
		$this->addOption( 'fix', 'Add local-maintenance task, add create-wiki-local job etc.');
		$this->mDescription = "Finish process of Wiki creation if some problem occured on Special:CreateWiki";
	}

	public function execute() {
		global $wgExternalSharedDB;

		// options
		if( $this->hasOption( 'debug' ) ) {
			$this->debug = true;
		}
		if ( $this->hasOption( 'list' ) ) {
			$this->listMode = true;
		}
		if ( $this->hasOption( 'days' ) ) {
			$this->days = (int) $this->getOption( 'days' );
		}
		if ( $this->hasOption( 'wikia' ) ) {
			$this->wikiaID = (int) $this->getOption( 'wikia' );
		}
		if ( $this->hasOption( 'tables' ) ) {
			$this->tables = explode( ",", $this->getOption( 'tables' ) );
		}
		if ( $this->hasOption( 'fix' ) ) {
			$this->fix = true;
		}

		if ( empty( $this->tables ) ) {
			echo "There is no tables to check\n"; exit(1);
		}

		if ( $this->listMode || $this->fix ) {
			$this->output( "Run script with --list option ... \n" );

			$startDate = date( 'Y-m-d 00:00:00', strtotime("-{$this->days} days") );
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			$oRes = $dbr->select(
				array( "city_list" ),
				array( "city_id, city_dbname, city_created" ),
				array(
					sprintf( "city_created between '%s' and now()", $startDate ),
					( $this->wikiaID > 0 ) ? "city_id = {$this->wikiaID}" : "city_id > 0"
				),
				__METHOD__
			);

			$wikisToFix = array();
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ( $this->debug ) echo "Check {$oRow->city_dbname} ... \n";
				if ( $this->runCmd( $oRow->city_id, $oRow->city_dbname, array( '--tables=' . $this->getOption( 'tables' ) ) ) ) {
					if ( $this->fix ) {
						# fix wikia
						$this->fixWikia( $oRow->city_id );
					}
					$wikisToFix[ $oRow->city_id ] = array( $oRow->city_dbname, $oRow->city_created );
				}
			}

			if ( $this->fix ) {
				echo "List of Wikis fixed: \n";
			} else {
				echo "List of Wikis to fix: \n";
			}
			echo print_r( $wikisToFix, true );
			echo "Number of Wikis to fix: " . count( $wikisToFix ) . "\n";
		} elseif ( $this->wikiaID > 0 ) {
			$dbr = wfGetDB( DB_SLAVE );
			$tables_to_fix = array();
			/* check if page table exists */
			if ( !$dbr->tableExists( 'page', __METHOD__ ) ) {
				/* wiki to close */
				if ( $this->fix ) {
					WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $this->wikiaID, 'No SQL tables' );
				}
			} else {
				if ( !empty( $this->tables ) ) {
					foreach ( $this->tables as $table ) {
						if ( !$dbr->tableExists( $table , __METHOD__ ) ) {
							$tables_to_fix[] = $table;
						}
					}
				}
			}

			echo implode(",", $tables_to_fix);
		}
	}

	private function runCmd( $wiki_id, $wiki_name, $options = array() ) {
		$cmd = sprintf( "SERVER_ID=%d php %s %s --wikia=%d", $wiki_id, __FILE__, implode(" ", $options), $wiki_id );
		if ( $this->debug ) echo "\tRun $cmd ... ";
		echo "\tCheck {$wiki_name} ({$wiki_id}) ... ";
		$result = wfShellExec( $cmd, $retval );
		if ( $retval ) {
			echo " error code $retval: $result";
		} else {
			if ( empty( $result ) ) {
				echo " OK \n";
			} else {
				echo $result . "\n";
			}
		}

		return $result;
	}

	private function fixWikia( $wiki_id ) {
		global $wgExternalSharedDB, $wgUser;

		# read Wiki information from DB
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$oRow = $dbr->selectRow(
			array( 'city_list' ),
			array( '*' ),
			array( 'city_id' => $wiki_id ),
			__METHOD__
		);

		if ( !$oRow ) {
			return false;
		}

		# set jobs params
		$map_keys = array (
			'city_url'           => 'url',
			'city_founding_user' => 'founderId',
			'city_sitename'      => 'sitename',
			'city_lang'          => 'language',
			'city_dbname'        => 'dbname',
			'city_path'          => 'path',
		);

		$job_params = new stdClass();
		foreach ( $oRow as $key => $value ) {
			$id = ( !empty ( $map_keys[ $key ] ) ) ? $map_keys[ $key ] : $key;
			$job_params->$id = $value;
		}

		# set starter
		$mStarters = array(
			"*" => array(
				"*"  => "aastarter",
				"en" => "starter",
				"ja" => "jastarter",
				"de" => "destarter",
				"fr" => "frstarter",
				"nl" => "nlstarter",
				"es" => "esstarter",
				"pl" => "plstarter",
				"ru" => "rustarter",
			)
		);

		# dbstarter
		$job_params->sDbStarter = ( isset( $mStarters[ "*" ][ $job_params->language ] ) )
				? $mStarters[ "*" ][ $job_params->language ]
				: $mStarters[ "*" ][ "*" ];

		# type of Wiki
		$job_params->type = '';

		# founderName
		$wgUser = User::newFromId( $job_params->founderId );
		if ( is_object( $wgUser ) ) {
			$job_params->founderName = $wgUser->getName();
		}

		# no welcome email
		$job_params->disableWelcome = 1;
		# disable reminder
		$job_params->disableReminder = 1;
		# don't execute CreateWikiLocalJob-complete hook
		$job_params->disableCompleteHook = 1;

		// run job
		$localJob = new CreateWikiLocalJob(
			Title::newFromText( NS_MAIN, "Main" ),
			$job_params
		);

		$localJob->WFinsert( $job_params->city_id, $job_params->dbname );
		wfDebugLog( "createwiki", __METHOD__ . ": New createWiki local job created \n", true );

		/**
		 * inform task manager
		 */
		$Task = new LocalMaintenanceTask();
		$Task->createTask(
			array(
				"city_id" => $job_params->city_id,
				"command" => "maintenance/runJobs.php",
				"type"    => "CWLocal",
				"data"    => $job_params,
				"server"  => rtrim( $job_params->url, "/" )
			),
			TASK_QUEUED,
			BatchTask::PRIORITY_HIGH
		);

		return true;
	}
}

$maintClass = "FixWikiCreation";
require_once( DO_MAINTENANCE );
