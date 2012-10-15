<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array(
	'dump-database',
	'archive-images',
	'delete-database',
	'free-domains',
	'hide-dumps',
	'file',
	'ids',
	'reason',
	'start',
);

require_once( "commandLine.inc" );

class MultiHideWikisMaintenance {

	static protected $flagsMapping = array(
		'dump-database' => WikiFactory::FLAG_CREATE_DB_DUMP,
		'archive-images' => WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE,
		'delete-database' => WikiFactory::FLAG_DELETE_DB_IMAGES,
		'free-domains' => WikiFactory::FLAG_FREE_WIKI_URL,
		'hide-dumps' => WikiFactory::FLAG_HIDE_DB_IMAGES,
	);

	protected $options = array();
	protected $dryRun = false;
	protected $quiet = false;

	protected $inputFile = false;
	protected $inputIds = '';
	protected $flags = array(
//		WikiFactory::FLAG_CREATE_DB_DUMP => true,
//		WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE => true,
		WikiFactory::FLAG_DELETE_DB_IMAGES => true,
		WikiFactory::FLAG_FREE_WIKI_URL => true,
	);
	protected $reason = "-";
	protected $start = 0;

	protected $wikiIds = array();

	public function __construct( $options ) {
		// read command line arguments
		$this->options = $options;
		foreach ($this->options as $k => $v) {
			$k = strtolower($k);

			// change flags
			if (array_key_exists($k,self::$flagsMapping)) {
				$flagId = self::$flagsMapping[$k];
				if (in_array(strtolower($v), array('1', 'yes', 'y', 't','true','on'))) {
					// set flag
					$this->flags[$flagId] = true;
				} else {
					// reset flag
					unset($this->flags[$flagId]);
				}
			}

			// reason
			if ($k == 'reason' && !empty($v)) {
				$this->reason = trim($v);
			}

			// wiki ids list
			if ($k == 'ids' && !empty($v)) {
				$this->inputIds = $v;
			}

			// wiki ids file
			if ($k == 'file' && !empty($v)) {
				$this->inputFile = trim($v);
			}

			if ($k == 'dry-run') {
				$this->dryRun = true;
			}

			if ($k == 'quiet') {
				$this->quiet = true;
			}

			if ($k == 'start' && !empty($v)) {
				$this->start = intval($v);
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

	public function execute() {
		// dump the configuration
		$this->showConfiguration();

		$this->loadWikiIds();

		$this->processWikis();
	}

	protected function checkMemoryLimit( $limit ) {
		return memory_get_usage(true) < $limit * 1000000000;
	}

}

/**
 * used options:
 * --dump-database yes|no
 * --archive-images yes|no
 * --delete-database yes|no
 * --free-domains yes|no
 * --hide-dumps yes|no
 * --reason <reason>
 * --ids <comma separated wiki ids>
 * --file <file name to read wiki ids from>
 * --dry-run
 */
$wgAutoloadClasses['DeadWikiEvaluator'] = dirname(__FILE__). "/../Evaluate/DeadWikiEvaluator.class.php";
$maintenance = new MultiHideWikisMaintenance( $options );
$maintenance->execute();
