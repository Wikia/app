<?php

/**
 * This class generates a paginated log of recent changes to banner messages (the parts that get
 * translated). We use the rencentchanges table since it is lightweight, however, this means that
 * the log only goes back 30 days.
 */
class CentralNoticePageLogPager extends ReverseChronologicalPager {
	var $viewPage, $special, $logType;

	/**
	 * Construct instance of class.
	 * @param $special object calling object
	 * @param $type string type of log - 'bannercontent' or 'bannermessages' (optional)
	 */
	function __construct( $special, $type = 'bannercontent' ) {
		$this->special = $special;
		parent::__construct();

		$this->viewPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'view' );
		$this->logType = $type;
	}

	/**
	 * Sort the log list by timestamp
	 */
	function getIndexField() {
		return 'rc_timestamp';
	}

	/**
	 * Pull log entries from the database
	 */
	function getQueryInfo() {
		$conds = array(
				'rc_bot' => 1, // include bot edits (all edits made by CentralNotice are bot edits)
				'rc_namespace' => 8, // only MediaWiki pages
		);
		if ( $this->logType == 'bannercontent' ) {
			// Add query contitions for banner content log
			$conds += array(
				"rc_title LIKE 'Centralnotice-template-%'", // get banner content
			);
		} else {
			// Add query contitions for banner messages log
			$conds += array(
				"rc_title LIKE 'Centralnotice-%'", // get banner messages
				"rc_title NOT LIKE 'Centralnotice-template-%'", // exclude normal banner content
			);
		}
		return array(
			'tables' => array( 'recentchanges' ),
			'fields' => '*',
			'conds' => $conds, // WHERE conditions
		);
	}

	/**
	 * Generate the content of each table row (1 row = 1 log entry)
	 */
	function formatRow( $row ) {
		global $wgLang;
		// Create a user object so we can pull the name, user page, etc.
		$loggedUser = User::newFromId( $row->rc_user );
		// Create the user page link
		$userLink = $this->getSkin()->makeLinkObj( $loggedUser->getUserPage(),
			$loggedUser->getName() );
		$userTalkLink = $this->getSkin()->makeLinkObj( $loggedUser->getTalkPage(),
			wfMsg ( 'centralnotice-talk-link' ) );

		$language = 'en'; // English is the default for CentralNotice messages

		if ( $this->logType == 'bannercontent' ) {
			// Extract the banner name from the title
			$pattern = '/Centralnotice-template-(.*)/';
			preg_match( $pattern, $row->rc_title, $matches );
			$banner = $matches[1];
		} elseif ( $this->logType == 'bannermessages' ) {
			// Split the title into banner, message, and language
			$titlePieces = explode( "/", $row->rc_title, 2 );
			$titleBase = $titlePieces[0];
			if ( array_key_exists( 1, $titlePieces ) ) $language = $titlePieces[1];
			$pattern = '/Centralnotice-([^-]*)-(.*)/';
			preg_match( $pattern, $titleBase, $matches );
			$banner = $matches[1];
			$message = $matches[2];
		}

		// Create banner link
		$bannerLink = $this->getSkin()->makeLinkObj( $this->viewPage,
			htmlspecialchars( $banner ),
			'template=' . urlencode( $banner ) );

		// Create title object
		$title = Title::newFromText( "MediaWiki:{$row->rc_title}" );

		if ( $this->logType == 'bannercontent' ) {
			// If the banner was just created, show a link to the banner. If the banner was
			// edited, show a link to the banner and a link to the diff.
			if ( $row->rc_new ) {
				$bannerCell = $bannerLink;
			} else {
				$querydiff = array(
					'curid' => $row->rc_cur_id,
					'diff' => $row->rc_this_oldid,
					'oldid' => $row->rc_last_oldid
				);
				$diffUrl = htmlspecialchars( $title->getLinkUrl( $querydiff ) );
				// Should "diff" be localized? It appears not to be elsewhere in the interface.
				// See ChangesList->preCacheMessages() for example.
				$bannerCell = $bannerLink . "&nbsp;(<a href=\"$diffUrl\">diff</a>)";
			}
		} elseif ( $this->logType == 'bannermessages' ) {
			$bannerCell = $bannerLink;

			// Create the message link
			$messageLink = $this->getSkin()->makeLinkObj( $title, htmlspecialchars( $message ) );

			// If the message was just created, show a link to the message. If the message was
			// edited, show a link to the message and a link to the diff.
			if ( $row->rc_new ) {
				$messageCell = $messageLink;
			} else {
				$querydiff = array(
					'curid' => $row->rc_cur_id,
					'diff' => $row->rc_this_oldid,
					'oldid' => $row->rc_last_oldid
				);
				$diffUrl = htmlspecialchars( $title->getLinkUrl( $querydiff ) );
				// Should "diff" be localized? It appears not to be elsewhere in the interface.
				// See ChangesList->preCacheMessages() for example.
				$messageCell = $messageLink . "&nbsp;(<a href=\"$diffUrl\">diff</a>)";
			}
		}

		// Begin log entry primary row
		$htmlOut = Xml::openElement( 'tr' );

		$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top' ) );
		$htmlOut .= Xml::closeElement( 'td' );
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$wgLang->date( $row->rc_timestamp ) . ' ' . $wgLang->time( $row->rc_timestamp )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			wfMsg ( 'centralnotice-user-links', $userLink, $userTalkLink )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$bannerCell
		);
		if ( $this->logType == 'bannermessages' ) {
			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
				$messageCell
			);
			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
				$language
			);
		}
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);

		// End log entry primary row
		$htmlOut .= Xml::closeElement( 'tr' );

		return $htmlOut;
	}

	function getStartBody() {
		$htmlOut = '';
		$htmlOut .= Xml::openElement( 'table', array( 'id' => 'cn-campaign-logs', 'cellpadding' => 3 ) );
		$htmlOut .= Xml::openElement( 'tr' );
		$htmlOut .= Xml::element( 'th', array( 'style' => 'width: 20px;' ) );
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 130px;' ),
			 wfMsg ( 'centralnotice-timestamp' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
			 wfMsg ( 'centralnotice-user' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
			 wfMsg ( 'centralnotice-banner' )
		);
		if ( $this->logType == 'bannermessages' ) {
			$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
				wfMsg ( 'centralnotice-message' )
			);
			$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 100px;' ),
				wfMsg ( 'centralnotice-language' )
			);
		}
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);
		$htmlOut .= Xml::closeElement( 'tr' );
		return $htmlOut;
	}

	/**
	 * Close table
	 */
	function getEndBody() {
		$htmlOut = '';
		$htmlOut .= Xml::closeElement( 'table' );
		return $htmlOut;
	}

}
