<?php
/**
 * Classes for Drafts extension
 *
 * @file
 * @ingroup Extensions
 */
 
// Draft Class
class Draft {
	
	/* Fields */

	private $_exists = false;
	private $_id;
	private $_token;
	private $_userID;
	private $_title;
	private $_section;
	private $_starttime;
	private $_edittime;
	private $_savetime;
	private $_scrolltop ;
	private $_text;
	private $_summary;
	private $_minoredit;

	/* Functions */

	public function __construct( $id = null, $autoload = true ) {
		// If an ID is a number the existence is actually checked on load
		// If an ID is false the existance is always false durring load
		$this->_id = $id;

		# Load automatically
		if ( $autoload ) {
			$this->load();
		}
	}

	private function load() {
		global $wgUser;
		
		// Verify the ID has been set
		if ( $this->_id === null ) {
			return;
		}
		
		// Get db connection
		$dbw = wfGetDB( DB_MASTER );

		// Select drafts from the database matching ID - can be 0 or 1 results
		$result = $dbw->select( 'drafts',
			array( '*' ),
			array(
				'draft_id' => (int) $this->_id,
				'draft_user' => (int) $wgUser->getID()
			),
			__METHOD__
		);
		if ( $result === false ) {
			return;
		}

		// Get the row
		$row = $dbw->fetchRow( $result );
		if ( !is_array( $row ) || count( $row ) == 0 ) {
			return;
		}

		// Synchronize data
		$this->_token = $row['draft_token'];
		$this->_title = Title::makeTitle( $row['draft_namespace'], $row['draft_title'] );
		$this->_section = $row['draft_section'];
		$this->_starttime = $row['draft_starttime'];
		$this->_edittime = $row['draft_edittime'];
		$this->_savetime = $row['draft_savetime'];
		$this->_scrolltop = $row['draft_scrolltop'];
		$this->_text = $row['draft_text'];
		$this->_summary = $row['draft_summary'];
		$this->_minoredit = $row['draft_minoredit'];

		// Update state
		$this->_exists = true;

		return;
	}

	public function save() {
		global $wgUser, $wgRequest;
	
		// Get db connection
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		
		// Build data
		$data = array(
			'draft_token' => (int) $this->getToken(),
			'draft_user' => (int) $wgUser->getID(),
			'draft_namespace' => (int) $this->_title->getNamespace(),
			'draft_title' => (string) $this->_title->getDBKey(),
			'draft_page' => (int) $this->_title->getArticleId(),
			'draft_section' => $this->_section == '' ? null : (int) $this->_section,
			'draft_starttime' => $dbw->timestamp( $this->_starttime ),
			'draft_edittime' => $dbw->timestamp( $this->_edittime ),
			'draft_savetime' => $dbw->timestamp( $this->_savetime ),
			'draft_scrolltop' => (int) $this->_scrolltop,
			'draft_text' => (string) $this->_text,
			'draft_summary' => (string) $this->_summary,
			'draft_minoredit' => (int) $this->_minoredit
		);

		// Save data
		if ( $this->_exists === true ) {
			$dbw->update( 'drafts',
				$data,
				array(
					'draft_id' => (int) $this->_id,
					'draft_user' => (int) $wgUser->getID()
				),
				__METHOD__
			);
		} else {
			$existingRow = $dbw->selectField( 'drafts', 'draft_token',
				array(
					'draft_namespace' => $data['draft_namespace'],
					'draft_title' => $data['draft_title'],
					'draft_user' => $data['draft_user'],
					'draft_token' => $data['draft_token']
				),
				__METHOD__
			);
			
			// Check if token has been used already for this article
			if ( $existingRow === false ) {
				$dbw->insert( 'drafts', $data, __METHOD__ );
				$this->_id = $dbw->insertId();
				// Update state
				$this->_exists = true;
			}
		}
		
		$dbw->commit();
		
		// Return success
		return true;
	}

