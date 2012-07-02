<?php
/**
 * Classes for Drafts extension
 *
 * @file
 * @ingroup Extensions
 */

abstract class Drafts {

	/* Static Functions */

	private static function getDraftAgeCutoff() {
		global $egDraftsLifeSpan;
		if ( !$egDraftsLifeSpan ) {
			// Drafts stay forever
			return 0;
		}
		return wfTimestamp( TS_UNIX ) - ( $egDraftsLifeSpan * 60 * 60 * 24 );
	}

	/**
	 * Counts the number of existing drafts for a specific user
	 *
	 * @param $title Object: [optional] Title of article, defaults to all articles
	 * @param $userID Integer: [optional] ID of user, defaults to current user
	 * @return Number of drafts which match condition parameters
	 */
	public static function num( $title = null, $userID = null ) {
		global $wgUser;
		// Get database connection
		$dbr = wfGetDB( DB_SLAVE );
		// Builds where clause
		$where = array(
			'draft_savetime > ' . $dbr->addQuotes(
				$dbr->timestamp( self::getDraftAgeCutoff() )
			)
		);
		// Checks if a specific title was given
		if ( $title !== null ) {
			// Get page id from title
			$pageId = $title->getArticleId();
			// Checks if page id exists
			if ( $pageId ) {
				// Adds specific page id to conditions
				$where['draft_page'] = $pageId;
			} else {
				// Adds new page information to conditions
				$where['draft_page'] = 0; // page not created yet
				$where['draft_namespace'] = $title->getNamespace();
				$where['draft_title'] = $title->getDBkey();
			}
		}
		// Checks if specific user was given
		if ( $userID !== null ) {
			// Adds specific user to condition
			$where['draft_user'] = $userID;
		} else {
			// Adds current user as condition
			$where['draft_user'] = $wgUser->getID();
		}
		// Get a list of matching drafts
		return $dbr->selectField( 'drafts', 'count(*)', $where, __METHOD__ );
	}

	/**
	 * Removes drafts which have not been modified for a period of time defined
	 * by $egDraftsCleanRatio
	 */
	public static function clean() {
		global $egDraftsCleanRatio;

		// Only perform this action a fraction of the time
		if ( rand( 0, $egDraftsCleanRatio ) == 0 ) {
			// Get database connection
			$dbw = wfGetDB( DB_MASTER );
			// Removes expired drafts from database
			$dbw->delete( 'drafts',
				array(
					'draft_savetime < ' .
						$dbw->addQuotes(
							$dbw->timestamp( self::getDraftAgeCutoff() )
						)
				),
				__METHOD__
			);
		}
	}

	/**
	 * Re-titles drafts which point to a particlar article, as a response to the
	 * article being moved.
	 */
	public static function move( $oldTitle, $newTitle ) {
		// Get database connection
		$dbw = wfGetDB( DB_MASTER );
		// Updates title and namespace of drafts upon moving
		$dbw->update( 'drafts',
			array(
				'draft_namespace' => $newTitle->getNamespace(),
				'draft_title' => $newTitle->getDBkey()
			),
			array(
				'draft_page' => $newTitle->getArticleId()
			),
			__METHOD__
		);
	}

	/**
	 * Gets a list of existing drafts for a specific user
	 *
	 * @param $title Object: [optional] Title of article, defaults to all articles
	 * @param $userID Integer: [optional] ID of user, defaults to current user
	 * @return List of drafts or null
	 */
	public static function get( $title = null, $userID = null ) {
		global $wgUser;
		// Removes expired drafts for a more accurate list
		Drafts::clean();
		// Gets database connection
		$dbw = wfGetDB( DB_MASTER );
		// Builds where clause
		$where = array(
			'draft_savetime > ' . $dbw->addQuotes(
				$dbw->timestamp( self::getDraftAgeCutoff() )
			)
		);
		// Checks if specific title was given
		if ( $title !== null ) {
			// Get page id from title
			$pageId = $title->getArticleId();
			// Checks if page id exists
			if ( $pageId ) {
				// Adds specific page id to conditions
				$where['draft_page'] = $pageId;
			} else {
				// Adds new page information to conditions
				$where['draft_namespace'] = $title->getNamespace();
				$where['draft_title'] = $title->getDBkey();
			}
		}
		// Checks if a specific user was given
		if ( $userID !== null ) {
			// Adds specific user to conditions
			$where['draft_user'] = $userID;
		} else {
			// Adds current user to conditions
			$where['draft_user'] = $wgUser->getID();
		}
		// Gets matching drafts from database
		$result = $dbw->select( 'drafts', '*', $where, __METHOD__ );
		if ( $result ) {
			// Creates an array of matching drafts
			$drafts = array();
			while ( $row = $dbw->fetchRow( $result ) ) {
				// Adds a new draft to the list from the row
				$drafts[] = Draft::newFromRow( $row );
			}
		}
		// Returns array of matching drafts or null if there were none
		return count( $drafts ) ? $drafts : null;
	}

