<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/ForumDumper.php' );
include_once( __DIR__ . '/FollowsFinder.php' );
include_once( __DIR__ . '/WallHistoryFinder.php' );


class DumpForumData extends Maintenance {
	/** @var  \Discussions\ForumDumper */
	private $dumper;
	private $fh;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps a set of INSERT statements suitable for importing into Discussion "import" tables';
		$this->addArg( 'out', "Output file for SQL statements", $required = false );
	}

	public function execute() {
		if ( $this->hasOption( 'out' ) ) {
			$this->fh = fopen( $this->getArg(), 'w' );
		} else {
			$this->fh = STDOUT;
		}
		$this->dumper = new Discussions\ForumDumper();

		$this->setConnectinoEncoding();
		$this->clearImportTables();
		$this->dumpPages();
		$this->dumpRevisions();
		$this->dumpVotes();
		$this->dumpFollows();
		$this->dumpWallHistory();
	}

	private function setConnectinoEncoding() {
		fwrite( $this->fh, "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;" );
	}

	private function clearImportTables() {
		fwrite( $this->fh, "DELETE FROM import_page;\n" );
		fwrite( $this->fh, "DELETE FROM import_revision;\n" );
		fwrite( $this->fh, "DELETE FROM import_vote;\n" );
		fwrite( $this->fh, "DELETE FROM import_follows;\n" );
		fwrite( $this->fh, "DELETE FROM import_history;\n" );
	}

	private function dumpPages() {
		$pages = $this->dumper->getPages();

		foreach ( $pages as $id => $data ) {
			$insert = $this->createInsert(
				'import_page',
				Discussions\ForumDumper::COLUMNS_PAGE,
				$data
			);

			fwrite( $this->fh, $insert . "\n" );
		}
	}

	private function dumpRevisions() {
		$revisions = $this->dumper->getRevisions();

		foreach ( $revisions as $data ) {
			$insert = $this->createInsert(
				'import_revision',
				Discussions\ForumDumper::COLUMNS_REVISION,
				$data
			);
			fwrite( $this->fh, $insert . "\n" );
		}
	}

	private function dumpVotes() {
		$votes = $this->dumper->getVotes();

		foreach ( $votes as $data ) {
			$insert = $this->createInsert(
				'import_vote',
				Discussions\ForumDumper::COLUMNS_VOTE,
				$data
			);
			fwrite( $this->fh, $insert . "\n" );
		}
	}

	private function dumpFollows() {
		$follows = $this->dumper->getFollows();

		foreach ( $follows as $data ) {
			$insert = $this->createInsert(
				'import_follows',
				Discussions\FollowsFinder::COLUMNS_FOLLOWS,
				$data
			);
			fwrite( $this->fh, $insert . "\n");
		}
	}

	private function dumpWallHistory() {
		$dumper = new Discussions\WallHistoryFinder( wfGetDB( DB_SLAVE ) );
		$history = $dumper->find();

		foreach ( $history as $data ) {
			$insert = $this->createInsert(
				'import_history',
				Discussions\WallHistoryFinder::COLUMNS,
				$data
			);
			fwrite( $this->fh, $insert . "\n");
		}
	}

	private function createInsert( $table, $cols, $data ) {
		$db = wfGetDB( DB_SLAVE );

		$insert = "INSERT INTO $table (`site_id`, " .
		          implode( ",", array_map( function ( $c ) use ( $db ) {
			          return 	$db->addIdentifierQuotes( $c );
		          }, $cols ) ) .
		          ")" .
		          " VALUES (" . \F::app()->wg->CityId;

		foreach ( $cols as $col ) {
			// Truncate long titles if necessary
			if ( $col == "title" ) {
				$value = mb_substr( $data[$col], 0, 512 );
			} else {
				$value = $data[$col];
			}

			$insert .= ', ' . $db->addQuotes( $value );
		}

		$insert .= ');';

		return $insert;
	}
}

$maintClass = DumpForumData::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
