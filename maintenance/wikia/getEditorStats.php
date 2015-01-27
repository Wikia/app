<?php

/**
 * Maintenance script used for getting revisions with tags (for example Editor type used for generating revision)
 *
 * Env vars:
 * [int] SERVER_ID - wiki id | example 12345
 * [string] START_DATE - format D-M-Y example "01-01-2015"
 * [string] END_DATE - format D-M-Y example "01-01-2015"
 * [string] STATS_DB_HOST - stats db host name
 * [string] STATS_DB_NAME - stats db name
 * [string] STATS_DB_USER - stats db user
 * [string] STATS_DB_PASS - stats db password
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class GetRevisionWithTags extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Get Editor Stats';
	}

	public function execute() {
		$timeStampStart = date('YMDHIs', strtotime($_SERVER['START_DATE']));
		$timeStampEnd = date('YMDHIs', strtotime($_SERVER['END_DATE']));
		$statsDbHostName = $_SERVER['STATS_DB_HOST'];
		$statsDbName = $_SERVER['STATS_DB_NAME'];
		$statsDbUser = $_SERVER['STATS_DB_USER'];
		$statsDbPass = $_SERVER['STATS_DB_PASS'];

		$dbh = null;
		$data = [];

		// get revisions
		$query = (new WikiaSQL())
			->SELECT()
			->FIELD('rev_id')
			->FROM('revision')
			->LEFT_JOIN('tag_summary')
			->ON('ts_rev_id', 'rev_id')
			->FIELD('ts_tags')
			->WHERE('rev_timestamp')
			->BETWEEN($timeStampStart, $timeStampEnd);

		$data = $query->run(wfGetDB(DB_SLAVE), function (ResultWrapper $result) {
			while ($row = $result->fetchObject()) {
				$this->pushRevData($data, $row);
			}

			return $data;
		});

		// insert editor stats into db table
		try {
			$dbh = new PDO("mysql:host=$statsDbHostName;dbname=$statsDbName", $statsDbUser, $statsDbPass);

			print('Connected to stats database');
			print(PHP_EOL);

			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$dbh->beginTransaction();

			$stmt = $dbh->prepare("INSERT IGNORE INTO editorstats (wiki_id, revision_id, editor)
 				VALUES (:wiki_id, :revision_id, :editor)");
			$stmt->bindParam(':wiki_id', $wiki_id);
			$stmt->bindParam(':revision_id', $revision_id);
			$stmt->bindParam(':editor', $editor);

			foreach ($data as $rev) {
				$wiki_id = $rev['wiki_id'];
				$revision_id = $rev['revision_id'];
				$editor = $rev['editor'];

				$stmt->execute();
			}

			$dbh->commit();

			print('Data entered successfully');
			print(PHP_EOL);
		} catch(PDOException $error) {
			$dbh->rollback();
			print($error->getMessage());
		}
	}

	/**
	 * @desc add new revision to
	 * @param $data array -
	 * @param $row stdClass
	 */
	private function pushRevData(&$data, $row) {
		$data[] = [
			'wiki_id' => $_SERVER['SERVER_ID'],
			'revision_id' => $row->rev_id,
			'editor' => $this->sanitizeRevTag($row->ts_tags)
		];
	}

	/**
	 * @desc returns editor type base on tags blob
	 * @param $tagBlob string
	 * @return null|string
	 */
	private function sanitizeRevTag($tagBlob) {
		$editorTags = [
			'rte-source',
			'rte-wysiwyg',
			'visualeditor',
			'mobileedit'
		];
		$editor = null;

		foreach ($editorTags as $tag) {
			if (strpos($tagBlob, $tag) !== false) {
				$editor = $tag;
			}
		}

		return $editor;
	}
}

$maintClass = 'GetRevisionWithTags';
require_once( RUN_MAINTENANCE_IF_MAIN );
