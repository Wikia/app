<?php
/**
 * Contains logic for special page Special:TranslationChanges.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright  Copyright © 2008-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implementation of Special:TranslationChanges special page. Gives an overview
 * per message group of translations in a given number of hours.
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialTranslationChanges extends SpecialPage {
	const MSG = 'translationchanges-';

	function __construct() {
		parent::__construct( 'TranslationChanges' );
	}

	/**
	 *Access point for this special page
	 */
	public function execute( $parameters ) {
		global $wgOut, $wgScriptPath, $wgJsMimeType, $wgStyleVersion, $wgRequest;

		$wgOut->addScript(
			Xml::openElement( 'script', array( 'type' => $wgJsMimeType, 'src' =>
			"$wgScriptPath/extensions/CleanChanges/cleanchanges.js?$wgStyleVersion" )
			) . '</script>'
		);

		$this->setHeaders();
		$this->hours = min( 168, $wgRequest->getInt( 'hours', 24 ) );

		$rows = TranslateUtils::translationChanges( $this->hours, true );
		$wgOut->addHTMl( $this->settingsForm() . $this->output( $rows ) );
	}

	/**
	 * GLOBALS: $wgScript
	 */
	protected function settingsForm() {
		global $wgScript;

		$limit = self::timeLimitSelector( $this->hours );
		$button = Xml::submitButton( wfMsg( TranslateUtils::MSG . 'submit' ) );

		$form = Xml::tags( 'form',
			array(
				'action' => $wgScript,
				'method' => 'get'
			),
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) . $limit . $button
		);
		return $form;
	}

	protected static function timeLimitSelector( $selected = 24 ) {
		$items = array( 3, 6, 12, 24, 48, 72, 168 );
		$selector = new HTMLSelector( 'hours', 'hours', $selected );
		foreach ( $items as $item ) $selector->addOption( $item );
		return $selector->getHTML();
	}

	/**
	 * Preprocesses changes.
	 */
	protected function sort( Array $rows ) {
		global $wgContLang;
		$sorted = array();
		$batch = new LinkBatch;
		foreach ( $rows as $row ) {
			list( $pieces, ) = explode( '/', $wgContLang->lcfirst( $row->rc_title ), 2 );

			$group = 'Unknown';
			$mg = TranslateUtils::messageKeyToGroup( $row->rc_namespace, $pieces );
			if ( !is_null( $mg ) ) $group = $mg;

			$lang = 'site';
			if ( strpos( $row->rc_title, '/' ) !== false ) {
				$lang = $row->lang;
			}

			switch ( $group ) {
				case 'core': $class = 'mediawiki'; break;
				case 'out-commonist': $class = 'commonist'; break;
				case 'out-freecol': $class = 'freecol'; break;
				case 'out-fudforum': $class = 'fudforum'; break;
				case 'out-mantis': $class = 'mantis'; break;
				case 'out-mwlibrl': $class = 'mwlibrl'; break;
				case 'out-nocc': $class = 'nocc'; break;
				case 'out-okawix': $class = 'okawix'; break;
				case 'out-openlayers': $class = 'openlayers'; break;
				case 'out-osm': $class = 'osm'; break;
				case 'out-voctrain': $class = 'voctrain'; break;
				case 'out-wikiblame': $class = 'wikiblame'; break;
				default: $class = 'extension'; break;
			}

			if ( $lang === 'site' ) {
				$class = 'site';
			}

			$sorted[$class][$group][$lang][] = $row;

			$batch->add( NS_USER, $row->rc_user_text );
			$batch->add( NS_USER_TALK, $row->rc_user_text );
			if ( $group !== 'core' ) {
			$batch->add( NS_MEDIAWIKI, $row->rc_title );
			}
			$batch->add( NS_MEDIAWIKI_TALK, $row->rc_title );
		}

		ksort( $sorted );

		if ( isset( $sorted['extension'] ) ) {
			ksort( $sorted['extension'] );
		}

		$batch->execute();
		return $sorted;
	}

	protected function output( Array $rows ) {
		$groupObjects = MessageGroups::singleton()->getGroups();

		global $wgLang, $wgUser;

		$index = -1;
		$output = '';
		$skin = $wgUser->getSkin();
		$userLang = $wgLang->getCode();

		$changes = $this->sort( $rows );
		foreach ( $changes as $groups ) {
			foreach ( $groups as $group => $languages ) {
				$label = $group;

				if ( isset( $groupObjects[$group] ) ) {
					$label = $groupObjects[$group]->getLabel();
				}

				$output .= Xml::element( 'h3', null, $label );

				$exportLabel = wfMsgHtml( self::MSG . 'export' );

				foreach ( $languages as $language => $rows ) {
					$index++;
					$rci = 'RCI' . $language . $index;
					$rcl = 'RCL' . $language . $index;
					$rcm = 'RCM' . $language . $index;
					$toggleLink = "javascript:toggleVisibilityE('$rci', '$rcm', '$rcl', 'block')";

					$rowTl =
					Xml::tags( 'span', array( 'id' => $rcm ),
						Xml::tags( 'a', array( 'href' => $toggleLink ), $this->sideArrow() ) ) .
					Xml::tags( 'span', array( 'id' => $rcl, 'style' => 'display: none;' ),
						Xml::tags( 'a', array( 'href' => $toggleLink ), $this->downArrow() ) );

					$nchanges = wfMsgExt(
						'nchanges',
						array( 'parsemag', 'escape' ),
						$wgLang->formatNum( count( $rows ) )
					);

					$titleText = SpecialPage::getTitleFor( 'Translate' );

					$export = $skin->link(
						$titleText,
						$exportLabel,
						array(),
						array(
							'task' => 'export-to-file',
							'language' => $language,
							'group' => $group
						)
					);

					$languageName = TranslateUtils::getLanguageName( $language, false, $userLang );
					if ( !$languageName ) {
						$languageName = $language;
					}

					$output .= Xml::tags( 'h4', null, "$rowTl $language <small>($languageName)</small> ($nchanges) ($export)" );
					$output .= Xml::openElement( 'ul',
						array( 'id' => $rci, 'style' => 'display: none' ) );

					foreach ( $rows as $row ) {
						$date = $wgLang->timeAndDate( $row->rc_timestamp, /* adj */ true, /* format */ true );
						$msg = wfMsgExt(
							self::MSG . 'change',
							array( 'parsemag', 'escape' ),
							$date,
							wfEscapeWikiText( $row->rc_title ),
							wfEscapeWikiText( $row->rc_user_text )
						);
						$output .= Xml::tags( 'li', null, $msg );
					}

					$output .= Xml::closeElement( 'ul' );
				}
			}
		}

		return $output;
	}

	/**
	 * GLOBALS: $wgLang
	 */
	private static function makeBlock( $tl, $lang, $rowCache, $rowId ) {
		$changes = count( $rowCache );
		$output = Xml::tags( 'h3', null, "$tl $lang ($changes)" );
		$output .= Xml::tags( 'ul',
			array( 'id' => $rowId, 'style' => 'display: none' ),
			implode( "\n", $rowCache )
		);

		return $output;
	}

	/**
	 * @todo Following are from ChangesList.php. Try to figure out some nice place
	 * to put them in so that they can be used easily.
	 */

	/**
	 * Generate HTML for an arrow or placeholder graphic
	 * @param $dir \string One of '', 'd', 'l', 'r'
	 * @param $alt \string Alt text
	 * @return string HTML \<img> tag
	 */
	private function arrow( $dir, $alt = '' ) {
		global $wgStylePath;
		$encUrl = htmlspecialchars( $wgStylePath . '/common/images/Arr_' . $dir . '.png' );
		$encAlt = htmlspecialchars( $alt );
		return "<img src=\"$encUrl\" width=\"12\" height=\"12\" alt=\"$encAlt\" />";
	}

	/**
	 * Generate HTML for a right- or left-facing arrow,
	 * depending on language direction.
	 * @return string HTML \<img> tag
	 */
	private function sideArrow() {
		global $wgContLang;
		$dir = $wgContLang->isRTL() ? 'l' : 'r';
		return $this->arrow( $dir, '+' );
	}

	/**
	 * Generate HTML for a down-facing arrow
	 * depending on language direction.
	 * return string HTML \<img> tag
	 */
	private function downArrow() {
		return $this->arrow( 'd', '-' );
	}
}
