<?php

class DeleteBatch extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'DeleteBatch'/*class*/, 'deletebatch'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		# Check permissions
		if ( !$wgUser->isAllowed( 'deletebatch' ) ) {
			$this->displayRestrictionError();
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		wfLoadExtensionMessages( 'DeleteBatch' );

		$wgOut->setPageTitle( wfMsg( 'deletebatch-title' ) );
		$cSF = new DeleteBatchForm( $par, $this->getTitle() );

		$action = $wgRequest->getVal( 'action' );
		if ( 'success' == $action ) {
			/* do something */
		} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
			$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$cSF->doSubmit();
		} else {
			$cSF->showForm();
		}
	}
}

/* the form for deleting pages */
class DeleteBatchForm {
	var $mUser, $mPage, $mFile, $mFileTemp;

	protected $title;

	/* constructor */
	function __construct( $par, $title ) {
		global $wgRequest;
		$this->title = $title;
		$this->mMode = $wgRequest->getText( 'wpMode' );
		$this->mPage = $wgRequest->getText( 'wpPage' );
		$this->mReason = $wgRequest->getText( 'wpReason' );
		$this->mFile = $wgRequest->getFileName( 'wpFile' );
		$this->mFileTemp = $wgRequest->getFileTempName( 'wpFile' );
	}

	/**
	 * Show the form for deleting pages
	 *
	 * @param $err Mixed: error message or null if there's no error
	 */
	function showForm( $errorMessage = false ) {
		global $wgOut, $wgUser, $wgScript;

		if ( $errorMessage ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->wrapWikiMsg( "<p class='error'>$1</p>\n", $errorMessage );
		}

		$wgOut->addWikiMsg( 'deletebatch-help' );

		$tabindex = 1;

		$rows = array(

		array(
			Xml::label( wfMsg( 'deletebatch-as' ), 'wpMode' ),
			$this->userSelect( 'wpMode', ++$tabindex )->getHtml()
		),
		array(
			Xml::label( wfMsg( 'deletebatch-page' ), 'wpPage' ),
			$this->pagelistInput( 'wpPage', ++$tabindex )
		),
		array(
			wfMsgExt( 'deletebatch-or', 'parseinline' ),
			'&#160;'
		),
		array(
			Xml::label( wfMsg( 'deletebatch-caption' ), 'wpFile' ),
			$this->fileInput( 'wpFile', ++$tabindex )
		),
		array(
			'&#160;',
			$this->submitButton( 'wpdeletebatchSubmit', ++$tabindex )
		)

		);

		$form =

		Xml::openElement( 'form', array(
			'name' => 'deletebatch',
			'enctype' => 'multipart/form-data',
			'method' => 'post',
			'action' => $this->title->getLocalUrl( array( 'action' => 'submit' ) ),
		) );

		$form .= '<table>';

		foreach( $rows as $row ) {
			list( $label, $input ) = $row;
			$form .= "<tr><td class='mw-label'>$label</td>";
			$form .= "<td class='mw-input'>$input</td></tr>";
		}

		$form .= '</table>';

		$form .= Xml::hidden( 'title', $this->title );
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$form .= '</form>';
		$wgOut->addHTML( $form );
	}

	function userSelect( $name, $tabindex ) {
		$options = array(
			wfMsg( 'deletebatch-select-script' ) => 'script',
			wfMsg( 'deletebatch-select-yourself' ) => 'you'
		);

		$select = new XmlSelect( $name, $name );
		$select->setDefault( $this->mMode );
		$select->setAttribute( 'tabindex', $tabindex );
		$select->addOptions( $options );
		return $select;
	}

	function pagelistInput( $name, $tabindex ) {
		$params = array(
			'tabindex' => $tabindex,
			'name' => $name,
			'id' => $name,
			'cols' => 40,
			'rows' => 10
		);

		return Xml::element( 'textarea', $params, $this->mPage, false );
	}

	function fileInput( $name, $tabindex ) {
		$params = array(
			'type' => 'file',
			'tabindex' => $tabindex,
			'name' => $name,
			'id' => $name,
			'value' => $this->mFile
		);

		return Xml::element( 'input', $params );
	}

	function submitButton( $name, $tabindex ) {
		$params = array(
			'tabindex' => $tabindex,
			'name' => $name,
		);

		return Xml::submitButton( wfMsg( 'deletebatch-delete' ), $params );
	}