	/**
	 * Outputs a table of existing drafts
	 *
	 * @param $title Object: [optional] Title of article, defaults to all articles
	 * @param $userID Integer: [optional] ID of user, defaults to current user
	 * @return Number of drafts in the table
	 */
	public static function display( $title = null, $userID = null ) {
		global $wgOut, $wgRequest, $wgUser, $wgLang;
		// Gets draftID
		$currentDraft = Draft::newFromID( $wgRequest->getIntOrNull( 'draft' ) );
		// Output HTML for list of drafts
		$drafts = Drafts::get( $title, $userID );
		if ( count( $drafts ) > 0 ) {
			global $egDraftsLifeSpan;
			// Internationalization

			// Add a summary, on Special:Drafts only
			if( !$title || $title->getNamespace() == NS_SPECIAL ) {
				$wgOut->wrapWikiMsg(
					'<div class="mw-drafts-summary">$1</div>',
					array(
						'drafts-view-summary',
						$wgLang->formatNum( $egDraftsLifeSpan )
					)
				);
			}
			// Build XML
			$wgOut->addHTML(
				Xml::openElement( 'table',
					array(
						'cellpadding' => 5,
						'cellspacing' => 0,
						'width' => '100%',
						'border' => 0,
						'id' => 'drafts-list-table'
					)
				)
			);
			$wgOut->addHTML( Xml::openElement( 'tr' ) );
			$wgOut->addHTML(
				Xml::element( 'th',
					array( 'width' => '75%', 'nowrap' => 'nowrap' ),
					wfMsg( 'drafts-view-article' )
				)
			);
			$wgOut->addHTML(
				Xml::element( 'th',
					null,
					wfMsg( 'drafts-view-saved' )
				)
			);
			$wgOut->addHTML( Xml::element( 'th' ) );
			$wgOut->addHTML( Xml::closeElement( 'tr' ) );
			// Add existing drafts for this page and user
			foreach ( $drafts as $draft ) {
				// Get article title text
				$htmlTitle = $draft->getTitle()->getEscapedText();
				// Build Article Load link
				$urlLoad = $draft->getTitle()->getFullURL(
					'action=edit&draft=' . urlencode( $draft->getID() )
				);
				// Build discard link
				$urlDiscard = SpecialPage::getTitleFor( 'Drafts' )->getFullURL(
					sprintf( 'discard=%s&token=%s',
						urlencode( $draft->getID() ),
						urlencode( $wgUser->editToken() )
					)
				);
				// If in edit mode, return to editor
				if (
					$wgRequest->getText( 'action' ) == 'edit' ||
					$wgRequest->getText( 'action' ) == 'submit'
				) {
					$urlDiscard .= '&returnto=' . urlencode( 'edit' );
				}
				// Append section to titles and links
				if ( $draft->getSection() !== null ) {
					// Detect section name
					$lines = explode( "\n", $draft->getText() );

					// If there is any content in the section
					if ( count( $lines ) > 0 ) {
						$htmlTitle .= '#' . htmlspecialchars(
							trim( trim( substr( $lines[0], 0, 255 ), '=' ) )
						);
					}
					// Modify article link and title
					$urlLoad .= '&section=' . urlencode( $draft->getSection() );
					$urlDiscard .= '&section=' .
						urlencode( $draft->getSection() );
				}
				// Build XML
				$wgOut->addHTML( Xml::openElement( 'tr' ) );
				$wgOut->addHTML(
					Xml::openElement( 'td' )
				);
				$wgOut->addHTML(
					Xml::element( 'a',
						array(
							'href' => $urlLoad,
							'style' => 'font-weight:' .
								(
									$currentDraft->getID() == $draft->getID() ?
									'bold' : 'normal'
								)
						),
						$htmlTitle
					)
				);
				$wgOut->addHTML( Xml::closeElement( 'td' ) );
				$wgOut->addHTML(
					Xml::element( 'td',
						null,
						$wgLang->timeanddate( $draft->getSaveTime(),
							true /* Adjust to user time zone*/ )
					)
				);
				$wgOut->addHTML(
					Xml::openElement( 'td' )
				);
				$jsClick = "if( wgDraft.getState() !== 'unchanged' )" .
					"return confirm('" .
					Xml::escapeJsString( wfMsgHTML( 'drafts-view-warn' ) ) .
					"')";
				$wgOut->addHTML(
					Xml::element( 'a',
						array(
							'href' => $urlDiscard,
							'onclick' => $jsClick
						),
						wfMsg( 'drafts-view-discard' )
					)
				);
				$wgOut->addHTML( Xml::closeElement( 'td' ) );
				$wgOut->addHTML( Xml::closeElement( 'tr' ) );
			}
			$wgOut->addHTML( Xml::closeElement( 'table' ) );
			// Return number of drafts
			return count( $drafts );
		}
		return 0;
	}
}

