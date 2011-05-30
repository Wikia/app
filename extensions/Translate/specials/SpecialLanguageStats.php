<?php
/**
 * Contains logic for special page Special:LanguageStats.
 *
 * @file
 * @author Siebrand Mazeland
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010 Siebrand Mazeland, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements includable special page Special:LanguageStats which provides
 * translation statistics for all defined message groups.
 *
 * Loosely based on the statistics code in phase3/maintenance/language
 *
 * Use {{Special:LanguageStats/nl/1}} to show for 'nl' and suppres completely
 * translated groups.
 *
 * @ingroup SpecialPage TranslateSpecialPage Stats
 */
class SpecialLanguageStats extends IncludableSpecialPage {
	function __construct() {
		parent::__construct( 'LanguageStats' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		$this->linker = $wgUser->getSkin();
		$this->translate = SpecialPage::getTitleFor( 'Translate' );

		$this->setHeaders();
		$this->outputHeader();

		TranslateUtils::addModules( $wgOut, 'ext.translate.special.languagestats' );
		TranslateUtils::addModules( $wgOut, 'ext.translate.messagetable' );

		// no UI when including()
		if ( !$this->including() ) {
			$code = $wgRequest->getVal( 'code', $par );
			$suppressComplete = $wgRequest->getVal( 'suppresscomplete', $par );
			$wgOut->addHTML( $this->buildLanguageForm( $code, $suppressComplete ) );
		} else {
			$paramArray = explode( '/', $par, 2 );
			$code = $paramArray[0];
			$suppressComplete = isset( $paramArray[1] ) && (bool)$paramArray[1];
		}

		if ( !$code ) {

			if ( $wgUser->isLoggedIn() ) {
				global $wgLang;

				$code = $wgLang->getCode();
			}
		}

		$out = '';

		if ( array_key_exists( $code, Language::getLanguageNames() ) ) {
			$out .= $this->getGroupStats( $code, $suppressComplete );
		} elseif ( $code ) {
			$wgOut->wrapWikiMsg( "<div class='error'>$1</div>", 'translate-page-no-such-language' );
		}

		$wgOut->addHTML( $out );
	}

	/**
	 * HTML for the top form.
	 * @param $code \string A language code (default empty, example: 'en').
	 * @param $suppressComplete \bool If completely translated groups should be suppressed (default: false).
	 * @return \string HTML
	 */
	function buildLanguageForm( $code = '', $suppressComplete = false ) {
		global $wgScript;

		$t = $this->getTitle();

		$out = Html::openElement( 'div', array( 'class' => 'languagecode' ) );
		$out .= Html::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) );
		$out .= Html::hidden( 'title', $t->getPrefixedText() );
		$out .= Html::openElement( 'fieldset' );
		$out .= Html::element( 'legend', null, wfMsg( 'translate-language-code' ) );
		$out .= Html::openElement( 'table', array( 'id' => 'langcodeselect', 'class' => 'allpages' ) );

		$out .= Html::openElement( 'tr' );
		$out .= Html::openElement( 'td', array( 'class' => 'mw-label' ) );
		$out .= Xml::label( wfMsg( 'translate-language-code-field-name' ), 'code' );
		$out .= Xml::closeElement( 'td' );
		$out .= Html::openElement( 'td', array( 'class' => 'mw-input' ) );
		$out .= Xml::input( 'code', 30, str_replace( '_', ' ', $code ), array( 'id' => 'code' ) );
		$out .= Xml::closeElement( 'td' );
		$out .= Xml::closeElement( 'tr' );

		$out .= Html::openElement( 'tr' );
		$out .= Html::openElement( 'td', array( 'colspan' => 2 ) );
		$out .= Xml::checkLabel( wfMsg( 'translate-suppress-complete' ), 'suppresscomplete', 'suppresscomplete', $suppressComplete );
		$out .= Xml::closeElement( 'td' );
		$out .= Xml::closeElement( 'tr' );

		$out .= Html::openElement( 'tr' );
		$out .= Html::openElement( 'td', array( 'class' => 'mw-input', 'colspan' => 2 ) );
		$out .= Xml::submitButton( wfMsg( 'allpagessubmit' ) );
		$out .= Xml::closeElement( 'td' );
		$out .= Xml::closeElement( 'tr' );

		$out .= Xml::closeElement( 'table' );
		$out .= Xml::closeElement( 'fieldset' );
		$out .= Xml::closeElement( 'form' );
		$out .= Xml::closeElement( 'div' );

