<?php
/**
 * Command line script to mark translations fuzzy (similar to gettext fuzzy).
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

require( dirname( __FILE__ ) . '/cli.inc' );

if ( $args === 1 || isset( $options['help'] ) ) {
	STDERR( <<<EOT
Fuzzy bot command line script

Usage: php fuzzy.php [options...] <messages>

Options:
  --really        Don't just run dry-run
  --skiplanguages Skip some languages
  --comment       Comment for updating

EOT
);
	exit( 1 );
}

$_skipLanguages = array();
if ( isset( $options['skiplanguages'] ) ) {
	$_skipLanguages = array_map( 'trim', explode( ',', $options['skiplanguages'] ) );
}
$_comment = @$options['comment'];
$_dryrun = !isset( $options['really'] );



$bot = new FuzzyBot( $args, $_comment, $_skipLanguages, $_dryrun );

$bot->execute();

class FuzzyBot {

	private $titles = array();
	private $dryrun = true;
	private $allclear = false;
	private $comment = null;
	private $skipLanguages = array();

	public function __construct( $titles, $comment, $skipLanguages, $dryrun = true ) {
		$this->titles = $titles;
		$this->comment = $comment;
		$this->skipLanguages = $skipLanguages;
		$this->dryrun = $dryrun;

		global $wgTranslateFuzzyBotName, $wgUser;

		if ( !isset( $wgTranslateFuzzyBotName ) ) {
			STDERR( "\$wgTranslateFuzzyBotName is not set" );
			return;
		}

		$wgUser = User::newFromName( $wgTranslateFuzzyBotName );

		if ( !$wgUser->isLoggedIn() ) {
			STDOUT( "Creating user $wgTranslateFuzzyBotName" );
			$wgUser->addToDatabase();
		}

		$this->allclear = true;

	}

	public function execute() {
		if ( !$this->allclear ) {
			return;
		}

		$msgs = $this->getPages();
		$count = count( $msgs );
		STDOUT( "Found $count pages to update." );

		foreach ( $msgs as  $phpIsStupid ) {
			list( $title, $text ) = $phpIsStupid;
			$this->updateMessage( $title, $text );
		}

	}

	private function getPages() {
		global $wgTranslateMessageNamespaces;
		$dbr = wfGetDB( DB_SLAVE );

		$search_titles = array();
		foreach ( $this->titles as $title ) {
			$title = TranslateUtils::title( $title, '' );
			$search_titles[] = "page_title LIKE '{$dbr->escapeLike( $title )}%%'";
		}

		$condArray = array(
			'page_is_redirect'  => 0,
			'page_namespace'    => $wgTranslateMessageNamespaces,
			'page_latest=rev_id',
			'rev_text_id=old_id',
			$dbr->makeList( $search_titles, LIST_OR ),
		);

		if ( count( $this->skipLanguages ) ) {
			$condArray[] = 'substring_index(page_title, \'/\', -1) NOT IN (' . $dbr->makeList( $this->skipLanguages ) . ')';
		}

		$conds = $dbr->makeList( $condArray, LIST_AND );

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

	private function updateMessage( $title, $text ) {
		global $wgTitle, $wgArticle, $wgTranslateDocumentationLanguageCode;
		$wgTitle = $title;

		STDOUT( "Updating {$wgTitle->getPrefixedText()}... ", true );
		if ( !$wgTitle instanceof Title ) {
			STDOUT( "INVALID TITLE!", false );
			return;
		}

		$items = explode( '/', $wgTitle->getText(), 2 );
		if ( isset( $items[1] ) && $items[1] === $wgTranslateDocumentationLanguageCode ) {
			STDOUT( "IGNORED!", false );
			return;
		}

		if ( $this->dryrun ) {
			STDOUT( "DRY RUN!", false );
			return;
		}

		$wgArticle = new Article( $wgTitle );

		$comment = $this->comment ? $this->comment : 'Marking as fuzzy';

		$status = $wgArticle->doEdit( TRANSLATE_FUZZY . $text, $comment, EDIT_FORCE_BOT );

		if ( $status === true || ( is_object( $status ) && $status->isOK() ) ) {
			STDOUT( "OK!", false );
		} else {
			STDOUT( "Failed!", false );
		}

	}

}
