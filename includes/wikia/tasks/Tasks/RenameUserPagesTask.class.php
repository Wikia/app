<?php
namespace Wikia\Tasks\Tasks;

use Title;
use User;
use Wikia;

class RenameUserPagesTask extends BaseTask {
	const NAMESPACES = [
		2, // User
		3, // User talk
		500, // User blog
		1200, // Message Wall
		1202, // Message Wall Greeting
	];

	/**
	 * Normalized user names use spaces, while article names in database
	 * are stored with underscores instead of spaces.
	 *
	 * @see SUS-3560
	 *
	 * @param string $userName
	 * @return string
	 */
	private static function normalizeUserName( string $userName ) : string {
		return str_replace( ' ', '_', $userName );
	}

	/**
	 * Get wikis where this user has an user page, user blog, Message Wall etc.
	 * @param string $oldUserName
	 * @return int[] array of wiki IDs
	 */
	public static function getTargetCommunities( string $oldUserName ) {
		global $wgExternalDatawareDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );

		return $dbr->selectFieldValues( 'pages', 'page_wikia_id', [
			'page_namespace' => static::NAMESPACES,
			'page_title' => self::normalizeUserName( $oldUserName )
		], __METHOD__ , [ 'DISTINCT' ] );
	}

	/**
	 * Rename local user related pages and their subpages to the new user name
	 *
	 * @param string $oldUserName
	 * @param string $newUserName
	 */
	public function renameLocalPages( string $oldUserName, string $newUserName ) {
		$dbr = wfGetDB( DB_SLAVE );
		$oldUserName = self::normalizeUserName( $oldUserName );

		$subPagesLikeQuery = $dbr->buildLike( "$oldUserName/", $dbr->anyString() );

		$resultSet = $dbr->select( 'page', '*', [
			'page_namespace' => static::NAMESPACES,
			'page_title = '. $dbr->addQuotes( $oldUserName ) . " OR page_title $subPagesLikeQuery"
		], __METHOD__ );

		$robot = $GLOBALS['wgUser'] = User::newFromName( Wikia::BOT_USER );

		foreach ( $resultSet as $row ) {
			$title = Title::newFromRow( $row );

			$newTitleText = preg_replace( "/$oldUserName/", $newUserName, $row->page_title );
			$newTitle = Title::makeTitleSafe( $row->page_namespace, $newTitleText );

			$editSummary =
				wfMessage( 'userrenametool-move-log', $title->getText(), $newTitle->getText() )
					->inContentLanguage()
					->text();

			$title->moveTo( $newTitle, false, $editSummary, true, $robot );
		}
	}
}
