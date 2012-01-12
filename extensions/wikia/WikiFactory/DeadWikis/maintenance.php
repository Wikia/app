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

// PEAR::Mail::mime
require_once( "Mail/mime.php" );

class AutomatedDeadWikisDeletionMaintenance {

	const BATCH_SIZE = 100;
	const COMMUNITY_ID = 177;
	const DELETION_REASON = 'dead wiki';
	
	const DELETE_NOW = 'deleteNow';
	const DELETE_SOON = 'deleteSoon';
	
	static protected $conditions = array(
		self::DELETE_NOW => array(
			array(
				'type' => 'datetime',
				'key' => 'created',
				'max' => '-365 days',
			),
			array(
				'type' => 'datetime',
				'key' => 'lastedited',
				'max' => '-60 days',
			),
			array(
				'type' => 'int',
				'key' => 'edits',
				'max' => '9',
			),
			array(
				'type' => 'int',
				'key' => 'contentpages',
				'max' => '3',
			),
			array(
				'type' => 'int',
				'key' => 'pvlastmonth',
				'max' => '1',
			),
		),
		self::DELETE_SOON => array(
			array(
				'type' => 'datetime',
				'key' => 'created',
				'max' => '-360 days',
			),
			array(
				'type' => 'datetime',
				'key' => 'lastedited',
				'max' => '-55 days',
			),
			array(
				'type' => 'int',
				'key' => 'edits',
				'max' => '9',
			),
			array(
				'type' => 'int',
				'key' => 'contentpages',
				'max' => '3',
			),
			array(
				'type' => 'int',
				'key' => 'pvlastmonthm5',
				'max' => '1',
			),
		)
	);
	
	protected $options = array();
	protected $flags = array(
//		WikiFactory::FLAG_CREATE_DB_DUMP => true,
//		WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE => true,
		WikiFactory::FLAG_DELETE_DB_IMAGES => true,
		WikiFactory::FLAG_FREE_WIKI_URL => true,
	);
	
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

	protected function getFlags() {
		$result = 0;
		foreach ($this->flags as $k => $v)
			$result |= intval($k);
		return $result;
	}
	
	protected $oracle = null;
	
	protected function getOracle() {
		if (empty($this->oracle)) {
			$this->oracle = new WikiEvaluationOracle(self::$conditions);
		}
		return $this->oracle;
	}
	
	protected $wikis = array();
	
	protected $deleted = array();
	protected $toBeDeleted = array();
	
	protected function parseWikiDescription( $s ) {
		$s = trim($s);
		$matches = array();
		if (preg_match("/^([0-9]+) OK (.*)\$/",$s,$matches)) {
			$data = array(
				'id' => $matches[1],
			);
			$properties = explode(' ',$matches[2]);
			foreach ($properties as $property) {
				list( $key, $value ) = explode('=',$property,2);
				$data[trim($key)] = trim($value);
			}
			return $data;
		}
		return false;
	}
	
	protected function runEvaluationScript( $ids, &$output = '' ) {
		global $wgWikiaLocalSettingsPath;
		
		$idsList = implode(',',$ids);
		$cmd = "SERVER_ID=" . self::COMMUNITY_ID . " php " . __FILE__ . " ".
			"--action evaluate --ids {$idsList} --conf {$wgWikiaLocalSettingsPath}";
			
		$exitCode = null;
		$output = wfShellExec($cmd, $exitCode);
		return $exitCode;
	}
	
	protected function parseEvaluationScriptOutput( $output, $initialData = array() ) {
		if ($this->verbose) {
			echo $output;
//			var_dump($initialData);
		}
		$wikis = array();
		$lines = preg_split("/[\r\n]+/",$output);
		foreach ($lines as $line) {
			if ( ($data = $this->parseWikiDescription(trim($line))) ) {
//				var_dump($initialData[$data['id']],$data);
				$wikis[$data['id']] = array_merge(
					isset($initialData[$data['id']]) ? $initialData[$data['id']] : array(),
					$data
				);
//				var_dump("parsing",$initialData[$data['id']],$data,$wikis[$data['id']]);
			}
		}
		
		return $wikis;
	}

	protected function getOracleClassification( $wikis ) {
		$result = array();
		$oracle = $this->getOracle();
		foreach ($wikis as $id => $wiki) {
			$classification = $oracle->check($wiki);
			if ($this->verbose) {
				echo "$id "; var_dump($classification);
			}
			if ($classification) {
				$result[$classification][$id] = $wiki;
			}
		}
		
		return $result;
	}
	
	protected function getWikisList() {
		global $wgExternalSharedDB;
		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$where = array(
			'city_public' => 1,
			// it could be -55 days, but leaving the margin for TZs
			"city_created < \"".wfTimestamp(TS_DB,strtotime('-340 days'))."\""
		);
		if (!is_null($this->from))
			$where[] = "city_id >= ".intval($this->from);
		if (!is_null($this->to))
			$where[] = "city_id <= ".intval($this->to);
		$res = $db->select(
			'city_list',
			array( 'city_id', 'city_dbname', 'city_url' ),
			$where,
			__METHOD__,
			array(
//				'ORDER BY' => 'city_id DESC',
				'ORDER BY' => 'city_id',
			)
		);
		
		$wikis = array();
		while ($row = $res->fetchRow($res)) {
			$wikis[] = array(
				'id' => $row['city_id'],
				'dbname' => $row['city_dbname'],
				'url' => $row['city_url'],
			);
		}
		$db->freeResult($res);
		
		return $wikis;
	}
	
