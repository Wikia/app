<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array(
	'ids',
	'from',
	'to',
	'limit',
);

require_once( "commandLine.inc" );

class DeadWikisStatsUpdaterMaintenance {

	const UPDATE_TTL = 3600; // 1 hour
	const BATCH_SIZE = 100;
	const COMMUNITY_ID = 177;
	
	protected $options = array();
	
	protected $ids = null;
	protected $from = null;
	protected $to = null;
	protected $verbose = false;
	protected $debug = false;
	
	protected $deletedCount = 0;
	protected $deletedLimit = 0;
	protected $forced = false;
	protected $mailing = false;
	
	protected $cache = null;

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

	protected function getCache() {
		if (empty($this->cache)) {
			$this->cache = new WikiEvaluationCache();
		}
		return $this->cache;
	}
	
	protected $wikis = array();
	
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
		$scriptName = __DIR__ . DIRECTORY_SEPARATOR . "evaluate.php";
		$cmd = "SERVER_ID=" . self::COMMUNITY_ID . " php $scriptName ".
			"--ids {$idsList} --conf {$wgWikiaLocalSettingsPath}";
			
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
	
	protected function getUpdatedIds() {
		$updatedSet = $this->getCache()->find(array(
			'row_updated > "'.wfTimestamp(TS_DB,time() - self::UPDATE_TTL ).'"'
		),'city_id');
		$updated = array();
		foreach ($updatedSet as $row)
			$updated[$row['city_id']] = $row['city_id'];
		return $updated;
	}

	protected function getWikisList() {
		global $wgExternalSharedDB;
		$uptodate = $this->getUpdatedIds();
		
		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$where = array(
			'city_public' => 1,
		);
		if (!is_null($this->from))
			$where[] = "city_id >= ".intval($this->from);
		if (!is_null($this->to))
			$where[] = "city_id <= ".intval($this->to);
		$res = $db->select(
			'city_list',
			array( 'city_id', 'city_dbname', 'city_url', 'city_public' ),
			$where,
			__METHOD__,
			array(
//				'ORDER BY' => 'city_id DESC',
				'ORDER BY' => 'city_id',
			)
		);
		
		$wikis = array();
		while ($row = $res->fetchRow($res)) {
			if ( !isset($uptodate[$row['city_id']])) {
				$wikis[] = array(
					'id' => $row['city_id'],
					'dbname' => $row['city_dbname'],
					'url' => $row['city_url'],
					'public' => $row['city_public'],
				);
			}
		}
		$db->freeResult($res);
		
		return $wikis;
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
			
			foreach ($evaluated as $wiki) {
				$this->saveWiki($wiki);
			}
		}
	}

	protected function ts( $ts ) {
		if ($ts == 0) {
			return '1970-01-01 00:00:01';
		} else {
			return wfTimestamp( TS_DB, $ts );
		}
	}

	protected function saveWiki( $wiki ) {
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

		$this->getCache()->update($data);
	}
	
	public function execute() {
		$wikis = $this->getWikisList();
		$this->batchProcess($wikis);
	}
	
}

/**
 * used options:
 */
$wgAutoloadClasses['WikiEvaluationDataSource'] = dirname(__FILE__). "/WikiEvaluationDataSource.class.php";
$wgAutoloadClasses['WikiEvaluationOracle'] = dirname(__FILE__). "/WikiEvaluationOracle.class.php";
$wgAutoloadClasses['WikiEvaluationCache'] = dirname(__FILE__). "/WikiEvaluationCache.class.php";
$maintenance = new DeadWikisStatsUpdaterMaintenance( $options );
$maintenance->execute();
