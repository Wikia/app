<?php

/**
 * Class used to list versions at Special:ViewConfig when using a database
 * handler
 *
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */
class ConfigurationPagerDb extends ReverseChronologicalPager implements ConfigurationPager {
	protected $mHandler, $mCallback, $mCounter = 0, $mWiki = false;

	function __construct( ConfigureHandlerDb $handler ) {
		parent::__construct();
		$this->mHandler = $handler;
		$this->mDb = $handler->getSlaveDB();
	}

	function setWiki( $wiki ) {
		$this->mWiki = $wiki;
	}

	function getQueryInfo() {
		$conds = array();
		if( $this->mWiki ) {
			$conds['cv_wiki'] = $this->mWiki;
		}

		return array(
			'tables'  => array( 'config_version' ),
			'fields'  => array( '*' ),
			'conds'   => $conds,
			'options' => array()
		);
	}

	function getIndexField() {
		return 'cv_timestamp';
	}

	function setFormatCallback( $callback ) {
		$this->mCallback = $callback;
	}

	function formatRow( $row ) {
		if ( !is_callable( $this->mCallback ) )
			throw new MWException( 'ConfigurationPagerDb::$mCallback not callable' );
		$this->mCounter++;
		$info = array(
			'timestamp' => $row->cv_timestamp,
			'wikis' => array( $row->cv_wiki ),
			'count' => $this->mCounter,
			'user_name' => isset( $row->cv_user_text ) ? $row->cv_user_text : '',
			'user_wiki' => isset( $row->cv_user_wiki ) ? $row->cv_user_wiki : '',
			'reason' => isset( $row->cv_reason ) ? $row->cv_reason : '',
		);
		return call_user_func( $this->mCallback, $info );
	}

	function getStartBody() {
		return "<ul>\n";
	}

	function getEndBody() {
		return "</ul>\n";
	}
}
