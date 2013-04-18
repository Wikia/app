<?php

/**
 * This script imports dump of production wikicities into devboxes
 *
 * Use --quiet option when running on cron machines
 *
 * @author macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class ImportWikicities extends Maintenance {

	const S3_PATTERN = 's3://database_Sharedb/fulldump_*';
	const S3_DUMP_PATTERN = 'wikicities_devbox';
	const DEST_DATABASE = 'wikicities';

	/**
	 * Executes command on S3
	 *
	 * @param $cmd string command name
	 * @param $param string command parameter
	 * @return bool|mixed S3 command result of false on error
	 */
	private function executeS3cmd($cmd, $param) {
		exec("s3cmd {$cmd} {$param}", $output, $retVal);

		if ($retVal !== 0) {
			return false;
		}
		else {
			return $output;
		}
	}

	/**
	 * List entries in a given path
	 *
	 * @param $path string path
	 * @return array entries
	 */
	private function ls($path) {
		$ret = array();
		$out = $this->executeS3cmd('ls', $path);

		if ($out === false) {
			return false;
		}

		foreach($out as $line) {
			$ret[] = end(explode(' ', $line));
		}

		return $ret;
	}

	public function execute() {
		global $IP, $wgExternalSharedDB;

		$this->output("Getting list of dumps...\n");
		$dumps = $this->ls(self::S3_PATTERN);

		if ($dumps === false) {
			$this->error('s3cmd failed!', 1);
		}

		// get the most recent dumps
		$lastDump = end($dumps);
		$this->output("{$lastDump} will be used\n");

		$dumps = $this->ls($lastDump . 'wiki*');
		#$dumps = $this->ls($lastDump . self::S3_DUMP_PATTERN . '_*');
		var_dump($dumps);
/**
		// execute devbox specific SQL
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$additionalSql = array(
			"$IP/extensions/wikia/Development/sql/city_list.sql"
		);

		foreach($additionalSql as $sql) {
			$this->output("Importing {$sql}...");
			$dbw->sourceFile($sql);
			$this->output("done\n");
		}
**/
		$this->output("\nI'm done!\n");
	}
}

$maintClass = "ImportWikicities";
require_once( RUN_MAINTENANCE_IF_MAIN );
