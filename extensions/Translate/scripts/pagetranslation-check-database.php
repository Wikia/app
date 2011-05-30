<?php
/**
 * Script to check the consistency of the databases of the page translation
 * feature and fix problems.
 *
 * @author Niklas Laxstrom
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

/**
 * Script to check the consistency of the databases of the page translation
 * feature and fix problems.
 * @todo Document methods.
 */
class PTCheckDB extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Check the consistency of the databases of the page translation feature and fix problems.';
		$this->addOption( 'fix', 'Fix the found problems if possible' );
	}

	public function execute() {
		$fixes = $this->checkSectionTable();
		$fixes += $this->checkRevTagTable();

		$dbw = wfGetDB( DB_MASTER );
		if ( $this->getOption( 'fix' ) ) {
			$this->output( "Performing the following fixes:\n" );

			foreach ( $fixes as $name => $data ) {
				$this->output( "$name: $data[0]...", $name );
				$dbw->delete( $data[1], '*', $data[2], __METHOD__ );
			}
		} else {
			$this->output( "Use --fix to perform following fixes:\n" );

			foreach ( $fixes as $name => $data ) {
				$sql = $dbw->selectSQLtext( $data[1], '*', $data[2] );
				$sql = preg_replace( '~^SELECT~', 'DELETE', $sql );
				$this->output( "$name: $data[0] - $sql\n" );
			}
		}
	}

	protected function checkSectionTable() {
		$fixes = array();

		$dbr = wfGetDB( DB_SLAVE );
		$pages = $dbr->select( 'translate_sections', 'trs_page', null, __METHOD__, array( 'GROUP BY' => 'trs_page' ) );

		$this->output( "Found {$pages->numRows()} pages in the section table\n" );
		$this->output( "Checking that they match a valid translatable page...\n\n" );

		foreach ( $pages as $row ) {
			$id = $row->trs_page;
			$sections = $dbr->select( 'translate_sections', 'trs_key', array( 'trs_page' => $id ), __METHOD__ );
			$title = Title::newFromID( $id );
			$sectionNames = $this->getSectionNames( $sections );

			$name = $title ? $title->getPrefixedText() : "#$id";
			$this->output( "Page $name has {$sections->numRows()} sections [$sectionNames]\n" );

			if ( !$title ) {
				$name = "#$id";
				$deleted = $this->findDeletedPage( $id );
				if ( $deleted === false ) {
					$this->output( "Page id $id does not correspond to any page\n" );
				} else {
					$name .= "<$deleted>";
					$this->output( "Page id $id corresponds to a deleted page $deleted\n" );
				}
				$fixes["$name <sections>"] = array( 'delete sections', 'translate_section', array( 'trs_page' => $id ) );
			} else {
				$name = $title->getPrefixedText();
				$page = TranslatablePage::newFromTitle( $title );
				$tagged = $page->getReadyTag();
				$marked = $page->getMarkedTag();
				$latest = $title->getLatestRevId();
				$this->output( "Revision numbers: <tagged, marked, latest> <$tagged, $marked, $latest>\n" );
				if ( strval( $marked ) === '' ) {
					$this->output( "These sections do not belong the current page (anymore?)\n" );
					$fixes["$name <sections>"] = array( 'delete sections', 'translate_section', array( 'trs_page' => $id ) );
				}
			}

			$this->output( "\n" );
		}

		return $fixes;
	}

	protected function checkRevTagTable() {
		$fixes = array();

		$dbr = wfGetDB( DB_SLAVE );

		$result = $dbr->select( 'revtag_type', '*', null, __METHOD__ );
		$idToTag = array();

		foreach ( $result as $_ ) {
			$idToTag[$_->rtt_id] = $_->rtt_name;
		}

		$tagToId = array_flip( $idToTag );

		$pages = $dbr->select( 'revtag', 'rt_page', null, __METHOD__, array( 'GROUP BY' => 'rt_page' ) );
		$this->output( "Checking that tags match a valid page...\n\n" );

		foreach ( $pages as $row ) {
			$id = $row->rt_page;
			$title = Title::newFromID( $id );
			$name = $title ? $title->getPrefixedText() : "#$id";

			if ( !$title ) {
				$name = "#$id";
				$deleted = $this->findDeletedPage( $id );
				if ( $deleted === false ) {
					$this->output( "Page id $id does not correspond to any page\n" );
					$fixes["$name <revtag>"] = array( 'delete tags', 'revtag', array( 'rt_page' => $id ) );
				} else {
					$name .= "<$deleted>";
				}
			}
		}

		$this->output( "Checked {$pages->numRows()} pages in the revtag table\n" );
		$this->output( "\n\nValidating tags...\n" );

		$result = $dbr->select( 'revtag', '*', null, __METHOD__ );
		$transver = $tagToId['tp:transver'];

		foreach ( $result as $_ ) {
			if ( !isset( $idToTag[$_->rt_type] ) ) {
				$name = $this->idToName( $_->rt_page );
				$this->output( "Page $name has unknown tag {$_->rt_type}\n" );
				$fixes["$name <revtag:unknown:{$_->rt_type}>"] =
					array( 'delete tag', 'revtag', array( 'rt_page' => $id, 'rt_type' => $_->rt_type ) );
				continue;
			} elseif ( $_->rt_type === $transver ) {
				$check = $this->checkTransrevRevision( $rev );
				if ( $check !== true ) {
					$name = $this->idToName( $_->rt_page );
					$this->output( "Page $name has invalid tp:transver: $check\n" );
					$fixes["$name <revtag:transver>"] =
						array( 'delete tag', 'revtag', array( 'rt_page' => $id, 'rt_type' => $_->rt_type ) );
				}
			}
		}

		$this->output( "Checked {$result->numRows()} tags in the revtag table\n\n\n" );

		return $fixes;
	}

	protected function idToName( $id ) {
		$title = Title::newFromID( $id );
		$name = $title ? $title->getPrefixedText() : "#$id";

		if ( !$title ) {
			$name .= $this->findDeletedPage( $id );
		}

		return $name;
	}

	protected function getSectionNames( $result ) {
		$names = array();

		foreach ( $result as $section ) {
			$names[] = $section->trs_key;
		}

		return implode( ', ', $names );
	}

	protected function findDeletedPage( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->selectRow( 'archive', array( 'ar_namespace', 'ar_title' ),
			array( 'ar_page_id' => $id ), __METHOD__ );

		if ( $page ) {
			$title = Title::makeTitleSafe( $page->ar_namespace, $page->ar_title );
			if ( $title ) {
				return $title->getPrefixedText();
			}
		}

		return false;
	}

	protected function checkTransrevRevision( $revId ) {
		static $cache = array();

		if ( isset( $cache[$revId] ) ) {
			return $cache[$revId];
		}

		$revision = Revision::newFromId( $revId );
		if ( !$revision ) {
			$cache[$revId] = 'no such revision';
		} else {
			$title = $revision->getTitle();
			if ( !$title ) {
				$cache[$revId] = 'no title for the revision';
			} else {
				$page = TranslatablePage::newFromTitle( $title );
				if ( $page->getMarkedTag() === false ) {
					$cache[$revId] = 'revision belongs to a page that is not marked for translation';
				} else {
					$cache[$revId] = true;
				}
			}
		}

		return $cache[$revId];
	}
}

$maintClass = 'PTCheckDB';
require_once( DO_MAINTENANCE );
