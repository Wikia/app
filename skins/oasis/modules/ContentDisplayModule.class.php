<?php

class ContentDisplayModule extends Module {

	var $bodytext;

	/**
	 * Render picture attribution
	 *
	 * This method is called by MakeThumbLink2 hook
	 */
	static function renderPictureAttribution($skin, $title, $file, $frameParams, $handlerParams, &$s) {
		wfProfileIn(__METHOD__);

		// prevent fatal errors
		if (empty($file)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// get the name of the user who uploaded the file
		$userName = $file->getUser();

		// render avatar and link to user page
		$avatar = AvatarService::renderAvatar($userName, 16);
		$link = AvatarService::renderLink($userName);

		$html = Xml::openElement('div', array('class' => 'picture-attribution')) .
			$avatar .
			wfMsgForContent('oasis-content-picture-added-by', $link) .
			Xml::closeElement('div');

		// add it after the caption
		$s = substr($s, 0, -12) . $html . '</div></div>';

		#print_pre($html); print_pre(htmlspecialchars($s));

		wfProfileOut(__METHOD__);

		return true;
	}

	public function executeIndex() {
		global $wgBlankImgUrl;

		wfProfileIn(__METHOD__);

		#print_pre(htmlspecialchars($this->bodytext));

		// replace section edit links with buttons and change order of HTML nodes
		// TODO: consider moving to Parser / Linker
		// TODO: use DoEditSectionLink hook (?)
		$this->bodytext = preg_replace(
			'#<span class="editsection">\[<a([^>]+)>[^>]+</a>\]</span>(.*)</h#',
			'$2<a class="editsection wikia-chiclet-button"$1><img src="' . $wgBlankImgUrl . '" /></a></h',
			$this->bodytext);

		#print_pre(htmlspecialchars($this->bodytext));

		wfProfileOut(__METHOD__);
	}

}
