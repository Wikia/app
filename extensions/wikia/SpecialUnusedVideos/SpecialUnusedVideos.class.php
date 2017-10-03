<?php

/**
 * A special page that lists unused videos
 * @ingroup SpecialPage
 */
class SpecialUnusedVideos extends ImageQueryPage {
	function __construct( $name = 'UnusedVideos' ) {
		parent::__construct( $name );
	}

	function isExpensive() {
		return true;
	}

	function sortDescending() {
		return false;
	}

	function isSyndicated() {
		return false;
	}

	function getQueryInfo() {
		$retval = array (
			'tables' => array (
				'image',
				'imagelinks'
			),
			'fields' => array (
				"'" . NS_FILE . "' AS namespace",
				'img_name AS title',
				'img_timestamp AS value',
				'img_user', 'img_user_text',
				'img_description'
			),
			'conds' => array ( 
				'il_to IS NULL',
				"img_media_type = 'VIDEO'",
			),
			'join_conds' => array (
				'imagelinks' => array ( 'LEFT JOIN', 'il_to = img_name' )
			)
		);

		return $retval;
	}

	function reallyDoQuery( $limit, $offset = false ) {
		$result = parent::reallyDoQuery( $limit, $offset );

		foreach ( $result as $row ) {
			$row->img_user_text = User::getUsername( $row->img_user, $row->img_user_text );
		}

		$result->rewind();

		return $result;
	}

	function usesTimestamps() {
		return true;
	}

	function getPageHeader() {
		return wfMsgExt( 'unusedvideostext', array( 'parse' ) );
	}

}
