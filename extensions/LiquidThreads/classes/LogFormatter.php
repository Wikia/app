<?php

// Contains formatter functions for all log entry types.
class LqtLogFormatter {
	protected static function isForIRC( ) {
		// FIXME this is a horrific hack, but it's better than spewing HTML in the wrong
		//  language to IRC.
		return in_string( '/LogPage::addEntry/', wfGetAllCallers() );
	}

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

		$forIRC = self::isForIRC();

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
