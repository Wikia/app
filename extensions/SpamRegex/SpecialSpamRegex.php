<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined( 'MEDIAWIKI' ) )
	die();

class SpamRegex extends SpecialPage {

	/**
	* Constructor
	*/
	function __construct() {
		parent::__construct( 'SpamRegex', 'spamregex' );
		wfLoadExtensionMessages( 'SpamRegex' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if ( !$wgUser->isAllowed( 'spamregex' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$wgOut->setPageTitle( wfMsgHtml( 'spamregex-page-title' ) );
		$sRF = new spamRegexForm( $par );
		$sRL = new spamRegexList( $par );

		$action = $wgRequest->getVal( 'action' );
		if ( 'success_block' == $action ) {
			$sRF->showSuccess();
			$sRF->showForm('');
		} else if ( 'success_unblock' == $action ) {
			$sRL->showSuccess();
			$sRF->showForm('');
		} else if ( 'failure_unblock' == $action ) {
			$text = htmlspecialchars( $wgRequest->getVal( 'text' ) );
			$sRF->showForm( wfMsg( 'spamregex-error-unblocking', $text ) );
		} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
			$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$sRF->doSubmit();
		} else if ( 'delete' == $action ) {
			$sRL->deleteFromList();
		} else {
			$sRF->showForm( '' );
		}
		$sRL->showList( '' );
	}
}

/* the list of blocked phrases */
class spamRegexList {
	var $mRegexUnblockedAddress;
	var $numResults = 0;

	/* constructor */
	function regexBlockList ( $par ) {
	}

	/* wrapper for GET values */
	public static function getListBits() {
		global $wgRequest;
		$pieces = array();
		list( $limit, $offset ) = $wgRequest->getLimitOffset();
		$pieces[] = 'limit=' . $limit;
		$pieces[] = 'offset=' . $offset;
		$bits = implode( '&', $pieces );
		return $bits;
	}

	/* useful for cleaning the memcached keys */
	public static function unsetKeys() {
		global $wgMemc;
		$wgMemc->delete( wfSpamRegexCacheKey( 'spamRegexCore', 'spamRegex', 'Textbox' ) );
		$wgMemc->delete( wfSpamRegexCacheKey( 'spamRegexCore', 'spamRegex', 'Summary' ) );
		$wgMemc->delete( wfSpamRegexCacheKey( 'spamRegexCore', 'numResults' ) );
	}

	/**
	 * Output list of blocked expressions
	 *
	 * @param $err string: error message
	 */
	function showList( $err ) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgRequest, $wgLang;

		/* on error, display error */
		if ( "" != $err ) {
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}

		$wgOut->addWikiMsg( 'spamregex-currently-blocked' );
		/* get data and play with data */
		if ( !$this->fetchNumResults() ) {
			$wgOut->addWikiMsg( 'spamregex-no-currently-blocked' );
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$titleObj = SpecialPage::getTitleFor( 'SpamRegex' );
			$action = $titleObj->escapeLocalURL( self::getListBits() );
			$action_unblock = $titleObj->escapeLocalURL( 'action=delete&'.self::getListBits() );
			list( $limit, $offset ) = $wgRequest->getLimitOffset();

			$this->showPrevNext( $wgOut );
			$wgOut->addHTML( "<form name=\"spamregexlist\" method=\"get\" action=\"{$action}\">" );

			$res = $dbr->select( 'spam_regex', '*', array(), __METHOD__, array( 'LIMIT' => $limit, 'OFFSET' => $offset ) );
			while ( $row = $res->fetchObject() ) {
				$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $row->spam_timestamp ), true );
				$ublock_ip = urlencode($row->spam_text);
				$desc = '';
				if ( $row->spam_textbox == 1 ) {
					$desc .= wfMsg( 'spamregex-text' );
				}
				if ( $row->spam_summary == 1 ) {
					if ( $row->spam_textbox == 1 ) {
						$desc .= " ";
					}
					$desc .= wfMsg( 'spamregex-summary-log' );
				}
				$wgOut->addHTML( "<ul>" );
				$wgOut->addWikiText( wfMsg( 'spamregex-log-1', $row->spam_text, $desc, $action_unblock, $ublock_ip ) . $row->spam_user . wfMsg( 'spamregex-log-2', $time ) );
				$wgOut->addHTML( "</ul>" );
			}
			$res->free();
			$wgOut->addHTML( "</form>" );
			$this->showPrevNext( $wgOut );
		}
		wfProfileOut( __METHOD__ );
	}

	/* remove from list - without confirmation */
	function deleteFromList() {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgRequest, $wgUser;
		$text = urldecode( $wgRequest->getVal( 'text' ) );
		/* delete */
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'spam_regex', array( 'spam_text' => $text ), __METHOD__ );
		$titleObj = SpecialPage::getTitleFor( 'SpamRegex' );
		if ( $dbw->affectedRows() ) {
			/* success  */
			self::unsetKeys();
			wfProfileOut( __METHOD__ );
			$wgOut->redirect( $titleObj->getFullURL( 'action=success_unblock&text='.urlencode($text).'&'.self::getListBits() ) );
		} else {
			wfProfileOut( __METHOD__ );
			$wgOut->redirect( $titleObj->getFullURL( 'action=failure_unblock&text='.urlencode($text).'&'.self::getListBits() ) );
		}
	}

	/**
	 * fetch number of all rows
	 * Use memcached if possible
	 */
	function fetchNumResults() {
		wfProfileIn( __METHOD__ );
		global $wgMemc;

		/* we use memcached here */
		$key = wfSpamRegexCacheKey( 'spamRegexCore', 'numResults' );
		$cached = $wgMemc->get( $key );
		$results = 0;
		if ( is_null( $cached ) || $cached === false ) {
			$dbr = wfGetDB( DB_SLAVE );
			$results = $dbr->selectField( 'spam_regex', 'COUNT(*)', '', __METHOD__ );
			$wgMemc->set( $key, $results, SPAMREGEX_EXPIRE );
		} else {
			$results = $cached;
		}
		$this->numResults = $results;
		wfProfileOut( __METHOD__ );
		return $results;
	}

	/**
	 * Validate the given regex
	 * This was originally the SimplifiedRegex extension
	 *
	 * @param $text Regex to be validated
	 * @return False if exceptions were found, otherwise true
	 */
	static function validateRegex( $text ) {
		try {
			$test = @preg_match("/{$text}/", 'Whatever');
			if( !is_int($test) ) {
				throw new Exception("error!");
			}
		}
		catch( Exception $e ) {
			return false;
		}
		return true;
	}

	/* draws one option for select */
	function makeOption( $blocker, $current ) {
		global $wgOut;
		if ( $blocker == $current ) {
			$wgOut->addHTML( "<option selected=\"selected\" value=\"{$blocker}\">{$blocker}</option>" );
		} else {
			$wgOut->addHTML( "<option value=\"{$blocker}\">{$blocker}</option>" );
		}
	}

	/* on success */
	function showSuccess() {
		global $wgOut, $wgRequest;
		$wgOut->setPageTitle( wfMsg( 'spamregex-page-title-1' ) );
		$wgOut->setSubTitle( wfMsg( 'spamregex-unblock-success' ) );
		$wgOut->addWikiMsg( 'spamregex-unblock-message', $wgRequest->getVal( 'text' ) );
	}

	/* init for showprevnext */
	function showPrevNext( &$out ) {
		global $wgContLang, $wgRequest;
		list( $limit, $offset ) = $wgRequest->getLimitOffset();
		$html = wfViewPrevNext(
				$offset,
				$limit,
				$wgContLang->specialpage( 'SpamRegex' ),
				'',
				($this->numResults - $offset) <= $limit
			);
		$out->addHTML( '<p>' . $html . '</p>' );
	}
}

