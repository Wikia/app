<?php

/**
 * @author Piotr Molski <moli@wikia.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @copyright © 2007-2009, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 *
 */
if ( ! defined( 'MEDIAWIKI' ) ) {
    die();
}

$wgHooks['UploadComplete'][]  = 'UploadInfo::uploadComplete';

class UploadInfo {

	/**
	 * static method used in hook
	 *
	 *
	 * @access public
	 * @static
	 *
	 * @param UploadForm $uploadForm -- uploadForm object
	 */
	static public function uploadComplete( $uploadForm ) {
		if( !($uploadForm->getLocalFile() instanceof LocalFile) ) {
			return true;
		}

		$title = $uploadForm->getLocalFile()->getTitle();
		if( !($title instanceof Title) ) {
			return true;
		}

		wfProfileIn( __METHOD__ );

		$mTitle = $title->getText();
		$relPath = $uploadForm->getLocalFile()->getRel();
		$fullPath = $uploadForm->getLocalFile()->getPath();

		$aHistory = $uploadForm->getLocalFile()->getHistory(1);
		$oldPath = false;
		if ( isset($aHistory) && isset($aHistory[0]) ) {
			$oOldLocalFile = $aHistory[0];
			if ( isset($oOldLocalFile) && ($oOldLocalFile instanceof OldLocalFile) ) {
				$oldPath = $oOldLocalFile->getArchiveName();
			}
		}

		if ( !empty( $oldPath ) ) {
			$oldPath = sprintf("%s/%s", $uploadForm->getLocalFile()->getArchivePath(), $oldPath );
		}

		/**
		 * write log to database
		 */
		self::log( $title, $fullPath, $relPath, $oldPath, "u" /*action*/ );

		wfProfileOut( __METHOD__ );

		return true;
	}


	/**
	 * generic function when upload is not covered by hook.
	 *
	 * Whan called check before if $wgEnableUploadInfoExt is set to true
	 *
	 * @access public
	 * @static
	 *
	 * @param Title $title     -- where file was uploaded
	 * @param string $fullPath -- full path to image with root directory
	 * @param string $relPath  -- relative path to image without root directory
	 * @param string $oldPath  -- path to old version if file has new version
	 * @param string $action   -- action, default 'u' as upload, other possible
	 *    valuses are: m - move, r - remove
	 */
	static public function log( $title, $fullPath, $relPath = "", $oldPath = "", $action = "u" ) {
		global $wgWikiaDatacenter, $wgExternalDatawareDB, $wgCityId, $wgTitle;

		wfProfileIn( __METHOD__ );

		$datacenter = $wgWikiaDatacenter[ 0 ];

		if( !$title ) {
			$title   = $wgTitle;
		}
		$articleId = $title->getArticleId() || 0;


		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$dbw->begin();
		$dbw->insert(
			"upload_log",
			array(
				/** up_id is autoincrement **/
				"up_page_id"    => $articleId,
				"up_path"       => $fullPath,
				"up_imgpath"    => $relPath,
				"up_flags"      => 0,
				"up_title"      => $title->getText(),
				"up_created"    => wfTimestampNow(),
				"up_city_id"    => $wgCityId,
				"up_old_path"   => $oldPath,
				"up_datacenter" => $datacenter,
				"up_action"     => $action
			),
			__METHOD__
		);
		$dbw->commit();

		wfProfileOut( __METHOD__ );
	}
}
