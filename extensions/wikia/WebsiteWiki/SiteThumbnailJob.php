<?php

/**
 * SiteThumbnailJob -- create thumbnail for domain
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2010-03-15
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SiteThumbnailJob extends Job {

	private
		$mDomain,
		$mTargetUrl,
		$mParams,
		$mThumbnailer;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {

		global $wgContLang;

		parent::__construct( "SiteThumb", $title, $params, $id );

		/**
		 * init for local stuffs
		 */
		$this->mDomain      = $wgContLang->lc( $this->title->getDBKey() );
		$this->mTargetUrl   = sprintf( "http://%s/", $this->mDomain );
		$this->mParams      = $params;
		$this->mThumbnailer = dirname( __FILE__ ) . "/thumbnail.sh";
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgOut, $wgContLang, $wgTitle;

		/**
		 * overwrite $wgTitle
		 */
		$wgTitle = $this->title;
		$this->makeThumbnail();
	}

	/**
	 * create thumbnail for web site
	 */
	private function makeThumbnail() {
		global $wgEnableUploadInfoExt;

		wfProfileIn( __METHOD__ );

		$imagePath = NewWebsite::getThumbnailDirectory( $this->mDomain, 'png' ); ;

		/**
		 * create PNG
		 */
		$cmd = sprintf( "%s %s %s", $this->mThumbnailer, $this->mTargetUrl , $imagePath );
		Wikia::log( __METHOD__, "cmd", $cmd );

		$out = wfShellExec( $cmd, $result );
		if ( $result !== 0 ) {
			/**
			 * log error
			 */
			Wikia::log( __METHOD__, "error", $out );
		}

		if( $wgEnableUploadInfoExt ) {
			UploadInfo::log( $this->title, $imagePath, $imagePath );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}
}
