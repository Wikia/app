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
}
