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
		if( !$this->including() ) {
			$code = $wgRequest->getVal( 'code', $par );
			$suppressComplete = $wgRequest->getVal( 'suppresscomplete', $par );
			$wgOut->addHTML( $this->languageForm( $code, $suppressComplete ) );
		} else {
			$paramArray = explode( '/', $par, 2 );
			$code = $paramArray[0];
			$suppressComplete = isset( $paramArray[1] ) && (bool)$paramArray[1];
		}

		$out = '';

		if( array_key_exists( $code, Language::getLanguageNames() ) ) {
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
					Xml::input( 'code', 30, str_replace('_',' ',$code), array( 'id' => 'code' ) ) .
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
		if( $heading ) {
			$element = '<th>' . $in . '</th>';
		} else if ( $bgcolor ) {
			$element = '<td bgcolor="#' . $bgcolor . '">' . $in . '</td>';
		} else {
			$element = '<td>' . $in . '</td>';
		}
		return "\t\t" . $element . "\n";
	}

	function getGroups() {
		$groups = wfMsgForContent( 'translate-languagestats-groups' );

		if( $groups ) {
			// Make the group names clean
			// Should contain one valid group name per line
			// All invalid group names should be ignored
			// Return all group names if there are no valid group names at all
			// FIXME: implement the above here
			$cleanGroups = '';

			if( $cleanGroups ) {
				return $cleanGroups;
			}
		}

		return MessageGroups::singleton()->getGroups();
	}

	function getBackgroundColour( $subset, $total, $fuzzy = false ) {
		$v = @round(255 * $subset / $total);

		if ( $fuzzy ) {
			# weigh fuzzy with factor 20
			$v = $v * 20;
			if( $v > 255 ) $v = 255;
			$v = 255 - $v;
		}

		if ( $v < 128 ) {
			# Red to Yellow
			$red = 'FF';
			$green = sprintf( '%02X', 2 * $v );
		} else {
			# Yellow to Green
			$red = sprintf('%02X', 2 * ( 255 - $v ) );
			$green = 'FF';
		}
		$blue = '00';

		return $red . $green . $blue;
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

		$out = '';

		# FIXME: provide some sensible header for what is being displayed.
		$out .= '<!-- ' . $code . " -->\n";
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

		# Fetch groups stats have to be displayed for
		$groups = $this->getGroups();

		# Get statistics for the message groups
		foreach ( $groups as $g ) {

			// Initialise messages
			$collection = $g->initCollection( $code );
			$collection->filter( 'optional' );
			// Store the count of real messages for later calculation.
			$total = count( $collection );

			// Fill translations in for counting
			$g->fillCollection( $collection );

			// Count fuzzy first
			$collection->filter( 'fuzzy' );
			$fuzzy = $total - count( $collection );

			// Count the completion percent
			$collection->filter( 'translated', false );
			$translated = count( $collection );

			// FIXME: avoid division by 0. Should not happen, but core-mostused has this on Windows at the moment
			if( !$total ) {
				continue;
			}

			// Skip if $suppressComplete and complete
			if( $suppressComplete && !$fuzzy && $translated == $total ) {
				continue;
			}

			$translatedPercentage = wfMsg( 'percent', $wgLang->formatNum( round( 100 * $translated / $total, 2 ) ) );
			$fuzzyPercentage = wfMsg( 'percent', $wgLang->formatNum( round( 100 * $fuzzy / $total, 2 ) ) );

			$translateTitle = SpecialPage::getTitleFor( 'Translate' );
			$pageParameters = "group=" . $g->getId() . "&language=" . $code;
			$translateGroupLink = $wgUser->getSkin()->makeKnownLinkObj( $translateTitle, $g->getLabel(), $pageParameters );

			$out .= $this->blockstart();
			$out .= $this->element( $translateGroupLink );
			$out .= $this->element( $total );
			$out .= $this->element( $total - $translated );
			$out .= $this->element( $translatedPercentage, false, $this->getBackgroundColour( $translated, $total ) );
			$out .= $this->element( $fuzzyPercentage, false, $this->getBackgroundColour( $fuzzy, $total, true ) );
			$out .= $this->blockend();
		}

		$out .= $this->footer();

		return $out;
	}
}
