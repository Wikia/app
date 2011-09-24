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
	'to'
);

require_once( "commandLine.inc" );

// PEAR::Mail::mime
require_once( "Mail/mime.php" );

class AutomatedDeadWikisDeletionMaintenance {

	const BATCH_SIZE = 100;
	const COMMUNITY_ID = 177;
	const DELETION_REASON = 'dead wiki';
	
	static protected $conditions = array(
		'deleteNow' => array(
			array(
				'type' => 'datetime',
				'key' => 'created',
				'max' => '-60 days',
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
				'max' => '4',
			),
		),
		'deleteSoon' => array(
			array(
				'type' => 'datetime',
				'key' => 'created',
				'max' => '-55 days',
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
				'max' => '4',
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
	protected $forced = false;

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
			} else if ($k == 'force') {
				$this->forced = true;
			}
		}
	}

	protected function getFlags() {
		$result = 0;
		foreach ($this->flags as $k => $v)
			$result |= intval($k);
		return $result;
	}

	protected function showConfiguration() {
		if ($this->quiet) {
			return;
		}
		foreach (self::$flagsMapping as $name => $v) {
			echo "Flag \"$name\" = " . (isset($this->flags[$v]) ? "YES" : "NO") . "\n";
		}
		echo "Reason = \"{$this->reason}\"\n";
		echo "Input ids = " . ( !empty($this->inputIds) ? "\"{$this->inputIds}\"" : "---" ) . "\n";
		echo "Input file = " . ( !empty($this->inputFile) ? "\"{$this->inputFile}\"" : "---" ) . "\n";
	}



	protected function loadWikiIds() {
		if ($this->inputFile != '') {
			$contents = file_get_contents($this->inputFile);
			$this->inputIds = $contents;
		}
		if ($this->inputIds != '') {
			$idsList = preg_replace("/[\r\n]+/", ",", $this->inputIds);
			$idsList = preg_split("/,+/",$idsList);
			$wikiIds = array();
			foreach ($idsList as $id) {
				$id = intval(trim($id));
				if ($id > 0)
					$wikiIds[$id] = $id;
			}
			$this->wikiIds = $wikiIds;
		}
	}

	protected function processWikis() {
		$flags = $this->getFlags();
		$status = ( $flags & WikiFactory::FLAG_HIDE_DB_IMAGES ) ? WikiFactory::HIDE_ACTION : WikiFactory::CLOSE_ACTION;
		$reason = $this->reason;

		foreach ($this->wikiIds as $wikiId) {
			// skip wikis with id lesser than "start"
			if ($this->start && $this->start > $wikiId) {
				continue;
			}
//			echo "status: memory = ".memory_get_usage(true)."\n";
			// check memory usage
			if ( !$this->checkMemoryLimit(1) ) {
				echo "error: memory limit exceeded (1G), please restart the script\n";
				return;
			}

			$city = WikiFactory::getWikiByID($wikiId);
			if (!$city) {
				echo "$wikiId: error: city could not be found\n";
				continue;
			}
			$city_name = $city->city_dbname;
			if (!$city->city_public) {
				echo "$wikiId: error: ({$city_name}) city is already non-public\n";
				continue;
			}

			$evaluator = new DeadWikiEvaluator($wikiId);
			if (!$evaluator->getStatus()) {
				echo "$wikiId: error: ({$city_name}) city does not meet requirements to be closed: ".$evaluator->getMessage()."\n";
				continue;
			}

			echo "$wikiId: ({$city_name}) marking as closed... ";
			if (!$this->dryRun) {
				WikiFactory::setFlags($wikiId, $flags);
				$res = WikiFactory::setPublicStatus($status, $wikiId, $reason);
				WikiFactory::clearCache($wikiId);
				echo "OK\n";
			} else {
				echo "OK (dry run)\n";
			}
		}
	}
	
	
	protected $oracle = null;
	