	protected function doDisableWiki( $wikiId, $flags, $reason = '' ) {
		// TOOD: copied from WikiFactory::disableWiki since it's not released yet
		WikiFactory::setFlags( $wikiId, $flags );
		$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason );
		if ($this->debug) {
			var_dump("setPublicStatus",$wikiId,$res);
		}
		WikiFactory::clearCache( $wikiId );
		return $res !== false;
	}
	
	protected function disableWikis( $wikis, &$deleted = array(), &$notDeleted = array() ) {
		$flags = $this->getFlags();
		foreach ($wikis as $id => $wiki) {
			if ($this->debug) {
				echo "$id STATUS " . intval(WikiFactory::isPublic($id)) . "\n";
			}
			echo "Closing wiki #$id ({$wiki['dbname']})... ";
			if ($this->deletedLimit > 0 && $this->deletedCount >= $this->deletedLimit) {
				echo "cancelled (limit exceeded)\n";
				$notDeleted[$id] = $wiki;
				continue;
			}
			if (!$this->forced) {
				echo "cancelled (dry run mode active)\n";
				$deleted[$id] = $wiki;
				$this->deletedCount++;
				continue;
			}
			if ($this->doDisableWiki($id,$flags,self::DELETION_REASON)) {
				echo "ok\n";
				$deleted[$id] = $wiki;
				$this->deletedCount++;
			} else {
				echo "failed\n";
				$notDeleted[$id] = $wiki;
			}
		}
	}
	
	protected function batchProcess( $wikis ) {
		// evaluate wikis in groups of 100 wikis
		while ($batch = array_splice($wikis,0,self::BATCH_SIZE)) {
			// fetch data from wikis
			$ids = array();
			$batchData = array();
			foreach ($batch as $wiki) {
				$batchData[$wiki['id']] = $wiki;
				$ids[$wiki['id']] = $wiki['id'];
			}
			$evaluated = array();
			for ( $pass = 0; $pass < 3 && count($ids) > 0; $pass++ ) {
				$output = '';
				$status = $this->runEvaluationScript($ids,$output);
				if ($status == 0) {
					$evaluatedNow = $this->parseEvaluationScriptOutput($output,$batchData);
					foreach ($evaluatedNow as $k => $wiki) {
						unset($ids[$wiki['id']]);
					}
					$evaluated = $evaluated + $evaluatedNow;
				}				
			}
			
			// classify wikis
			$classifications = $this->getOracleClassification($evaluated);
			if (isset($classifications[self::DELETE_NOW])) {
				$this->disableWikis($classifications[self::DELETE_NOW],$this->deleted,$this->toBeDeleted);
			}
			if (isset($classifications[self::DELETE_SOON])) {
				$this->toBeDeleted += $classifications[self::DELETE_SOON];
			}
			
			/*
			$knownClassifications = array_keys( self::$conditions );
			foreach ($knownClassifications as $classification) {
				if (isset($classifications[$classification])) {
					$this->{$classification} = $this->{$classification} + $classifications[$classification];
				}
			}
			*/
		}
	}
	
	protected function sendEmail( $from, $to, $subject, $body, $wikis ) {
		$body .= "\n\n\n======\n\n";
		$body .= "ID,DatabaseName,URL\r\n";
		foreach ($wikis as $wiki) {
			$body .= "\"{$wiki['id']}\",\"{$wiki['dbname']}\",\"{$wiki['url']}\"\r\n";
		}
		
		$fromAddress = new MailAddress($from);
		$toAddress = new MailAddress($to);
//		var_dump($mime->get());
		UserMailer::send($toAddress,$fromAddress,$subject,$body);
	}
	
	protected function sendEmails() {
		$date = gmdate('Ymd');
		$dateNice = gmdate('Y m d');
		
		$count = count($this->deleted);
		$this->sendEmail(
			"wladek@wikia-inc.com",
			"wikis-deleted-l@wikia-inc.com",
			"wikis deleted {$dateNice}",
			"Script deleted {$count} wiki(s) today, the list of closed wikis is provided below.",
			$this->deleted);
		
		$count = count($this->toBeDeleted);
		$this->sendEmail(
			"wladek@wikia-inc.com",
			"wikis-to-be-deleted-l@wikia-inc.com",
			"wikis to be deleted in 5 days {$dateNice}",
			"Script found {$count} wiki(s) which will be deleted shortly, the list of wikis is provided below.",
			$this->toBeDeleted);
	}
	
	protected function actionClean() {
		$wikis = $this->getWikisList();
		$this->batchProcess($wikis);

		if ($this->mailing) {
			$this->sendEmails();
		}
		
		if ($this->debug) {
#			var_dump("deleted",$this->deleted);
#			var_dump("to be deleted",$this->toBeDeleted);
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
				$response .= "\n";
				echo $response;
			} catch (Exception $e) {
				echo "{$id} ERROR: ".$e->getMessage()."\n";
			}
		}
	}

	public function execute() {
//		var_dump($this->options);
		switch ($this->action) {
			case 'clean':
				$this->actionClean();
				break;
			case 'evaluate':
				$this->actionEvaluate();
				break;
			default:
				$this->error("error: invalid action provided: \"{$this->action}\"",true);
		}
	}

}

/**
 * used options:
 */
$wgAutoloadClasses['WikiEvaluationDataSource'] = dirname(__FILE__). "/WikiEvaluationDataSource.class.php";
$wgAutoloadClasses['WikiEvaluationOracle'] = dirname(__FILE__). "/WikiEvaluationOracle.class.php";
$maintenance = new AutomatedDeadWikisDeletionMaintenance( $options );
$maintenance->execute();
