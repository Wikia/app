<?php
/**
 * VideoUpload
 *
 * A VideoUpload extension for MediaWiki
 * Alows to upload video files to Longtail servers
 *
 * Special:VideoUploadHelper -> workaround
 * see http://www.longtailvideo.com/support/forums/bits-on-the-run/system-api/18401/handling-upload-response-in-js
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-03-01
 * @copyright Copyright (C) 2011 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/hacks/VideoUploadPrototype/Special_VideoUploadPrototype.php");
 * plus required
 *     include("$IP/extensions/wikia/YouTube/YouTube.php");
 */

class SpecialVideoUploadHelper extends UnlistedSpecialPage {
	/**
	 * Nothing surprising here
	 * @author Marooned
	 */
	public function __construct() {
		parent::__construct('VideoUploadHelper', 'videouploadhelper');
	}

	/**
	 * Add JS to invoke function in parent document indicating end of upload process
	 * @author Marooned
	 */
	function execute($par) {
		global $wgRequest, $wgOut, $wgJsMimeType;
		$this->setHeaders();
		$wgOut->setPageTitle('VideoUploadHelper');
		//we are in iframe
		$wgOut->allowClickjacking();

		$videoKey = $wgRequest->getVal('video_key');
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\">if (typeof top.VideoUpload != 'undefined') top.VideoUpload.uploadFinished('$videoKey');</script>\n");
	}
}