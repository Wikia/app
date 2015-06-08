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

	public static $flagsTargetingCssClasses = [
		FlagType::FLAG_TARGETING_READERS => 'flags-targeting-readers',
		FlagType::FLAG_TARGETING_CONTRIBUTORS => 'flags-targeting-contributors',
	];

	/**
	 * Creates wikitext calls out of an array of names of templates and an array
	 * of matching params. The wikitext calls are wrapped in an HTML element that
	 * enables targeting control.
	 * @param $flagView
	 * @param $params
	 * @return string
	 */
	public function wrapSingleFlag( $flagTargeting, $flagView, $params ) {
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
			'class' => self::$flagsTargetingCssClasses[$flagTargeting]
		], $viewCall );
	}

	/**
	 * Wraps calls of notice templates in a div of a class portable-notices.
	 * @param array $templateCalls
	 * @return string
	 */
	public function wrapAllFlags( Array $templateCalls ) {
		return \Html::rawElement( 'div', [
			'class' => 'portable-flags',
		], implode( '', $templateCalls ) );
	}
}
