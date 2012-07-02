<?php
/**
 * Command line script to mark translations fuzzy (similar to gettext fuzzy).
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/// @cond

require( dirname( __FILE__ ) . '/cli.inc' );

# Override the memory limit for wfShellExec, 100 MB seems to be too little
$wgMaxShellMemory = 1024 * 200;

function showUsage() {
	STDERR( <<<EOT
Fuzzy bot command line script

Usage: php fuzzy.php [options...] <messages>

Options:
  --really        Really fuzzy, no dry-run
  --skiplanguages Skip some languages (comma separated)
  --comment       Comment for updating

EOT
);
	exit( 1 );
}

if ( isset( $options['help'] ) ) {
	showUsage();
}

$bot = new FuzzyScript( $args );

if ( isset( $options['skiplanguages'] ) ) {
	$_skipLanguages = array();
	$_skipLanguages = array_map( 'trim', explode( ',', $options['skiplanguages'] ) );
	$bot->skipLanguages = $_skipLanguages;
}
if ( isset( $options['norc'] ) ) {
	$cs->norc = true;
}

if ( isset( $options['comment'] ) ) {
	$bot->comment = $options['comment'];
}

if ( isset( $options['really'] ) ) {
	$bot->dryrun = false;
}

$bot->execute();

/// @endcond


/**
 * Class for marking translation fuzzy.
 */
class FuzzyScript {
	/// \list{String} List of patterns to mark.
	private $titles = array();
	/// \bool Check for configuration problems.
	private $allclear = false;
	/// \bool Dont do anything unless confirmation is given
	public $dryrun = true;
	/// \string Edit summary.
	public $comment = null;
	/// \list{String} List of language codes to skip.
	public $skipLanguages = array();

	/**
	 * @param $titles \list{String}
	 */
	public function __construct( $titles ) {
		$this->titles = $titles;
		$this->allclear = true;
	}

	public function execute() {
		if ( !$this->allclear ) {
			return;
		}

		$msgs = $this->getPages();
		$count = count( $msgs );
		STDOUT( "Found $count pages to update." );

		foreach ( $msgs as $phpIsStupid ) {
			list( $title, $text ) = $phpIsStupid;
			$this->updateMessage( $title, TRANSLATE_FUZZY . $text, $this->dryrun, $this->comment );
			unset( $phpIsStupid );
		}
	}

	/// Searches pages that match given patterns
	private function getPages() {
		global $wgTranslateMessageNamespaces;
		$dbr = wfGetDB( DB_SLAVE );

		$search = array();
		foreach ( $this->titles as $title ) {
			$title = Title::newFromText( $title );
			$ns = $title->getNamespace();
			if ( !isset( $search[$ns] ) ) $search[$ns] = array();
			$search[$ns][] = 'page_title' . $dbr->buildLike( $title->getDBKey(), $dbr->anyString() );
		}

		$title_conds = array();
		foreach ( $search as $ns => $names ) {
			if ( $ns == NS_MAIN ) $ns = $wgTranslateMessageNamespaces;
			$titles = $dbr->makeList( $names, LIST_OR );
			$title_conds[] = $dbr->makeList( array( 'page_namespace' => $ns, $titles ), LIST_AND );
		}

		$conds = array(
			'page_latest=rev_id',
			'rev_text_id=old_id',
			$dbr->makeList( $title_conds, LIST_OR ),
		);

		if ( count( $this->skipLanguages ) ) {
			$conds[] = 'substring_index(page_title, \'/\', -1) NOT IN (' . $dbr->makeList( $this->skipLanguages ) . ')';
		}

		$rows = $dbr->select(
			array( 'page', 'revision', 'text' ),
			array( 'page_title', 'page_namespace', 'old_text', 'old_flags' ),
			$conds,
			__METHOD__
		);

		$messagesContents = array();
		foreach ( $rows as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			$messagesContents[] = array( $title, Revision::getRevisionText( $row ) );
		}

		$rows->free();

		return $messagesContents;
	}

	/**
	 * Does the actual edit if possible.
	 * @param $title \type{Title}
	 * @param $text \string
	 * @param $dryrun \bool Whether to really do it or just show what would be done.
	 * @param $comment \string Edit summary.
	 */
	private function updateMessage( $title, $text, $dryrun, $comment = null ) {
		global $wgTranslateDocumentationLanguageCode, $wgUser;

		$oldUser = $wgUser;
		$wgUser = FuzzyBot::getUser();

		STDOUT( "Updating {$title->getPrefixedText()}... ", $title );
		if ( !$title instanceof Title ) {
			STDOUT( "INVALID TITLE!", $title );
			return;
		}

		$items = explode( '/', $title->getText(), 2 );
		if ( isset( $items[1] ) && $items[1] === $wgTranslateDocumentationLanguageCode ) {
			STDOUT( "IGNORED!", $title );
			return;
		}

		if ( $dryrun ) {
			STDOUT( "DRY RUN!", $title );
			return;
		}

		$article = new Article( $title, 0 );

		$status = $article->doEdit( $text, $comment ? $comment : 'Marking as fuzzy', EDIT_FORCE_BOT | EDIT_UPDATE );

		$success = $status === true || ( is_object( $status ) && $status->isOK() );
		STDOUT( $success ? 'OK' : 'FAILED', $title );

		$wgUser = $oldUser;
	}
}
