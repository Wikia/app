<?php

/**
 * A class that contains different views of the user interface for Flags.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Views;

use Flags\Models\FlagType;

class FlagView {

	const FLAGS_CSS_CLASS = 'portable-flags';
	const FLAGS_CSS_CLASS_INLINE = 'portable-flags-inline';

	public static $flagsTargetingCssClasses = [
		FlagType::FLAG_TARGETING_READERS => 'flags-targeting-readers',
		FlagType::FLAG_TARGETING_CONTRIBUTORS => 'flags-targeting-contributors',
	];

	/**
	 * Parses the wrapped wikitext and returns an HTML block of code with rendered flags.
	 * @param array $templateCalls
	 * @param $pageId
	 * @return ParserOutput
	 */
	public function renderFlags( Array $templateCalls, $pageId ) {
		global $wgUser;

		$wikitext = $this->wrapAllFlags( $templateCalls );
		$title = \Title::newFromID( $pageId );

		return \ParserPool::parse( $wikitext, $title, \ParserOptions::newFromUser( $wgUser ) );
	}

	/**
	 * Creates wikitext calls out of an array of names of templates and an array
	 * of matching params. The wikitext calls are wrapped in an HTML element that
	 * enables targeting control.
	 * @param $flagTypeId
	 * @param $flagView
	 * @param $params
	 * @return string
	 */
	public function wrapSingleFlag( $flagTypeId, $flagTargeting, $flagView, $params ) {
		if ( !isset( self::$flagsTargetingCssClasses[$flagTargeting] ) ) {
			$flagTargeting = FlagType::FLAG_TARGETING_READERS;
		}

		$viewCall = '{{' . $flagView;

		if ( !empty( $params ) ) {
			foreach ( $params as $paramName => $paramValue ) {
				$viewCall .= "|{$paramName}={$paramValue}";
			}
		}

		$viewCall .= "}}\n";

		return \Html::rawElement( 'div', [
			'class' => self::$flagsTargetingCssClasses[$flagTargeting],
			'data-type-id' => $flagTypeId,
		], $viewCall );
	}

	/**
	 * Wraps calls of notice templates in a div of a class portable-notices.
	 * @param array $templateCalls
	 * @return string
	 */
	public function wrapAllFlags( Array $templateCalls ) {
		return \Html::rawElement( 'div', [
			'class' => self::FLAGS_CSS_CLASS,
		], implode( '', $templateCalls ) );
	}
}
