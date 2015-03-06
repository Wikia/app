<?php
/**
 * NOTE: PLEASE TAKE CARE WHILE EDITING THIS FILE.
 *       BAD CHANGE AND WE CAN CLOSE MANY WIKIS BY ACCIDENT.
 */

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
			'created' => array(
				'type' => 'datetime',
				'key' => 'created',
				'max' => '-182 days',
			),
			array(
				'type' => 'datetime',
				'key' => 'lastedited',
				'max' => '-60 days',
			),
			array(
				'type' => 'int',
				'key' => 'edits',
				'max' => '10',   // was 15
			),
			array(
				'type' => 'int',
				'key' => 'contentpages',
				'max' => '4',	// was 5
			),
			array(
				'type' => 'int',
				'key' => 'pvlast3month',
				'max' => '39',	// was 49
			),
		),
		self::DELETE_SOON => array(
			'created' => array(
				'type' => 'datetime',
				'key' => 'created',
				'max' => '-175 days',
			),
			array(
				'type' => 'datetime',
				'key' => 'lastedited',
				'max' => '-53 days',
			),
			array(
				'type' => 'int',
				'key' => 'edits',
				'max' => '10',
			),
			array(
				'type' => 'int',
				'key' => 'contentpages',
				'max' => '4',
			),
			array(
				'type' => 'int',
				'key' => 'pvlast3monthm5',
				'max' => '39',
			),
		)
	);
	static protected $FETCH_TIME_LIMIT = '-50 days';

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
	protected $readOnly = false;
	protected $mailing = true;

	public function __construct( $options ) {
//		self::adjustSettings();
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
			} else if ($k == 'read-only' || $k == 'readonly') {
				$this->readOnly = true;
			} else if ($k == 'limit') {
				$this->deletedLimit = intval($v);
			} else if ($k == 'nomail') {
				$this->mailing = false;
			} else if ($v === true) {
				die("Invalid argument: $k\n");
			}
		}
	}

	protected function getFlags() {
		$result = 0;
		foreach ($this->flags as $k => $v)
			$result |= intval($k);
		return $result;
	}

	protected $statsCache = null;

	protected function getStatsCache() {
		if (empty($this->statsCache)) {
			$this->statsCache = new WikiEvaluationCache();
		}
		return $this->statsCache;
	}

	protected function ts( $ts ) {
		if ($ts == 0) {
			return '1970-01-01 00:00:01';
		} else {
			return wfTimestamp( TS_DB, $ts );
		}
	}

	protected function updateWikiStats( $wiki ) {
		$data = $wiki;

		$data['city_id'] = $data['id'];
		$data['city_public'] = $data['public'];
		$data['created'] = $this->ts($data['created']);
		$data['lastedited'] = $this->ts($data['lastedited']);

		$catData = WikiFactory::getCategory($data['id']);
		$data['city_cat_name'] = $catData ? $catData->cat_name : '';

		unset($data['public']);
		unset($data['id']);
		unset($data['url']);

		$this->getStatsCache()->update($data);
	}

	protected function deleteWikiStats( $id ) {
		$this->getStatsCache()->delete($id);
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
			if ($classification) {
				echo "Marking wiki \"{$wiki['dbname']}\" (#{$id}) as \"$classification\"\n";
			}
			if ($classification) {
				$result[$classification][$id] = $wiki;
			}
		}

		return $result;
	}

	// Current criteria for wikis to skip:
	// Any wiki which is set "official" in the CityVisualization/ManageWikiaHome tool
	// Any wiki which has the WikiFactory "protect" flag set

	protected function getWikisList() {
		global $wgExternalSharedDB;

		echo "Searching for potentially dead wikis...\n";

		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$where = array(
			'l.city_public' => 1,
			'l.city_flags & ' . WikiFactory::FLAG_PROTECTED . ' = 0',
			// it could be -55 days, but leaving the margin for TZs
			"l.city_created < \"".wfTimestamp(TS_DB,strtotime(self::$FETCH_TIME_LIMIT))."\"",
			"(v.city_flags IS NULL OR v.city_flags & " . WikisModel::FLAG_OFFICIAL . " = 0)",
		);
		if (!is_null($this->from))
			$where[] = "l.city_id >= ".intval($this->from);
		if (!is_null($this->to))
			$where[] = "l.city_id <= ".intval($this->to);
		$res = $db->select(
			array(
				'l' => 'city_list',
				'v' => 'city_visualization',
			),
			array( 'l.city_id', 'l.city_dbname', 'l.city_url', 'l.city_public' ),
			$where,
			__METHOD__,
			array(
//				'ORDER BY' => 'city_id DESC',
				'ORDER BY' => 'l.city_id',
				'DISTINCT',
			),
			array( // join conditions
				'v' => array( 'LEFT JOIN', 'l.city_id = v.city_id' ),
			)
		);

		$wikis = array();
		while ($row = $res->fetchRow($res)) {
			$wikis[] = array(
				'id' => $row['city_id'],
				'dbname' => $row['city_dbname'],
				'url' => $row['city_url'],
				'public' => $row['city_public'],
			);
		}
		$db->freeResult($res);

		echo "Found ".count($wikis)." wikis for further analysis.\n";

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
			echo "Closing wiki \"{$wiki['dbname']}\" (#{$id}) ... ";
			if ($this->deletedLimit > 0 && $this->deletedCount >= $this->deletedLimit) {
				echo "cancelled (limit exceeded)\n";
				$notDeleted[$id] = $wiki;
				continue;
			}
			if ($this->readOnly) {
				echo "cancelled (read-only mode)\n";
				$deleted[$id] = $wiki;
				$this->deletedCount++;
				continue;
			}
			if ($this->doDisableWiki($id,$flags,self::DELETION_REASON)) {
				echo "ok\n";
				$this->deleteWikiStats($id);
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
			$now = wfTimestamp(TS_DB);
			foreach ($batch as $wiki) {
				$batchData[$wiki['id']] = $wiki;
				$batchData[$wiki['id']]['row_updated'] = $now;
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
			// save stats
			foreach ($evaluated as $id => $wiki) {
				$status = '';
				if (isset($classifications[self::DELETE_NOW][$id])) $status = 'deleteNow';
				if (isset($classifications[self::DELETE_SOON][$id])) $status = 'deleteSoon';
				$this->updateWikiStats(array_merge($wiki,array(
					'status' => $status,
				)));
			}
			if (isset($classifications[self::DELETE_NOW])) {
				$this->disableWikis($classifications[self::DELETE_NOW],$this->deleted,$this->toBeDeleted);
			}
			if (isset($classifications[self::DELETE_SOON])) {
				$this->toBeDeleted += $classifications[self::DELETE_SOON];
			}
		}
	}

	protected function sendEmail( $from, $to, $subject, $body, $bodyNoEntries, $fname, $wikis ) {
		$fromAddress = new MailAddress($from);
		$toAddress = new MailAddress($to);

		if (!empty($wikis)) {
			$csv = "ID,DatabaseName,URL\r\n";
			foreach ($wikis as $wiki) {
				$csv .= "\"{$wiki['id']}\",\"{$wiki['dbname']}\",\"{$wiki['url']}\"\r\n";
			}
			$fileName = "/tmp/$fname.csv";
			file_put_contents($fileName,$csv);
			UserMailer::send( $toAddress, $fromAddress, $subject, $body, null, null, 'dead-wikis', 0, array( $fileName ) );
		} else {
			UserMailer::send( $toAddress, $fromAddress, $subject, $bodyNoEntries, null, null , 'dead-wikis' );
		}
	}

	protected function sendEmails() {
		$date = gmdate('Ymd');
		$dateNice = gmdate('Y-m-d');

		$count = count($this->deleted);
		echo "Sending e-mail about $count deleted wikis...\n";
		$this->sendEmail(
			"wladek@wikia-inc.com",
			"wikis-deleted-l@wikia-inc.com",
			"[dead wikis] {$dateNice} - $count wikis were deleted",
			"{$count} wikis have been deleted today, full list of affected wikis is provided in the attachment.",
			"No wiki has been found today.",
			"wikis-deleted-{$date}",
			$this->deleted);

		$count = count($this->toBeDeleted);
		echo "Sending e-mail about $count wikis that may be deleted soon...\n";
		$this->sendEmail(
			"wladek@wikia-inc.com",
			"wikis-to-be-deleted-l@wikia-inc.com",
			"[dead wikis] {$dateNice} - $count wikis may be deleted soon",
			"{$count} candidate wikis have been found that may be deleted soon, full list of affected wikis is provided in the attachment.",
			"No candidate wiki has been found that may be deleted soon.",
			"wikis-to-be-deleted-{$date}",
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

	static protected function adjustSettings() {
		/*
		$secondsPerDay = 24 * 60 * 60;
		$maxWeek = 52;
		$minWeek = 36;

		$start = strtotime('19.03.2012 00:00:00 UTC');
		$time = time();
		$passed = intval(($time - $start) / $secondsPerDay);

		$shift = max(0,intval($passed/7)*4 + min($passed%7,3));
		$weeks = max($minWeek,$maxWeek-$shift);

		$days = $weeks * 7;
		$ndays = max($weeks-1,$minWeek) * 7;
		$kdays = $ndays - 2;

		self::$conditions[self::DELETE_NOW]['created']['max'] = "-$days days";
		self::$conditions[self::DELETE_SOON]['created']['max'] = "-$ndays days";
		self::$FETCH_TIME_LIMIT = "-$kdays days";
		*/
	}

}

/**
 * used options:
 */
$wgAutoloadClasses['WikiEvaluationDataSource'] = dirname(__FILE__). "/WikiEvaluationDataSource.class.php";
$wgAutoloadClasses['WikiEvaluationOracle'] = dirname(__FILE__). "/WikiEvaluationOracle.class.php";
$wgAutoloadClasses['WikiEvaluationCache'] = dirname(__FILE__). "/WikiEvaluationCache.class.php";
$maintenance = new AutomatedDeadWikisDeletionMaintenance( $options );
$maintenance->execute();