	protected function getOracle() {
		if (empty($this->oracle)) {
			$this->oracle = new WikiEvaluationOracle(self::$conditions);
		}
		return $this->oracle;
	}

	
	protected $wikis = array();
	
	protected $deleteNow = array();
	protected $deleteSoon = array();
	
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
			var_dump($initialData);
		}
		$wikis = array();
		$lines = preg_split("/[\r\n]+/",$output);
		foreach ($lines as $line) {
			if ( ($data = $this->parseWikiDescription(trim($line))) ) {
				var_dump($initialData[$data['id']],$data);
				$wikis[$data['id']] = array_merge(
					isset($initialData[$data['id']]) ? $initialData[$data['id']] : array(),
					$data
				);
				var_dump("parsing",$initialData[$data['id']],$data,$wikis[$data['id']]);
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
	
	protected function evaluateWikis( $wikis ) {
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
			$knownClassifications = array_keys( self::$conditions );
			foreach ($knownClassifications as $classification) {
				if (isset($classifications[$classification])) {
					$this->{$classification} = $this->{$classification} + $classifications[$classification];
				}
			}
		}
	}
	
	protected function getWikisList() {
		global $wgExternalSharedDB;
		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$where = array(
			'city_public' => 1,
			// it could be -55 days, but leaving the margin for TZs
			"city_created < \"".wfTimestamp(TS_DB,strtotime('-52 days'))."\""
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
				'ORDER BY' => 'city_id DESC',
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
	
	protected function disableWikis( $wikis ) {
		return;
		$flags = $this->getFlags();
		foreach ($wikis as $id => $wiki) {
			WikiFactory::disableWiki($id,$flags,self::DELETION_REASON);
		}
	}
	
	protected function sendEmail( $from, $to, $subject, $body, $csvName, $wikis ) {
		// prepare mime 
		$mime = new Mail_mime();
		$mime->setTXTBody($body);
		
		$csv = "ID,DatabaseName,URL\r\n";
		foreach ($wikis as $wiki) {
			$csv .= "\"{$wiki['id']}\",\"{$wiki['dbname']}\",\"{$wiki['url']}\"\r\n";
		}
		var_dump($mime->addAttachment($csv,'text/csv',$csvName,false));
		
		$fromAddress = new MailAddress($from);
		$toAddress = new MailAddress($to);
		var_dump($mime->get());
		UserMailer::send($toAddress,$fromAddress,$subject,$mime->get());
	}
	
	protected function sendEmails() {
		$date = gmdate('Ymd');
		$dateNice = gmdate('Y m d');
		
		$count = count($this->deleteNow);
		$this->sendEmail(
			"wikis-deleted-l@wikia-inc.com",
			"wladek@wikia-inc.com",
			"wikis deleted {$dateNice}",
			"Script deleted {$count} wikis today, the list of closed wikis is attached in CSV file.",
			"wikis-deleted-{$date}.csv",
			$this->deleteNow);
		
		$count = count($this->deleteSoon);
		$this->sendEmail(
			"wikis-to-be-deleted-l@wikia-inc.com",
			"wladek@wikia-inc.com",
			"wikis to be deleted in 5 days {$dateNice}",
			"Script found {$count} wikis which will be deleted shortly, the list of wikis is attached in CSV file.",
			"wikis-to-be-deleted-{$date}.csv",
			$this->deleteSoon);
	}
	
	protected function actionClean() {
		$wikis = $this->getWikisList();
		$this->evaluateWikis($wikis);

		if ($forced) {
			$this->disableWikis($this->deleteNow);
//			$this->sendEmails();
		};
		$this->sendEmails();
		
//		var_dump($this->deleteNow);
//		var_dump($this->deleteSoon);
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
				$response .= " pvlastmonth=" . (int)$dataSource->getPageViews( '-28 days' );
				$response .= " pvlastmonthm5=" . (int)$dataSource->getPageViews( '-23 days' );
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