	/* wraps up multi deletes */
	function deleteBatch( $user = false, $line = '', $filename = null ) {
		global $wgUser, $wgOut;

		/* first, check the file if given */
		if ( $filename ) {
			/* both a file and a given page? not too much? */
			if ( '' != $this->mPage ) {
				$this->showForm( 'deletebatch-both-modes' );
				return;
			}
			if ( "text/plain" != mime_content_type( $filename ) ) {
				$this->showForm( 'deletebatch-file-bad-format' );
				return;
			}
			$file = fopen( $filename, 'r' );
			if ( !$file ) {
				$this->showForm( 'deletebatch-file-missing' );
				return;
			}
		}
		/* switch user if necessary */
		$OldUser = $wgUser;
		if ( 'script' == $this->mMode ) {
			$username = 'Delete page script';
			$wgUser = User::newFromName( $username );
			/* Create the user if necessary */
			if ( !$wgUser->getID() ) {
				$wgUser->addToDatabase();
			}
		}

		/* todo run tests - run many tests */
		$dbw = wfGetDB( DB_MASTER );
		if ( $filename ) { /* if from filename, delete from filename */
			for ( $linenum = 1; !feof( $file ); $linenum++ ) {
				$line = trim( fgets( $file ) );
				if ( $line == false ) {
					break;
				}
				/* explode and give me a reason
				   the file should contain only "page title|reason"\n lines
				   the rest is trash
				*/
				$arr = explode( "|", $line );
				is_null( $arr[1] ) ? $reason = '' : $reason = $arr[1];
				$this->deletePage( $arr[0], $reason, $dbw, true, $linenum );
			}
		} else {
			/* run through text and do all like it should be */
			$lines = explode( "\n", $line );
			foreach ( $lines as $single_page ) {
				/* explode and give me a reason */
				$page_data = explode( "|", trim( $single_page ) );
				if ( count( $page_data ) < 2 )
					$page_data[1] = '';
				$result = $this->deletePage( $page_data[0], $page_data[1], $dbw, false, 0, $OldUser );
			}
		}

		/* restore user back */
		if ( 'script' == $this->mMode ) {
			$wgUser = $OldUser;
		}

		$sk = $wgUser->getSkin();
		$link_back = $sk->linkKnown( $this->title, wfMsgHtml( 'deletebatch-link-back' ) );
		$wgOut->addHTML( "<br /><b>" . $link_back . "</b>" );
	}

	/**
	 * Performs a single delete
	 * @$mode String - singular/multi
	 * @$linennum Integer - mostly for informational reasons
	 */
	function deletePage( $line, $reason = '', &$db, $multi = false, $linenum = 0, $user = null ) {
		global $wgOut, $wgUser;
		$page = Title::newFromText( $line );
			if ( is_null( $page ) ) { /* invalid title? */
				$wgOut->addWikiMsg( 'deletebatch-omitting-invalid', $line );
			if ( !$multi ) {
				if ( !is_null( $user ) ) {
					$wgUser = $user;
				}
			}
			return false;
		}
		if ( !$page->exists() ) { /* no such page? */
				$wgOut->addWikiMsg( 'deletebatch-omitting-nonexistant', $line );
			if ( !$multi ) {
				if ( !is_null( $user ) ) {
					$wgUser = $user;
				}
			}
			return false;
		}

		$db->begin();
		if ( NS_MEDIA == $page->getNamespace() ) {
			$page = Title::makeTitle( NS_FILE, $page->getDBkey() );
		}

		/* this stuff goes like articleFromTitle in Wiki.php */
		if ( $page->getNamespace() == NS_FILE ) {
			$art = new ImagePage( $page );
			/*this is absolutely required - creating a new ImagePage object does not automatically
			provide it with image  */
			$art->img = new Image( $art->mTitle );
		} else {
			$art = new Article( $page );
		}

		/* what is the generic reason for page deletion?
		   something about the content, I guess...
		*/
		$art->doDelete( $reason );
		$db->commit();
		return true;
	}

	/* on submit */
	function doSubmit() {
		global $wgOut;
		$wgOut->setPageTitle( wfMsg( 'deletebatch-title' ) );
		if ( !$this->mPage && !$this->mFileTemp ) {
			$this->showForm( 'deletebatch-no-page' );
			return;
		}
		if ( $this->mPage ) {
			$wgOut->setSubTitle( wfMsg( 'deletebatch-processing-from-form' ) );
		} else {
			$wgOut->setSubTitle( wfMsg( 'deletebatch-processing-from-file' ) );
		}
		$this->deleteBatch( $this->mUser, $this->mPage, $this->mFileTemp );
	}
}