class Draft {

	/* Members */
	private $exists = false;
	private $id;
	private $token;
	private $userID;
	private $title;
	private $section;
	private $starttime;
	private $edittime;
	private $savetime;
	private $scrolltop;
	private $text;
	private $summary;
	private $minoredit;

	/* Static Functions */

	/**
	 * Creates a new Draft object from a draft ID
	 *
	 * @param $id Integer: ID of draft
	 * @param $autoload Boolean: [optional] Whether to load draft information
	 * @return New Draft object
	 */
	public static function newFromID( $id, $autoload = true ) {
		return new Draft( $id, $autoload );
	}

	/**
	 * Creates a new Draft object from a database row
	 *
	 * @param $row Array: Database row to create Draft object with
	 * @return New Draft object
	 */
	public static function newFromRow( $row ) {
		$draft = new Draft( $row['draft_id'], false );
		$draft->setToken( $row['draft_token'] );
		$draft->setTitle(
			Title::makeTitle( $row['draft_namespace'], $row['draft_title'] )
		);
		$draft->setSection( $row['draft_section'] );
		$draft->setStartTime( $row['draft_starttime'] );
		$draft->setEditTime( $row['draft_edittime'] );
		$draft->setSaveTime( $row['draft_savetime'] );
		$draft->setScrollTop( $row['draft_scrolltop'] );
		$draft->setText( $row['draft_text'] );
		$draft->setSummary( $row['draft_summary'] );
		$draft->setMinorEdit( $row['draft_minoredit'] );
		return $draft;
	}

	/* Properties */

	/**
	 * @return Whether draft exists in database
	 */
	public function exists() {
		return $this->exists;
	}

	/**
	 * @return Draft ID
	 */
	public function getID() {
		return $this->id;
	}

	/**
	 * @return Edit token
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * Sets the edit token, like one generated by wfGenerateToken()
	 * @param $token String
	 */
	public function setToken( $token ) {
		$this->token = $token;
	}

	/**
	 * @return User ID of draft creator
	 */
	public function getUserID() {
		return $this->userID;
	}

	/**
	 * Sets user ID of draft creator
	 * @param $userID Integer: user ID
	 */
	public function setUserID( $userID ) {
		$this->userID = $userID;
	}

	/**
	 * @return Title of article of draft
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets title of article of draft
	 * @param $title Object
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * @return Section of the article of draft
	 */
	public function getSection() {
		return $this->section;
	}

	/**
	 * Sets section of the article of draft
	 * @param $section Integer
	 */
	public function setSection( $section ) {
		$this->section = $section;
	}

	/**
	 * @return Time when draft of the article started
	 */
	public function getStartTime() {
		return $this->starttime;
	}

	/**
	 * Sets time when draft of the article started
	 * @param $starttime String
	 */
	public function setStartTime( $starttime ) {
		$this->starttime = $starttime;
	}

	/**
	 * @return Time of most recent revision of article when this draft started
	 */
	public function getEditTime() {
		return $this->edittime;
	}

	/**
	 * Sets time of most recent revision of article when this draft started
	 * @param $edittime String
	 */
	public function setEditTime( $edittime ) {
		$this->edittime = $edittime;
	}

	/**
	 * @return Time when draft was last modified
	 */
	public function getSaveTime() {
		return $this->savetime;
	}

	/**
	 * Sets time when draft was last modified
	 * @param $savetime String
	 */
	public function setSaveTime( $savetime ) {
		$this->savetime = $savetime;
	}

	/**
	 * @return Scroll position of editor when draft was last modified
	 */
	public function getScrollTop() {
		return $this->scrolltop;
	}

	/**
	 * Sets scroll position of editor when draft was last modified
	 * @param $scrolltop Integer
	 */
	public function setScrollTop( $scrolltop ) {
		$this->scrolltop = $scrolltop;
	}

	/**
	 * @return Text of draft version of article
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Sets text of draft version of article
	 * @param $text String
	 */
	public function setText( $text ) {
		$this->text = $text;
	}

	/**
	 * @return Summary of changes
	 */
	public function getSummary() {
		return $this->summary;
	}

	/**
	 * Sets summary of changes
	 * @param $summary String
	 */
	public function setSummary( $summary ) {
		$this->summary = $summary;
	}

	/**
	 * @return Whether edit is considdered to be a minor change
	 */
	public function getMinorEdit() {
		return $this->minoredit;
	}

