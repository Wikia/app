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

class VideoUploadAjax {
	/**
	 * Return HTML for video upload dialog
	 * @author Marooned
	 */
	static public function getEditorDialog() {
		global $wgExtensionMessagesFiles, $wgTitle, $wgRequest, $wgExtensionsPath, $wgStylePath;

		wfProfileIn(__METHOD__);

		// render dialog
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'wgExtensionsPath' => $wgExtensionsPath,
			'wgStylePath' => $wgStylePath
		));
		$html = $template->render('editorDialog');

		$result = array(
			'html' => $html
		);

		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * Ask for key/token and upload URL
	 * @author Marooned
	 */
	static public function getDataForUpload() {
		global $wgRequest;

		wfProfileIn(__METHOD__);

		$title = $wgRequest->getVal('videoTitle');
		$tags = $wgRequest->getVal('tags');
		$description = $wgRequest->getVal('description');

		$longtail = new LongtailVideoClient();
		$result = $longtail->videos_create($title, $tags, $description);

		if (is_array($result['link'])) {
			$postUrl = $result['link']['protocol'] . '://' . $result['link']['address'] . $result['link']['path'];
			$postUrl .= '?api_format=py';
			$postUrl .= '&key=' . $result['link']['query']['key'];
			$postUrl .= '&token=' . $result['link']['query']['token'];
			$postUrl .= '&redirect_address=' . SpecialPage::getTitleFor('VideoUploadHelper')->getFullURL();

			$result = array(
				'success' => true,
				'postUrl' => $postUrl,
				'token' => $result['link']['query']['token']
			);
		} else {
			$result = array(
				'success' => false,
				'errorMsg' => 'TODO: add some error message'
			);
		}

		wfProfileOut(__METHOD__);
		return $result;
	}
}