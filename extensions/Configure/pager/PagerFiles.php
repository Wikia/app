<?php

/**
 * Class used to list versions at Special:ViewConfig when using a files handler
 *
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */
class ConfigurationPagerFiles implements ConfigurationPager {
	protected $mHandler, $mCallback, $mWiki = false;

	function __construct( ConfigureHandler $handler ) {
		$this->mHandler = $handler;
	}

	function setWiki( $wiki ) {
		$this->mWiki = $wiki;
	}

	function getVersionOptions() {
		$ret = array();
		if( $this->mWiki )
			$ret['wiki'] = $this->mWiki;
		return $ret;
	}

	function getBody() {
		$versions = $this->mHandler->getArchiveVersions( $this->getVersionOptions() );
		if ( empty( $versions ) ) {
			return wfMsgExt( 'configure-no-old', array( 'parse' ) );
		}

		$text = "<ul>\n";
		$count = 0;
		foreach ( $versions as $version => $meta ) {
			$count++;
			$wikis = array_keys( $this->mHandler->getOldSettings( $version ) );
			$info = array(
				'timestamp' => $version,
				'wikis' => $wikis,
				'count' => $count,
				'user_name' => isset( $meta['username'] ) ? $meta['username'] : '',
				'user_wiki' => isset( $meta['userwiki'] ) ? $meta['userwiki'] : '',
				'reason' => isset( $meta['reason'] ) ? $meta['reason'] : '',
			);
			$text .= $this->formatRow( $info );
		}
		$text .= "</ul>\n";
		return $text;
	}

	function getNumRows() {
		return count( $this->mHandler->listArchiveVersions( $this->getVersionOptions() ) );
	}

	function getNavigationBar() {
		return '';
	}

	function setFormatCallback( $callback ) {
		$this->mCallback = $callback;
	}

	function formatRow( $info ) {
		if ( !is_callable( $this->mCallback ) )
			throw new MWException( 'ConfigurationPagerFiles::$mCallback not callable' );
		return call_user_func( $this->mCallback, $info );
	}
}