	public function discard( $user = null ) {
		global $wgUser;
		
		// Use $wgUser as a fallback
		$user = $user === null ? $wgUser : $user;
		
		// Get db connection
		$dbw = wfGetDB( DB_MASTER );

		// Delete data
		$dbw->delete( 'drafts',
			array(
				'draft_id' => $this->_id,
				// FIXME: ID is already a primary key
				'draft_user' =>  $user->getID()
			),
			__METHOD__
		);

		$this->_exists = false;
	}
	
	public static function newFromID( $id, $autoload = true ) {
		return new Draft( $id, $autoload );
	}
	
	public static function newFromRow( $row ) {
		$draft = new Draft( $row['draft_id'], false );
		$draft->setToken( $row['draft_token'] );
		$draft->setTitle( Title::makeTitle( $row['draft_namespace'], $row['draft_title'] ) );
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
	
	public static function countDrafts( &$title = null, $userID = null ) {
		global $wgUser;
		
		Draft::cleanDrafts();
		
		// Get db connection
		$dbr = wfGetDB( DB_SLAVE );
		
		// Build where clause
		$where = array();
		if ( $title !== null ) {
			$where['draft_namespace'] = $title->getNamespace();
			$where['draft_title'] = $title->getDBKey();
		}
		if ( $userID !== null ) {
			$where['draft_user'] = $userID;
		} else {
			$where['draft_user'] = $wgUser->getID();
		}
		
		// Get a list of matching drafts
		return $dbr->selectField( 'drafts', 'count(*)', $where, __METHOD__ );
	}
	
	public static function cleanDrafts() {
		global $egDraftsLifeSpan;
		
		// Get db connection
		$dbw = wfGetDB( DB_MASTER );
		
		// Remove drafts that are more than $wgDraftsLifeSpan days old
		$cutoff = wfTimestamp( TS_UNIX ) - ( $egDraftsLifeSpan * 60 * 60 * 24 );
		$dbw->delete( 'drafts',
			array(
				'draft_savetime < ' . $dbw->addQuotes( $dbw->timestamp( $cutoff ) )
			),
			__METHOD__
		);
	}
	
	public static function getDrafts( $title = null, $userID = null ) {
		global $wgUser;
		
		Draft::cleanDrafts();
		
		// Get db connection
		$dbw = wfGetDB( DB_MASTER );
		
		// Build where clause
		$where = array();
		if ( $title !== null ) {
			$pageId = $title->getArticleId();
			if ( $pageId ) {
				$where['draft_page'] = $pageId;
			} else {
				$where['draft_page'] = 0; // page not created yet
				$where['draft_namespace'] = $title->getNamespace();
				$where['draft_title'] = $title->getDBKey();
			}
		}
		if ( $userID !== null ) {
			$where['draft_user'] = $userID;
		} else {
			$where['draft_user'] = $wgUser->getID();
		}
		
		// Create an array of matching drafts
		$drafts = array();
		$result = $dbw->select( 'drafts', '*', $where, __METHOD__ );
		if ( $result ) {
			while ( $row = $dbw->fetchRow( $result ) ) {
				// Add a new draft to the list from the row
				$drafts[] = Draft::newFromRow( $row );
			}
		}
		
		// Return array of matching drafts
		return count( $drafts ) ? $drafts : null;
	}
	
	public static function listDrafts( &$title = null, $user = null ) {
		global $wgOut, $wgRequest, $wgUser, $wgLang;
		
		// Get draftID
		$currentDraft = Draft::newFromID( $wgRequest->getIntOrNull( 'draft' ) );
		
		// Output HTML for list of drafts
		$drafts = Draft::getDrafts( $title, $user );
		if ( count( $drafts ) > 0 ) {
			// Internationalization
			wfLoadExtensionMessages( 'Drafts' );
			
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
					array(
						'align' => 'left',
						'width' => '75%',
						'nowrap' => 'nowrap'
					),
					wfMsg( 'drafts-view-article' )
				)
			);
			$wgOut->addHTML(
				Xml::element( 'th',
					array(
						'align' => 'left',
						'nowrap' => 'nowrap'
					),
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
				$urlLoad = $draft->getTitle()->getFullUrl( 'action=edit&draft=' . urlencode( $draft->getID() ) );
				
				// Build discard link
				$urlDiscard = sprintf( '%s?discard=%s&token=%s',
					SpecialPage::getTitleFor( 'Drafts' )->getFullUrl(),
					urlencode( $draft->getID() ),
					urlencode( $wgUser->editToken() )
				);
				// If in edit mode, return to editor
				if ( $wgRequest->getText( 'action' ) == 'edit' || $wgRequest->getText( 'action' ) == 'submit' ) {
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
					$urlDiscard .= '&section=' . urlencode( $draft->getSection() );
				}
				
				// Build XML
				$wgOut->addHTML( Xml::openElement( 'tr' ) );
				$wgOut->addHTML(
					Xml::openElement( 'td',
						array(
							'align' => 'left',
							'nowrap' => 'nowrap'
						)
					)
				);
				$wgOut->addHTML(
					Xml::element( 'a',
						array(
							'href' => $urlLoad,
							'style' => 'font-weight:' . ( $currentDraft->getID() == $draft->getID() ? 'bold' : 'normal' )
						),
						$htmlTitle
					)
				);
				$wgOut->addHTML( Xml::closeElement( 'td' ) );
				$wgOut->addHTML(
					Xml::element( 'td',
						array(
							'align' => 'left',
							'nowrap' => 'nowrap'
						),
						$wgLang->timeanddate( $draft->getSaveTime() )
					)
				);
				$wgOut->addHTML(
					Xml::openElement( 'td',
						array(
							'align' => 'left',
							'nowrap' => 'nowrap'
						)
					)
				);
				$wgOut->addHTML(
					Xml::element( 'a',
						array(
							'href' => $urlDiscard,
							'onclick' => "if( !wgAjaxSaveDraft.insync ) return confirm('" . Xml::escapeJsString( wfMsgHTML( 'drafts-view-warn' ) ) . "')"
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
	
	public static function newToken() {
		return wfGenerateToken();
	}
	
	/* States */
	public function exists() {
		return $this->_exists;
	}

	/* Properties */

	public function getID() {
		return $this->_id;
	}

	public function setToken( $token ) {
		$this->_token = $token;
	}
	public function getToken() {
		return $this->_token;
	}

	public function getUserID( $userID ) {
		$this->_userID = $userID;
	}
	public function setUserID() {
		return $this->_userID;
	}

	public function getTitle() {
		return $this->_title;
	}
	public function setTitle( $title ) {
		$this->_title = $title;
	}

	public function getSection() {
		return $this->_section;
	}
	public function setSection( $section ) {
		$this->_section = $section;
	}

	public function getStartTime() {
		return $this->_starttime;
	}
	public function setStartTime( $starttime ) {
		$this->_starttime = $starttime;
	}

	public function getEditTime() {
		return $this->_edittime;
	}
	public function setEditTime( $edittime ) {
		$this->_edittime = $edittime;
	}

	public function getSaveTime() {
		return $this->_savetime;
	}
	public function setSaveTime( $savetime ) {
		$this->_savetime = $savetime;
	}

	public function getScrollTop() {
		return $this->_scrolltop;
	}
	public function setScrollTop( $scrolltop ) {
		$this->_scrolltop = $scrolltop;
	}

	public function getText() {
		return $this->_text;
	}
	public function setText( $text ) {
		$this->_text = $text;
	}

	public function getSummary() {
		return $this->_summary;
	}
	public function setSummary( $summary ) {
		$this->_summary = $summary;
	}

	public function getMinorEdit() {
		return $this->_minoredit;
	}
	public function setMinorEdit( $minoredit ) {
		$this->_minoredit = $minoredit;
	}
}