/* the form for blocking phrases */
class spamRegexForm {
	var $mBlockedPhrase;
	var $mBlockedText;
	var $mBlockedSummary;

	/* constructor */
	function spamRegexForm( $par ) {
		global $wgRequest;
		$this->mBlockedPhrase = $wgRequest->getVal( 'wpBlockedPhrase',  $wgRequest->getVal( 'text', $par ) );
		$this->mBlockedTextbox = $wgRequest->getCheck( 'wpBlockedTextbox' ) ? 1 : 0;
		$this->mBlockedSummary = $wgRequest->getCheck( 'wpBlockedSummary' ) ? 1 : 0;
	}

	/* output */
	function showForm( $err ) {
		global $wgOut, $wgUser, $wgRequest;

		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = SpecialPage::getTitleFor( 'SpamRegex' );
		$action = $titleObj->escapeLocalURL( "action=submit&".spamRegexList::getListBits() );

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}

		$wgOut->addWikiMsg( 'spamregex-intro' );

		if( 'submit' == $wgRequest->getVal( 'action' ) )
			$scBlockedPhrase = htmlspecialchars( $this->mBlockedPhrase );
		else
			$scBlockedPhrase = '';

		$wgOut->addScript("
			<script type=\"text/javascript\">
				function SpamRegexEnhanceControls() {
					var SRTextboxControl = document.getElementById('wpBlockedTextbox');
					var SRSummaryControl = document.getElementById('wpBlockedSummary');

					SRTextboxControl.onclick = function () {
						if (!SRTextboxControl.checked) {
							if (!SRSummaryControl.checked) {
								SRSummaryControl.checked = true;
							}
						}
					}

					SRSummaryControl.onclick = function () {
						if (!SRSummaryControl.checked) {
							if (!SRTextboxControl.checked) {
								SRTextboxControl.checked = true;
							}
						}
					}
				}

				addOnloadHook (SpamRegexEnhanceControls);
			</script>"
		);
		$phraseblock = wfMsgExt( 'spamregex-phrase-block', array( 'parseinline' ) );
		$phraseblocktext = wfMsgExt( 'spamregex-phrase-block-text', array( 'parseinline' ) );
		$phraseblocksummary = wfMsgExt( 'spamregex-phrase-block-summary', array( 'parseinline' ) );
		$blockphrase = wfMsgExt('spamregex-block-submit', array( 'escapenoentities' ) );
		$wgOut->addHTML("
<form name=\"spamregex\" method=\"post\" action=\"{$action}\">
	<table border=\"0\">
		<tr>
			<td align=\"right\">{$phraseblock}</td>
			<td align=\"left\">
				<input tabindex=\"1\" name=\"wpBlockedPhrase\" value=\"{$scBlockedPhrase}\" />
			</td>
		</tr>
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
			<input type=\"checkbox\" tabindex=\"2\" name=\"wpBlockedTextbox\" id=\"wpBlockedTextbox\" value=\"1\" checked=\"checked\" />
			<label for=\"wpBlockedTextbox\">{$phraseblocktext}</label>
			</td>
		</tr>
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
			<input type=\"checkbox\" tabindex=\"3\" name=\"wpBlockedSummary\" id=\"wpBlockedSummary\" value=\"1\" />
			<label for=\"wpBlockedSummary\">{$phraseblocksummary}</label>
			</td>
		</tr>
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
				<input tabindex=\"4\" name=\"wpSpamRegexBlockedSubmit\" type=\"submit\" value=\"{$blockphrase}\" />
			</td>
		</tr>
	</table>
	<input type='hidden' name='wpEditToken' value=\"{$token}\" />
</form>");
	}

