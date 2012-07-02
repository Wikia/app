<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * Allow users in the Bot group to edit many articles in one go by applying
 * regular expressions to a list of pages.
 *
 * @file
 * @ingroup SpecialPage
 *
 * @link http://www.mediawiki.org/wiki/Extension:MassEditRegex Documentation
 *
 * @author Adam Nielsen <malvineous@shikadi.net>
 * @copyright Copyright © 2009 Adam Nielsen
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Maximum number of pages/diffs to display when previewing the changes
define('MER_MAX_PREVIEW_DIFFS', 10);

// Maximum number of pages to edit *for each name in page list*.  No more than
// 500 (5000 for bots) is allowed according to MW API docs.
define('MER_MAX_EXECUTE_PAGES', 1000);

/** Main class that define a new special page*/
class MassEditRegex extends SpecialPage {
	private $aPageList;
	private $strPageListType;
	private $iNamespace;
	private $aMatch;
	private $aReplace;
	private $strReplace; // keep to avoid having to re-escape again
	private $strSummary;
	private $sk;

	function __construct() {
		parent::__construct( 'MassEditRegex', 'masseditregex' );
	}

	function execute( $par ) {
		global $wgUser, $wgRequest, $wgOut;

		$this->setHeaders();

		# Check permissions
		if ( !$wgUser->isAllowed( 'masseditregex' ) ) {
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

		$this->outputHeader();

		$strPageList = $wgRequest->getText( 'wpPageList', 'Sandbox' );
		$this->aPageList = explode("\n", trim($strPageList));
		$this->strPageListType = $wgRequest->getText( 'wpPageListType', 'pagenames' );

		$this->iNamespace = $wgRequest->getInt( 'namespace', NS_MAIN );

		$strMatch = $wgRequest->getText( 'wpMatch', '/hello (.*)\n/' );
		$this->aMatch = explode("\n", trim($strMatch));

		$this->strReplace = $wgRequest->getText( 'wpReplace', 'goodbye \1' );
		$this->aReplace = explode("\n", $this->strReplace);

		$this->strSummary = $wgRequest->getText( 'wpSummary', '' );

		$this->sk = $wgUser->getSkin();

		// Replace \n in the match with an actual newline (since a newline can't
		// be typed in, it'll act as the splitter for the next regex)
		foreach ( $this->aReplace as &$str ) {
			// Convert \n into a newline, \\n into \n, \\\n into \<newline>, etc.
			$str = preg_replace(
				array(
					'/(^|[^\\\\])((\\\\)*)(\2)\\\\n/',
					'/(^|[^\\\\])((\\\\)*)(\2)n/'
				), array(
					"\\1\\2\n",
					"\\1\\2n"
				), $str);
		}

		if ( $wgRequest->wasPosted() ) {
			if ($wgRequest->getCheck( 'wpPreview' ) ) {
				$this->showPreview();
			} elseif ( $wgRequest->getCheck('wpSave') ) {
				$this->perform();
			}
		} else {
			$this->showForm();
			$this->showHints();
		}

	}

	function showForm( $err = '' ) {
		global $wgOut;

		if ( $err ) {
			$wgOut->addHTML('<div class="wikierror">' . htmlspecialchars($err) . '</div>');
		}

		$wgOut->addWikiMsg( 'masseditregextext' );
		$titleObj = SpecialPage::getTitleFor( 'MassEditRegex' );

		$wgOut->addHTML(
			Xml::openElement('form', array(
				'id' => 'masseditregex',
				'method' => 'post',
				'action' => $titleObj->getLocalURL('action=submit')
			)) .
			Xml::element('p',
				null, wfMsg( 'masseditregex-pagelisttxt' )
			) .
			Xml::textarea(
				'wpPageList',
				join( "\n", $this->aPageList )
			) .
			Xml::namespaceSelector(
				$this->iNamespace, null, 'namespace', wfMsg( 'masseditregex-namespace-intro' )
			) .
			Xml::element('br') .
			Xml::element('span',
				null, wfMsg( 'masseditregex-listtype-intro' )
			) .
			Xml::openElement('ul', array(
				'style' => 'list-style: none' // don't want any bullets for radio btns
			))
		);

		// Generate HTML for the radio buttons (one for each list type)
		foreach (array('pagenames', 'pagename-prefixes', 'categories', 'backlinks')
			as $strValue)
		{
			// Have to use openElement because putting an Xml::xxx return value
			// inside an Xml::element causes the HTML code to be escaped and appear
			// on the page.
			$wgOut->addHTML(
				Xml::openElement('li') .
				Xml::radioLabel(
					wfMsg( 'masseditregex-listtype-' . $strValue ),
					'wpPageListType',
					$strValue,
					'masseditregex-radio-' . $strValue,
					$strValue == $this->strPageListType
				) .
				Xml::closeElement('li')
			);
		}
		$wgOut->addHTML(
			Xml::closeElement('ul') .

			// Display the textareas for the regex and replacement to go into

			// Can't use Xml::buildTable because we need to put code into the table
			Xml::openElement('table', array(
				'style' => 'width: 100%'
			)) .
				Xml::openElement('tr') .
					Xml::openElement('td') .
						Xml::element('p', null, wfMsg( 'masseditregex-matchtxt' )) .
						Xml::textarea(
							'wpMatch',
							join( "\n", $this->aMatch )
						) .
					Xml::closeElement('td') .
					Xml::openElement('td') .
						Xml::element('p', null, wfMsg( 'masseditregex-replacetxt' )) .
						Xml::textarea(
							'wpReplace',
							$this->strReplace  // use original value
						) .
					Xml::closeElement('td') .
					Xml::closeElement('tr') .
			Xml::closeElement('table') .

			Xml::openElement( 'div', array( 'class' => 'editOptions' ) ) .

			// Display the edit summary and preview

			Xml::tags( 'span',
				array(
					'class' => 'mw-summary',
					'id' => 'wpSummaryLabel'
				),
				Xml::tags( 'label', array(
					'for' => 'wpSummary'
				), wfMsg( 'summary' ) )
			) . ' ' .

			Xml::input( 'wpSummary',
				60,
				$this->strSummary,
				array(
					'id' => 'wpSummary',
					'maxlength' => '200',
					'tabindex' => '1'
				)
			) .

			Xml::tags( 'div',
				array( 'class' => 'mw-summary-preview' ),
				wfMsgExt( 'summary-preview', 'parseinline' ) .
					$this->sk->commentBlock( $this->strSummary )
			) .
			Xml::closeElement( 'div' ) . // class=editOptions

			// Display the preview + execute buttons

			Xml::element('input', array(
				'id'        => 'wpSave',
				'name'      => 'wpSave',
				'type'      => 'submit',
				'value'     => wfMsg( 'masseditregex-executebtn' ),
				'accesskey' => wfMsg( 'accesskey-save' ),
				'title'     => wfMsg( 'masseditregex-tooltip-execute' ).' ['.wfMsg( 'accesskey-save' ).']',
			)) .

			Xml::element('input', array(
				'id'        => 'wpPreview',
				'name'      => 'wpPreview',
				'type'      => 'submit',
				'value'     => wfMsg('showpreview'),
				'accesskey' => wfMsg('accesskey-preview'),
				'title'     => wfMsg( 'tooltip-preview' ).' ['.wfMsg( 'accesskey-preview' ).']',
			))

		);

		$wgOut->addHTML( Xml::closeElement('form') );
	}

	function showHints() {
		global $wgOut;

		$wgOut->addHTML(
			Xml::element( 'p', null, wfMsg( 'masseditregex-hint-intro' ) )
		);
		$wgOut->addHTML(Xml::buildTable(

			// Table rows (the hints)
			array(
				array(
					'/$/',
					'abc',
					wfMsg( 'masseditregex-hint-toappend' )
				),
				array(
					'/$/',
					'\\n[[Category:New]]',
					// Since we can't pass "rowspan=2" to the hint text above, we'll
					// have to display it again
					wfMsg( 'masseditregex-hint-toappend' )
				),
				array(
					'{{OldTemplate}}',
					'',
					wfMsg( 'masseditregex-hint-remove' )
				),
				array(
					'\\[\\[Category:[^]]+\]\]',
					'',
					wfMsg( 'masseditregex-hint-removecat' )
				)
			),

			// Table attributes
			array(
				'class' => 'wikitable'
			),

			// Table headings
			array(
				wfMsg( 'masseditregex-hint-headmatch' ), // really needs width 12em
				wfMsg( 'masseditregex-hint-headreplace' ), // really needs width 12em
				wfMsg( 'masseditregex-hint-headeffect' )
			)

		)); // Xml::buildTable

	}

	function showPreview() {
		$this->perform( false );
		return;
	}

	// Run a single request and return the page data
	function runRequest($aRequestVars)
	{
		$req = new FauxRequest( $aRequestVars, false );
		$processor = new ApiMain( $req, true );
		$processor->execute();
		$aPages = $processor->getResultData();
		if ( empty( $aPages ) ) return null; // no pages match the titles given
		return $aPages['query']['pages'];
	}

	// Run a bunch of requests (changing the $strValue parameter to each value
	// of $aValues in turn) and return the combined page data.
	function runMultiRequest($aRequestVars, $strVariable, $aValues, &$aErrors)
	{
		$aPageData = array();
		foreach ($aValues as $strValue) {
			$aRequestVars[$strVariable] = $strValue;
			$aMoreData = $this->runRequest($aRequestVars);
			if ($aMoreData)
				$aPageData = array_merge($aPageData, $aMoreData);
			else
				$aErrors[] = htmlspecialchars( wfMsg( 'masseditregex-exprnomatch', $strValue ) );
		}
		return $aPageData;
	}

	function getPages(&$aErrors, $iMaxPerCriterion) {
		global $wgContLang; // for mapping namespace numbers to localised name
		if ( !count( $this->aPageList ) ) return null;

		// Default vars for all page list types
		$aRequestVars = array(
			'action' => 'query',
			'prop' => 'info|revisions',
			'intoken' => 'edit',
			'rvprop' => 'content',
			//'rvlimit' => 1  // most recent revision only
		);
		switch ($this->strPageListType) {
			case 'pagenames': // Can do this in one hit
				$strNamespace = $wgContLang->getNsText($this->iNamespace) . ':';
				$aRequestVars['titles'] = $strNamespace . join( '|' . $strNamespace,
					$this->aPageList );
				return $this->runRequest($aRequestVars);

			case 'pagename-prefixes':
				$aRequestVars['generator'] = 'allpages';
				$aRequestVars['gapnamespace'] = $this->iNamespace;
				$aRequestVars['gaplimit'] = $iMaxPerCriterion;
				return $this->runMultiRequest($aRequestVars, 'gapprefix',
					$this->aPageList, $aErrors);

			case 'categories':
				$aRequestVars['generator'] = 'categorymembers';
				$aRequestVars['gcmlimit'] = $iMaxPerCriterion;

				// This generator must have "Category:" on the start of each category
				// name, so append it to all the pages we've been given if it's missing
				foreach ($this->aPageList as &$p)
					$p = Title::newFromText($p, NS_CATEGORY);

				$retVar = $this->runMultiRequest($aRequestVars, 'gcmtitle',
					$this->aPageList, $aErrors);

				// Remove all the 'Category:' prefixes again for consistency
				foreach ($this->aPageList as &$p) $p = $p->getText();
				return $retVar;

			case 'backlinks':
				$aRequestVars['generator'] = 'backlinks';
				$aRequestVars['gblnamespace'] = $this->iNamespace;
				$aRequestVars['gbllimit'] = $iMaxPerCriterion;
				return $this->runMultiRequest($aRequestVars, 'gbltitle',
					$this->aPageList, $aErrors);
		}
		return null;
	}

	public function regexCallback( $aMatches ) {
		$strFind = array();
		$strReplace = array();
		foreach ($aMatches as $i => $strMatch) {
			$aFind[] = '$' . $i;
			$aReplace[] = $strMatch;
		}
		return str_replace($aFind, $aReplace, $this->strNextReplace);
	}

	function perform( $bPerformEdits = true ) {
		global $wgRequest, $wgOut, $wgUser, $wgTitle, $wgLang;

		$iMaxPerCriterion = $bPerformEdits ? MER_MAX_EXECUTE_PAGES : MER_MAX_PREVIEW_DIFFS;
		$aErrors = array();
		$aPages = $this->getPages($aErrors, $iMaxPerCriterion);
		if ( $aPages === null ) {
			$this->showForm( wfMsg( 'masseditregex-err-nopages' ) );
			return;
		}

		// Show the form again ready for further editing if we're just previewing
		if (!$bPerformEdits) $this->showForm();

		$diff = new DifferenceEngine();
		$diff->showDiffStyle(); // send CSS link to the browser for diff colours

		$wgOut->addHTML( '<ul>' );

		if (count($aErrors))
			$wgOut->addHTML( '<li>' . join( '</li><li> ', $aErrors) . '</li>' );

		$htmlDiff = '';

		$editToken = $wgUser->editToken();

		$iArticleCount = 0;
		foreach ( $aPages as $p ) {
			$iArticleCount++;
			if ( !isset( $p['revisions'] ) ) {
				$wgOut->addHTML( '<li>'
					. wfMsg( 'masseditregex-page-not-exists', $p['title'] )
					. '</li>' );
				continue; // empty page
			}
			$curContent = $p['revisions'][0]['*'];
			$iCount = 0;
			$newContent = $curContent;
			foreach ($this->aMatch as $i => $strMatch) {
				$this->strNextReplace = $this->aReplace[$i];
				$result = @preg_replace_callback( $strMatch,
					array($this, 'regexCallback'), $newContent, -1, $iCount );
				if ($result !== null) $newContent = $result;
				else {
					$strErrorMsg = '<li>' . wfMsg( 'masseditregex-badregex' ) . ' <b>'
						. htmlspecialchars($strMatch) . '</b></li>';
					$wgOut->addHTML( $strErrorMsg );
					unset($this->aMatch[$i]);
				}
			}

			if ( $bPerformEdits ) {
				// Not in preview mode, make the edits
				$wgOut->addHTML( '<li>' . wfMsg( 'masseditregex-num-changes',
					$p['title'], $iCount ) . '</li>' );

				$req = new DerivativeRequest( $wgRequest, array(
					'action' => 'edit',
					'bot' => true,
					'title' => $p['title'],
					'summary' => $this->strSummary,
					'text' => $newContent,
					'basetimestamp' => $p['starttimestamp'],
					'watchlist' => 'nochange',
					'nocreate' => 1,
					'token' => $editToken,
				), true );
				$processor = new ApiMain( $req, true );
				try {
					$processor->execute();
				} catch ( UsageException $e ) {
					$wgOut->addHTML('<li><ul><li>' . wfMsg( 'masseditregex-editfailed')
						. ' ' . $e . '</li></ul></li>'
					);
				}
			} else {
				// In preview mode, display the first few diffs
				$diff->setText( $curContent, $newContent );
				$htmlDiff .= $diff->getDiff( '<b>' . $p['title'] . ' - '
					. wfMsg('masseditregex-before') . '</b>',
					'<b>' . wfMsg('masseditregex-after') . '</b>' );

				if ( $iArticleCount >= MER_MAX_PREVIEW_DIFFS ) {
					$htmlDiff .= Xml::element('p', null,
						wfMsg( 'masseditregex-max-preview-diffs',
							$wgLang->formatNum(MER_MAX_PREVIEW_DIFFS)
						)
					);
					break;
				}
			}

		}

		$wgOut->addHTML( '</ul>' );

		if ( $bPerformEdits ) {
			$wgOut->addWikiMsg( 'masseditregex-num-articles-changed', $iArticleCount );
			$wgOut->addHTML(
				$this->sk->makeKnownLinkObj(
					SpecialPage::getSafeTitleFor( 'Contributions', $wgUser->getName() ),
					wfMsgHtml( 'masseditregex-view-full-summary' )
				)
			);
		} else {
			// Only previewing, show the diffs now (after any errors)
			$wgOut->addHTML($htmlDiff);
		}
	}
}

