<?php

/**
 * A class that contains different views of the user interface for Flags.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Views;

class FlagView {
	const FLAGVIEW_LIMIT_MAGIC_WORD_INSTANCES = 1;
	const FLAGVIEW_WIKITEXT_WRAP_OPEN = '<div class="portable-notices">';
	const FLAGVIEW_WIKITEXT_WRAP_CLOSE = '</div>';

	/**
	 * Creates wikitext calls out of an array of names of templates and an array
	 * of matching params.
	 * @param $flagView
	 * @param $params
	 * @return string
	 */
	public function createWikitextCall( $flagView, $params ) {
		$viewCall = '{{' . $flagView;

		if ( !empty( $params ) ) {
			foreach ( $params as $paramName => $paramValue ) {
				$viewCall .= "|{$paramName}={$paramValue}";
			}
		}

		$viewCall .= "}}\n";

		return $viewCall;
	}

	/**
	 * Wraps calls of notice templates in a div of a class portable-notices.
	 * @param array $templateCalls
	 * @return string
	 */
	public function wrapTemplateCalls( Array $templateCalls ) {
		return \Xml::element( 'div', [
			'class' => 'portable-notices'
		], implode( '', $templateCalls ) );
	}
}