	/* on success */
	function showSuccess() {
		global $wgOut, $wgRequest;
		$wgOut->setPageTitle( wfMsg( 'spamregex-page-title-2' ) );
		$wgOut->setSubTitle( wfMsg( 'spamregex-block-success' ) );

		$wgOut->addWikiMsg('spamregex-block-message', $this->mBlockedPhrase);
	}

	/* on submit */
	function doSubmit() {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgUser, $wgMemc;

		/* empty name */
		if ( strlen($this->mBlockedPhrase) == 0 ) {
			$this->showForm( wfMsgHtml( 'spamregex-warning-1' ) );
			wfProfileOut( __METHOD__ );
			return;
		}
		/* validate expression */
		if ( !$simple_regex = spamRegexList::validateRegex( $this->mBlockedPhrase ) ) {
			$this->showForm( wfMsgHtml( 'spamregex-error-1' ) );
			wfProfileOut( __METHOD__ );
			return;
		}

		/* make insert */
		$dbw = wfGetDB( DB_MASTER );
		$name = $wgUser->getName();
		$timestamp = wfTimestampNow();

		/* we need at least one block mode specified... we can have them both, of course */
		if ( !$this->mBlockedTextbox && !$this->mBlockedSummary ) {
			$this->showForm( wfMsgHtml( 'spamregex-warning-2' ) );
			wfProfileOut( __METHOD__ );
			return;
		}

		$dbw->insert(
			'spam_regex',
				array(
				'spam_text' => $this->mBlockedPhrase,
				'spam_timestamp' => $timestamp,
				'spam_user' => $name,
				'spam_textbox' => $this->mBlockedTextbox,
				'spam_summary' => $this->mBlockedSummary
			),
			__METHOD__,
			array( 'IGNORE' )
		);

		/* duplicate entry */
		if ( !$dbw->affectedRows() ) {
			$this->showForm( wfMsgHtml( 'spamregex-already-blocked', $this->mBlockedPhrase ) );
			wfProfileOut( __METHOD__ );
			return;
		}
		spamRegexList::unsetKeys();
		/* redirect */
		$titleObj = SpecialPage::getTitleFor( 'SpamRegex' );
		wfProfileOut( __METHOD__ );
		$wgOut->redirect( $titleObj->getFullURL( 'action=success_block&text=' .urlencode( $this->mBlockedPhrase ).'&'.spamRegexList::getListBits() ) );
	}
}