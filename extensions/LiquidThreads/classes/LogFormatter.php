<?php

// Contains formatter functions for all log entry types.
class LqtLogFormatter {
	static function formatLogEntry( $type, $action, $title, $sk, $parameters ) {
		switch( $action ) {
			case 'merge':
				if ( $parameters[0] ) {
					$msg = 'lqt-log-action-merge-across';
				} else {
					$msg = 'lqt-log-action-merge-down';
				}
				break;
			default:
				$msg = 'lqt-log-action-' . $action;
				break;
		}

		$options = array( 'parseinline' );

		$forIRC = $sk === null;

		if ( $forIRC ) {
			global $wgContLang;
			$options['language'] = $wgContLang->getCode();
		}

		$replacements = array_merge( array( $title->getPrefixedText() ), $parameters );

		$html = wfMsgExt( $msg, $options, $replacements );

		if ( $forIRC ) {
			$html = StringUtils::delimiterReplace( '<', '>', '', $html );
		}

		return $html;
	}
}
