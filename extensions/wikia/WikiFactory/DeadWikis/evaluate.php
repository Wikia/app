<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array(
	'action',
	'ids',
	'from',
	'to',
	'limit',
);

require_once( "commandLine.inc" );

class WikisEvaluateMaintenance {
	
	protected $options = array();
	
	protected $action = 'clean';
	protected $ids = null;
	protected $from = null;
	protected $to = null;
	protected $verbose = false;
	protected $debug = false;
	
	protected $deletedCount = 0;
	protected $deletedLimit = 0;
	protected $forced = false;
	protected $mailing = false;

	public function __construct( $options ) {
		// read command line arguments
		$this->options = $options;
		foreach ($this->options as $k => $v) {
			$k = strtolower($k);
			
			if ($k == 'action') {
				$this->action = $v;
			} else if ($k == 'ids') {
				$this->ids = explode(',',$v);
				$this->ids = array_map('trim',$this->ids);
			} else if ($k == 'from') {
				$this->from = intval($v);
			} else if ($k == 'to') {
				$this->to = intval($v);
			} else if ($k == 'verbose') {
				$this->verbose = true;
			} else if ($k == 'debug') {
				$this->verbose = true;
				$this->debug = true;
			} else if ($k == 'force') {
				$this->forced = true;
			} else if ($k == 'limit') {
				$this->deletedLimit = intval($v);
			} else if ($k == 'mail') {
				$this->mailing = true;
			}
		}
	}

	
	protected function actionEvaluate() {
		global $wgCityId;
		$ids = $this->ids;
		if ( empty($ids) ) {
			$ids = array( $wgCityId );
		}
		foreach ($ids as $id) {
			try {
				$dataSource = new WikiEvaluationDataSource($id);
				$response = "{$id} OK";
				$response .= " dbname=" . $dataSource->getDbName();
				$response .= " created=" . (int)$dataSource->getAge();
				$response .= " lastedited=" . (int)$dataSource->getLastEditTimestamp();
				$response .= " edits=" . (int)$dataSource->getEditsCount();
				$response .= " editsl60=" . (int)$dataSource->getEditsCount('-60 days');
				$response .= " contentpages=" . (int)$dataSource->getContentPagesCount();
				$response .= " pvlastmonth=" . (int)$dataSource->getPageViews( '-30 days' );
				$response .= " pvlastmonthm5=" . (int)$dataSource->getPageViews( '-25 days' );
				$response .= " pvlast3month=" . (int)$dataSource->getPageViews( '-90 days' );
				$response .= " pvlast3monthm5=" . (int)$dataSource->getPageViews( '-85 days' );
				$response .= "\n";
				echo $response;
			} catch (Exception $e) {
				echo "{$id} ERROR: ".$e->getMessage()."\n";
			}
		}
	}

	public function execute() {
		$this->actionEvaluate();
	}

}

/**
 * used options:
 */
$wgAutoloadClasses['WikiEvaluationDataSource'] = dirname(__FILE__). "/WikiEvaluationDataSource.class.php";
$maintenance = new WikisEvaluateMaintenance( $options );
$maintenance->execute();
