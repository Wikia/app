<?php

/**
 * This script imports dump of production wikicities into devboxes
 *
 * Use --quiet option when running on cron machines
 *
 * @author macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

class ImportWikicities extends Maintenance {

	const S3_PATTERN = 's3://database_ShareDB_devboxes/fulldump_*';
	const S3_DUMP_PATTERN = 'wikicities_devbox';
	const DEST_DATABASE = 'wikicities';
	#const DEST_DATABASE = 'wikicities_macbre_test';

	const DB_USER = 'devbox';
	const DB_PASS = 'devbox';

	/* @var DatabaseMysql */
	private $dbw;

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

	/**
	 * Fetch given file from s3 to local file
	 *
	 * @param $path string s3 path
	 * @param $dest string local file
	 * @param $params string optional comamnd line parameters
	 * @return bool result
	 */
	private function get($path, $dest, $params = '') {
		return $this->executeS3cmd('get', "{$params} {$path} {$dest}");
	}

	/**
	 * Executes mysql CLI command
	 *
	 * @param $cmd string command
	 * @param $source string source to be put as "source | mysql ..."
	 */
	private function executeMysqlCmd($cmd, $source = '') {
		$mysqlCmd = sprintf('%smysql -h%s -u%s -p%s %s',
			($source !== '') ? "{$source} | " : '',
			$this->dbw->getServer(),
			self::DB_USER,
			self::DB_PASS,
			$cmd
		);

		wfShellExec($mysqlCmd, $retVal);
		return $retVal === 0;
	}

	public function execute() {
		global $IP, $wgExternalSharedDB, $wgDevelEnvironment, $wgWikiaDatacenter;

		if (empty($wgDevelEnvironment)) {
			$this->error('This script should only be run in development environment', 4);
		}

		$this->output("Running for {$wgWikiaDatacenter} devboxes\n");

		$this->output("Getting list of dumps...\n");
		$dumps = $this->ls(self::S3_PATTERN);

		if ($dumps === false) {
			$this->error('s3cmd failed!', 1);
		}

		// get the most recent dumps
		$lastDump = end($dumps);
		$this->output("{$lastDump} bucket will be used\n\n");

		$dumps = $this->ls($lastDump . self::S3_DUMP_PATTERN . '_*');
		$dump = reset($dumps);

		if (empty($dump)) {
			$this->error('No dump found!', 2);
		}

		// fetch the most recent dump to /tmp
		$dumpFile = tempnam(sys_get_temp_dir(), 'wikicities') . '.sql.gz';
		$this->output("Fetching {$dump} to {$dumpFile}...");

		$res = $this->get($dump, $dumpFile);
		if ($res === false) {
			$this->error('Fetching failed!', 3);
		}

		// connect to devbox shared database
		$this->dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$this->dbw->selectDB(self::DEST_DATABASE);

		$dbname = self::DEST_DATABASE;
		$this->output("\nImporting into {$dbname}...");

		// create a database
		$this->executeMysqlCmd("-e \"CREATE DATABASE IF NOT EXISTS {$dbname}\" 2>&1;");

		// import a dump
		$this->executeMysqlCmd("{$dbname} 2>&1", "zcat {$dumpFile}");
		$this->output(" done!\n");

		// execute devbox specific SQL
		$additionalSql = array(
			"$IP/extensions/wikia/Development/sql/city_list.sql"
		);

		foreach($additionalSql as $sql) {
			$this->output("Importing {$sql}...");
			$this->dbw->sourceFile($sql);
			$this->output("done\n");
		}

		// cleanup
		unlink($dumpFile);

		$this->output("\nI'm done!\n");
	}
}

$maintClass = "ImportWikicities";
require_once( RUN_MAINTENANCE_IF_MAIN );
