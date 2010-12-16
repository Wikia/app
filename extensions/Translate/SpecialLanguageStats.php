<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Implements a special page which givens translation statistics for a given
 * set of message groups. Message group names can be entered (pipe separated)
 * into the form, or added as a parameter in the URL.
 *
 * Loosely based on the statistics code in phase3/maintenance/language
 *
 * Use {{Special:LanguageStats/nl/1}} to show for 'nl' and suppres complete.
 *
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008 Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialLanguageStats extends IncludableSpecialPage {
	function __construct() {
		parent::__construct( 'LanguageStats' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;

		wfLoadExtensionMessages( 'Translate' );

		$this->setHeaders();
		$this->outputHeader();

		# no UI when including()
		if ( !$this->including() ) {
			$code = $wgRequest->getVal( 'code', $par );
			$suppressComplete = $wgRequest->getVal( 'suppresscomplete', $par );
			$wgOut->addHTML( $this->languageForm( $code, $suppressComplete ) );
		} else {
			$paramArray = explode( '/', $par, 2 );
			$code = $paramArray[0];
			$suppressComplete = isset( $paramArray[1] ) && (bool)$paramArray[1];
		}

		$out = '';

		if ( array_key_exists( $code, Language::getLanguageNames() ) ) {
			$out .= $this->getGroupStats( $code, $suppressComplete );
		} else if ( $code ) {
			$wgOut->addWikiMsg( 'translate-page-no-such-language' );
		}

		$wgOut->addHTML( $out );
	}

	/**
	* HTML for the top form
	* @param integer $code A language code (default empty, example: 'en').
	* @param bool $suppressComplete If completely translated groups should be suppressed
	* @return string HTML
	*/
	function languageForm( $code = '', $suppressComplete = false ) {
		global $wgScript;
		$t = $this->getTitle();

		$out  = Xml::openElement( 'div', array( 'class' => 'languagecode' ) );
		$out .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) );
		$out .= Xml::hidden( 'title', $t->getPrefixedText() );
		$out .= Xml::openElement( 'fieldset' );
		$out .= Xml::element( 'legend', null, wfMsg( 'translate-language-code' ) );
		$out .= Xml::openElement( 'table', array( 'id' => 'langcodeselect', 'class' => 'allpages' ) );
		$out .= "<tr>
				<td class='mw-label'>" .
				Xml::label( wfMsg( 'translate-language-code-field-name' ), 'code' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'code', 30, str_replace( '_', ' ', $code ), array( 'id' => 'code' ) ) .
				"</td></tr><tr><td colspan='2'>" .
				Xml::checkLabel( wfMsg( 'translate-suppress-complete' ), 'suppresscomplete', 'suppresscomplete', $suppressComplete ) .
				"</td>" .
			"</tr>" .
			"<tr>" .
				"<td class='mw-input'>" .
					Xml::submitButton( wfMsg( 'allpagessubmit' ) ) .
				"</td>
			</tr>";
		$out .= Xml::closeElement( 'table' );
		$out .= Xml::closeElement( 'fieldset' );
		$out .= Xml::closeElement( 'form' );
		$out .= Xml::closeElement( 'div' );
		return $out;
	}

	# Statistics table heading
	function heading() {
		return '<table class="sortable wikitable" border="2" cellpadding="4" cellspacing="0" style="background-color: #F9F9F9; border: 1px #AAAAAA solid; border-collapse: collapse; clear:both;" width="100%">' . "\n";
	}

	# Statistics table footer
	function footer() {
		return "</table>\n";
	}

	# Statistics table row start
	function blockstart() {
		return "\t<tr>\n";
	}

	# Statistics table row end
	function blockend() {
		return "\t</tr>\n";
	}

	# Statistics table element (heading or regular cell)
	function element( $in, $heading = false, $bgcolor = '' ) {
		if ( $heading ) {
			$element = '<th>' . $in . '</th>';
		} else if ( $bgcolor ) {
			$element = '<td bgcolor="#' . $bgcolor . '">' . $in . '</td>';
		} else {
			$element = '<td>' . $in . '</td>';
		}
		return "\t\t" . $element . "\n";
	}

	function getBackgroundColour( $subset, $total, $fuzzy = false ) {
		$v = @round( 255 * $subset / $total );

		if ( $fuzzy ) {
			# weigh fuzzy with factor 20
			$v = $v * 20;
			if ( $v > 255 ) $v = 255;
			$v = 255 - $v;
		}

		if ( $v < 128 ) {
			# Red to Yellow
			$red = 'FF';
			$green = sprintf( '%02X', 2 * $v );
		} else {
			# Yellow to Green
			$red = sprintf( '%02X', 2 * ( 255 - $v ) );
			$green = 'FF';
		}
		$blue = '00';

		return $red . $green . $blue;
	}

	function createHeader( $code ) {
		$out = '<!-- ' . $code . " -->\n";
		$out .= '<!-- ' . TranslateUtils::getLanguageName( $code, false ) . " -->\n";

		# Create table header
		$out .= $this->heading();
		$out .= $this->blockstart();
		$out .= $this->element( wfMsg( 'translate-page-group', true ) );
		$out .= $this->element( wfMsg( 'translate-total', true ) );
		$out .= $this->element( wfMsg( 'translate-untranslated', true ) );
		$out .= $this->element( wfMsg( 'translate-percentage-complete', true ) );
		$out .= $this->element( wfMsg( 'translate-percentage-fuzzy', true ) );
		$out .= $this->blockend();

		return $out;
	}

	/**
	 * HTML for language statistics
	 * Copied and adaped from groupStatistics.php by Nikerabbit
	 * @param integer $code A language code (default empty, example: 'en').
	 * @param bool $suppressComplete If completely translated groups should be suppressed
	 * @return string HTML
	 */
	function getGroupStats( $code, $suppressComplete = false ) {
		global $wgUser, $wgLang;

		$errorString = '&lt;error&gt;';
		$out = '';

		$cache = new ArrayMemoryCache( 'groupstats' );

		# Fetch groups stats have to be displayed for
		$groups = MessageGroups::singleton()->getGroups();
		# Get statistics for the message groups
		foreach ( $groups as $groupName => $g ) {
			// Do not report if this group is blacklisted.
			$groupId = $g->getId();
			$blacklisted = self::isBlacklisted( $groupId, $code );

			if ( $blacklisted !== null ) {
				continue;
			}

			$incache = $cache->get( $groupName, $code );
			if ( $incache !== false ) {
				list( $fuzzy, $translated, $total ) = $incache;
			} else {
				// Initialise messages
				$collection = $g->initCollection( $code );
				$collection->setInFile( $g->load( $code ) );
				$collection->filter( 'ignored' );
				$collection->filter( 'optional' );
				// Store the count of real messages for later calculation.
				$total = count( $collection );

				// Count fuzzy first
				$collection->filter( 'fuzzy' );
				$fuzzy = $total - count( $collection );

				// Count the completion percent
				$collection->filter( 'hastranslation', false );
				$translated = count( $collection );

				$cache->set( $groupName, $code, array( $fuzzy, $translated, $total ) );

			}

			// Skip if $suppressComplete and complete
			if ( $suppressComplete && !$fuzzy && $translated == $total ) {
				continue;
			}

			// Division by 0 should not be possible, but does occur. Caching issue?
			$translatedPercentage = $total ? $wgLang->formatNum( number_format( round( 100 * $translated / $total, 2 ), 2 ) ) : $errorString;
			$fuzzyPercentage = $total ? $wgLang->formatNum( number_format( round( 100 * $fuzzy / $total, 2 ), 2 ) ) : $errorString;

			if ( !wfEmptyMsg( 'percent', wfMsgNoTrans( 'percent' ) ) ) {
				$translatedPercentage = $translatedPercentage == $errorString ? $translatedPercentage : wfMsg( 'percent', $translatedPercentage );
				$fuzzyPercentage = $fuzzyPercentage == $errorString ? $fuzzyPercentage : wfMsg( 'percent', $fuzzyPercentage );
			} else {
				// For 1.14 compatability
				$translatedPercentage = "$translatedPercentage%";
				$fuzzyPercentage = "$fuzzyPercentage%";
			}

			$translateTitle = SpecialPage::getTitleFor( 'Translate' );
			$queryParameters = array(
				'group' => $groupId,
				'language' => $code
			);

			$translateGroupLink = $wgUser->getSkin()->link(
				$translateTitle,
				$g->getLabel(),
				array(),
				$queryParameters
			);

			$out .= $this->blockstart();
			$out .= $this->element( $translateGroupLink );
			$out .= $this->element( $total );
			$out .= $this->element( $total - $translated );
			$out .= $this->element( $translatedPercentage, false, $translatedPercentage == $errorString ? '' : $this->getBackgroundColour( $translated, $total ) );
			$out .= $this->element( $fuzzyPercentage, false, $translatedPercentage == $errorString ? '' : $this->getBackgroundColour( $fuzzy, $total, true ) );
			$out .= $this->blockend();
		}

		if ( $out ) {
			$out = $this->createHeader( $code ) . $out;
			$out .= $this->footer();
		} else {
			$out = wfMsgExt( 'translate-nothing-to-do', 'parse' );
		}

		return $out;
	}

	private function isBlacklisted( $groupId, $code ) {
		global $wgTranslateBlacklist;

		$blacklisted = null;

		$checks = array(
			$groupId,
			strtok( $groupId, '-' ),
			'*'
		);

		foreach ( $checks as $check ) {
			$blacklisted = @$wgTranslateBlacklist[$check][$code];

			if ( $blacklisted !== null ) {
				break;
			}
		}

		return $blacklisted;
	}
}