	/**
	 * Sets whether edit is considdered to be a minor change
	 * @param boolean $minoredit
	 */
	public function setMinorEdit(
		$minoredit
	) {
		$this->minoredit = $minoredit;
	}

	/* Functions */

	/**
	 * Generic constructor
	 * @param $id Integer: [optional] ID to use
	 * @param $autoload Boolean: [optional] Whether to load from database
	 */
	public function __construct( $id = null, $autoload = true ) {
		// If an ID is a number the existence is actually checked on load
		// If an ID is false the existance is always false during load
		$this->id = $id;
		// Load automatically
		if ( $autoload ) {
			$this->load();
		}
	}

	/**
	 * Selects draft row from database and populates object properties
	 */
	private function load() {
		global $wgUser;
		// Checks if the ID of the draft was set
		if ( $this->id === null ) {
			// Exists immediately
			return;
		}
		// Gets database connection
		$dbw = wfGetDB( DB_MASTER );
		// Gets drafts for this article and user from database
		$result = $dbw->select( 'drafts',
			array( '*' ),
			array(
				'draft_id' => (int) $this->id,
				'draft_user' => (int) $wgUser->getID()
			),
			__METHOD__
		);
		// Checks if query returned any results
		if ( $result === false ) {
			// Exists immediately
			return;
		}
		// Fetches the row of the draft from the result
		$row = $dbw->fetchRow( $result );
		// Checks if the row is not an array or is an empty array
		if ( !is_array( $row ) || count( $row ) == 0 ) {
			// Exists immediately
			return;
		}
		// Synchronizes data
		$this->token = $row['draft_token'];
		$this->title = Title::makeTitle(
			$row['draft_namespace'], $row['draft_title']
		);
		$this->section = $row['draft_section'];
		$this->starttime = $row['draft_starttime'];
		$this->edittime = $row['draft_edittime'];
		$this->savetime = $row['draft_savetime'];
		$this->scrolltop = $row['draft_scrolltop'];
		$this->text = $row['draft_text'];
		$this->summary = $row['draft_summary'];
		$this->minoredit = $row['draft_minoredit'];
		// Updates state
		$this->exists = true;
	}

	/**
	 * Inserts or updates draft row in database
	 */
	public function save() {
		global $wgUser, $wgRequest;
		// Gets database connection
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		// Builds insert/update information
		$data = array(
			'draft_token' => (string) $this->getToken(),
			'draft_user' => (int) $wgUser->getID(),
			'draft_namespace' => (int) $this->title->getNamespace(),
			'draft_title' => (string) $this->title->getDBkey(),
			'draft_page' => (int) $this->title->getArticleId(),
			'draft_section' =>
				$this->section == '' ? null : (int) $this->section,
			'draft_starttime' => $dbw->timestamp( $this->starttime ),
			'draft_edittime' => $dbw->timestamp( $this->edittime ),
			'draft_savetime' => $dbw->timestamp( $this->savetime ),
			'draft_scrolltop' => (int) $this->scrolltop,
			'draft_text' => (string) $this->text,
			'draft_summary' => (string) $this->summary,
			'draft_minoredit' => (int) $this->minoredit
		);
		// Checks if draft already exists
		if ( $this->exists === true ) {
			// Updates draft information
			$dbw->update( 'drafts',
				$data,
				array(
					'draft_id' => (int) $this->id,
					'draft_user' => (int) $wgUser->getID()
				),
				__METHOD__
			);
		} else {
			// Gets a draft token exists for the current user and article
			$existingRow = $dbw->selectField( 'drafts', 'draft_token',
				array(
					'draft_user' => $data['draft_user'],
					'draft_namespace' => $data['draft_namespace'],
					'draft_title' => $data['draft_title'],
					'draft_token' => $data['draft_token']
				),
				__METHOD__
			);
			// Checks if token existed, meaning it has been used already for
			// this article
			if ( $existingRow === false ) {
				// Inserts row in the database
				$dbw->insert( 'drafts', $data, __METHOD__ );
				// Gets the id of the newly inserted row
				$this->id = $dbw->insertId();
				// Updates state
				$this->exists = true;
			}
		}
		// Commits any processed changes
		$dbw->commit();
		// Returns success
		return true;
	}

	/**
	 * Deletes draft row from database
	 * @param $user Integer: [optional] User ID, defaults to current user ID
	 */
	public function discard( $user = null ) {
		global $wgUser;
		// Uses $wgUser as a fallback
		$user = $user === null ? $wgUser : $user;
		// Gets database connection
		$dbw = wfGetDB( DB_MASTER );
		// Deletes draft from database verifying propper user to avoid hacking!
		$dbw->delete( 'drafts',
			array(
				'draft_id' => $this->id,
				'draft_user' =>  $user->getID()
			),
			__METHOD__
		);
		// Updates state
		$this->exists = false;
	}
}