		return $out;
	}

	/**
	 * Statistics table element (heading or regular cell)
	 *
	 * @todo document
	 * @param $in \string Element contents.
	 * @param $bgcolor \string Backround color in ABABAB format.
	 * @param $sort \string Value used for sorting.
	 * @return \string Html td element.
	 */
	function element( $in, $bgcolor = '', $sort = '' ) {
		$attributes = array();
		if ( $sort ) $attributes['data-sort-value'] = $sort;
		if ( $bgcolor ) $attributes['style'] = "background-color: #" . $bgcolor;

		$element = Html::element( 'td', $attributes, $in );
		return $element;
	}

	function getBackgroundColour( $subset, $total, $fuzzy = false ) {
		$v = @round( 255 * $subset / $total );

		if ( $fuzzy ) {
			// Weigh fuzzy with factor 20.
			$v = $v * 20;
			if ( $v > 255 ) $v = 255;
			$v = 255 - $v;
		}

		if ( $v < 128 ) {
			// Red to Yellow
			$red = 'FF';
			$green = sprintf( '%02X', 2 * $v );
		} else {
			// Yellow to Green
			$red = sprintf( '%02X', 2 * ( 255 - $v ) );
			$green = 'FF';
		}
		$blue = '00';

		return $red . $green . $blue;
	}

	function createHeader( $code ) {
		global $wgUser, $wgLang;

		$languageName = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
		$rcInLangLink = $wgUser->getSkin()->link(
			SpecialPage::getTitleFor( 'Recentchanges' ),
			wfMsgHtml( 'languagestats-recenttranslations' ),
			array(),
			array(
				'translations' => 'only',
				'trailer' => "/" . $code
			)
		);

		$out = wfMsgExt( 'languagestats-stats-for', array( 'parse', 'replaceafter' ), $languageName, $rcInLangLink );

		// Create table header
		$out .= Html::openElement(
			'table',
			array(
				'class' => "sortable wikitable mw-sp-translate-table"
			)
		);

		$out .= "\n\t" . Html::openElement( 'thead' );
		$out .= "\n\t" . Html::openElement( 'tr' );
		$out .= "\n\t\t" . Html::element( 'th', array( 'title' => self::newlineToWordSeparator( wfMsg( 'translate-page-group-tooltip' ) ) ), wfMsg( 'translate-page-group' ) );
		$out .= "\n\t\t" . Html::element( 'th', array( 'title' => self::newlineToWordSeparator( wfMsg( 'translate-total-tooltip' ) ) ), wfMsg( 'translate-total' ) );
		$out .= "\n\t\t" . Html::element( 'th', array( 'title' => self::newlineToWordSeparator( wfMsg( 'translate-untranslated-tooltip' ) ) ), wfMsg( 'translate-untranslated' ) );
		$out .= "\n\t\t" . Html::element( 'th', array( 'title' => self::newlineToWordSeparator( wfMsg( 'translate-percentage-complete-tooltip' ) ) ), wfMsg( 'translate-percentage-complete' ) );
		$out .= "\n\t\t" . Html::element( 'th', array( 'title' => self::newlineToWordSeparator( wfMsg( 'translate-percentage-fuzzy-tooltip' ) ) ), wfMsg( 'translate-percentage-fuzzy' ) );
		$out .= "\n\t" . Xml::closeElement( 'tr' );
		$out .= "\n\t" . Xml::closeElement( 'thead' );
		$out .= "\n\t" . Html::openElement( 'tbody' );

		return $out;
	}

	/**
	 * HTML for language statistics.
	 * Copied and adaped from groupStatistics.php by Nikerabbit
	 *
	 * @param $code \string A language code (default empty, example: 'en').
	 * @param $suppressComplete \bool If completely translated groups should be suppressed
	 * @return \string HTML
	 */
	function getGroupStats( $code, $suppressComplete = false ) {
		$this->code = $code;
		$this->suppressComplete = $suppressComplete;

		$out = '';

		$cache = new ArrayMemoryCache( 'groupstats' );
		$structure = MessageGroups::getGroupStructure();

		foreach ( $structure as $item ) {
			$out .= $this->makeGroupGroup( $item, $cache );
		}

		$cache->commit();

		if ( $out ) {
			$out = $this->createHeader( $code ) . "\n" . $out;
			$out .= Xml::closeElement( 'tbody' );
			$out .= Xml::closeElement( 'table' );
		} else {
			$out = wfMsgExt( 'translate-nothing-to-do', 'parse' );
		}

		return $out;
	}

	protected function makeGroupGroup( $item, $cache, $parent = '' ) {
		if ( !is_array( $item ) ) {
			return $this->makeGroupRow( $item, $cache, $parent === '' ? false : $parent );
		}

		$out = '';
		$top = array_shift( $item );
		$out .= $this->makeGroupRow( $top, $cache, $parent === '' ? true : $parent );
		foreach ( $item as $subgroup ) {
			$parents = trim( $parent . ' ' . $top->getId() );
			$out .= $this->makeGroupGroup( $subgroup, $cache, $parents );
		}
		return $out;
	}

	protected function makeGroupRow( $group, $cache, $parent = false ) {
		global $wgLang;

		$out = '';
		$code = $this->code;
		$suppressComplete = $this->suppressComplete;
		$g = $group;
		$groupName = $g->getId();
		// Do not report if this group is blacklisted.
		$groupId = $g->getId();
		$blacklisted = $this->isBlacklisted( $groupId, $code );

		if ( $blacklisted !== null ) {
			return '';
		}

		$fuzzy = $translated = $total = 0;

		if ( $g instanceof AggregateMessageGroup ) {
			foreach ( $g->getGroups() as $subgroup ) {
				$result = $this->loadPercentages( $cache, $subgroup, $code );
				$fuzzy += $result[0];
				$translated += $result[1];
				$total += $result[2];
			}
		} else {
			list( $fuzzy, $translated, $total ) = $this->loadPercentages( $cache, $g, $code );
		}

		if ( $total == 0 ) {
			$zero = serialize( $total );
			error_log( __METHOD__ . ": Group $groupName has zero message ($code): $zero" );
			return '';
		}

		// Skip if $suppressComplete and complete
		if ( $suppressComplete && !$fuzzy && $translated === $total ) {
			return '';
		}

		if ( $translated === $total ) {
			$extra = array( 'task' => 'reviewall' );
		} else {
			$extra = array();
		}

		$rowParams = array();
		$rowParams['data-groupid'] = $groupId;
		if ( is_string( $parent ) ) {
			$rowParams['data-parentgroups'] = $parent;
		} elseif ( $parent === true ) {
			$rowParams['data-ismeta'] = '1';
		}

		$out .= "\t" . Html::openElement( 'tr', $rowParams );
		$out .= "\n\t\t" . Html::rawElement( 'td', array(), $this->makeGroupLink( $g, $code, $extra ) );

		$out .= "\n\t\t" . Html::element( 'td',
			array( 'data-sort-value' => $total ),
			$wgLang->formatNum( $total ) );

		$out .= "\n\t\t" . Html::element( 'td',
			array( 'data-sort-value' => $total - $translated ),
			$wgLang->formatNum( $total - $translated ) );

		$out .= "\n\t\t" . $this->element( $this->formatPercentage( $translated / $total ),
			$this->getBackgroundColour( $translated, $total ),
			sprintf( '%1.3f', $translated / $total ) );

		$out .= "\n\t\t" . $this->element( $this->formatPercentage( $fuzzy / $total ),
			$this->getBackgroundColour( $fuzzy, $total, true ),
			sprintf( '%1.3f', $fuzzy / $total ) );

		$out .= "\n\t" . Xml::closeElement( 'tr' ) . "\n";
		return $out;
	}

	protected function loadPercentages( $cache, $group, $code ) {
		wfProfileIn( __METHOD__ );
		$id = $group->getId();


		$result = $cache->get( $id, $code );
		if ( is_array( $result ) ) {
			wfProfileOut( __METHOD__ );
			return $result;
		}

		// Initialise messages.
		$collection = $group->initCollection( $code );
		// Takes too much memory and only hides inconsistent import state
		# $collection->setInFile( $group->load( $code ) );
		$collection->filter( 'ignored' );
		$collection->filter( 'optional' );
		// Store the count of real messages for later calculation.
		$total = count( $collection );

		// Count fuzzy first.
		$collection->filter( 'fuzzy' );
		$fuzzy = $total - count( $collection );

		// Count the completed translations.
		$collection->filter( 'hastranslation', false );
		$translated = count( $collection );

		$result = array( $fuzzy, $translated, $total );

		$cache->set( $id, $code, $result );

		static $i = 0;
		if ( $i++ % 50 === 0 ) {
			$cache->commit();
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	protected function formatPercentage( $num ) {
		global $wgLang;
		$fmt = $wgLang->formatNum( number_format( round( 100 * $num, 2 ), 2 ) );
		return wfMsg( 'percent', $fmt );
	}

	protected function getGroupLabel( $group ) {
		$groupLabel = htmlspecialchars( $group->getLabel() );

		// Bold for meta groups.
		if ( $group->isMeta() ) {
			$groupLabel = Html::rawElement( 'b', null, $groupLabel );
		}

		return $groupLabel;
	}

	protected function makeGroupLink( $group, $code, $params ) {
		global $wgOut;

		$queryParameters = $params + array(
			'group' => $group->getId(),
			'language' => $code
		);

		$attributes = array(
			'title' => $this->getGroupDescription( $group )
		);

		$translateGroupLink = $this->linker->link(
			$this->translate, $this->getGroupLabel( $group ), $attributes, $queryParameters
		);

		return $translateGroupLink;
	}

	protected function getGroupDescription( $group ) {
		global $wgLang;

		$realFunction = array( 'MessageCache', 'singleton' );
		if ( is_callable( $realFunction ) ) {
			$cache = MessageCache::singleton();
		} else {
			global $wgMessageCache;
			$cache = $wgMessageCache;
		}
		return $cache->transform( $group->getDescription(), true, $wgLang, $this->getTitle() );
	}

	protected function isBlacklisted( $groupId, $code ) {
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

	/**
	 * Used to circumvent ugly tooltips when newlines are used in the
	 * message content ("x\ny" becomes "x y").
	 *
	 * @todo Name does not match behaviour.
	 * @todo Make this a static helper function somewhere?
	 */
	private static function newlineToWordSeparator( $text ) {
		$wordSeparator = wfMsg( 'word-separator' );

		$text = strtr( $text, array(
			"\n" => $wordSeparator,
			"\r" => $wordSeparator,
			"\t" => $wordSeparator,
		) );

		return $text;
	}
}
