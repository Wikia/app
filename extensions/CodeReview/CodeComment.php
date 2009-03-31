<?php
if (!defined('MEDIAWIKI')) die();

class CodeComment {
	function __construct( $rev ) {
		$this->rev = $rev;
	}
	
	static function newFromRow( $rev, $row ) {
		return self::newFromData( $rev, get_object_vars( $row ) );
	}
	
	static function newFromData( $rev, $data ) {
		$comment = new CodeComment( $rev );
		$comment->id = intval($data['cc_id']);
		$comment->text = $data['cc_text']; // fixme
		$comment->user = $data['cc_user'];
		$comment->userText = $data['cc_user_text'];
		$comment->timestamp = wfTimestamp( TS_MW, $data['cc_timestamp'] );
		$comment->review = $data['cc_review'];
		$comment->sortkey = $data['cc_sortkey'];
		return $comment;
	}
	
	function threadDepth() {
		$timestamps = explode( ",", $this->sortkey );
		return count( $timestamps );
	}
}
