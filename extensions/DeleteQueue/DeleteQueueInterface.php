<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class DeleteQueueInterface {

	public static function formatReason( $reason1, $reason2 ) {
		if ( $reason1 && $reason2 && $reason1 != 'other' ) {
			return "$reason1: $reason2";
		} elseif ( $reason2 ) {
			return $reason2;
		} elseif ( $reason1 ) {
			return $reason1;
		} else {
			return false;
		}
	}

	/**
	 * Get a list of reasons for deletion nomination.
	 * @param $queue The queue to nominate to.
	 * @return A string formatted for Xml::listDropDown.
	 */
	public static function getReasonList( $queue ) {
		$list = wfMsgForContent( "deletequeue-$queue-reasons" );

		// Does a specific list exist?
		if ( $list && $list != '-' ) {
			return $list;
		}

		// Use the generic list
		$list = wfMsgForContent( "deletequeue-generic-reasons" );
		return $list;
	}
}
