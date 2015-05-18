<?php

namespace Flags\Views;

class FlagView {
	const FLAGVIEW_LIMIT_MAGIC_WORD_INSTANCES = 1;

	public function createWikitextCall( $flagView, $params ) {
		$viewCall = '{{' . $flagView;

		if ( !empty( $params ) ) {
			foreach( $params as $paramName => $paramValue ) {
				$viewCall .= "|{$paramName}={$paramValue}";
			}
		}

		$viewCall .= "}}\n";

		return $viewCall;
	}
}
