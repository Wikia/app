<?php
/**
 * VideoUpload
 *
 * A VideoUpload extension for MediaWiki
 * Alows to upload video files to Longtail servers
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

class VideoUploadHelper {
	/**
	 * Load extension's JS on edit page
	 * @author Marooned
	 */
	static public function setupEditPage($editform) {
		global $wgOut, $wgExtensionsPath, $wgJsMimeType;

		wfProfileIn(__METHOD__);

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/hacks/VideoUploadPrototype/js/VideoUpload.js\"></script>\n");

		// load message for MW toolbar button tooltip
//		global $wgHooks;
//		$wgHooks['MakeGlobalVariablesScript'][] = 'VideoUploadHelper::makeGlobalVariablesScript';

		wfProfileOut(__METHOD__);

		return true;
	}
}