<?php
/**
 * Renders page content: adds picture attribution info and replaces section edit links with pencil icon and link
 *
 * @author Maciej Brencz
 */

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
			wfMsg('oasis-content-picture-added-by', $link) .
			Xml::closeElement('div');

		// add it after the caption
		$s = substr($s, 0, -12) . $html . '</div></div>';

		#print_pre($html); print_pre(htmlspecialchars($s));

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Show section edit link for anons (RT #79897)
	 */
	static function onShowEditLink(&$parser, &$showEditLink) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		if ($wgUser->isAnon() && $parser->mOptions->getEditSection()) {
			$showEditLink = true;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function executeIndex() {
		global $wgBlankImgUrl, $wgTitle, $wgUser;

		wfProfileIn(__METHOD__);

		#print_pre(htmlspecialchars($this->bodytext));
		
		// RT#84733 - prompt to login if the user is an anon and can't edit right now (protected pages and wgDisableAnonEditing wikis).
		$promptLogin = ( !$wgTitle->userCanEdit() && $wgUser->isAnon() );
		$extraClass = ($promptLogin?" loginToEditProtectedPage":"");

		// replace section edit links with buttons and change order of HTML nodes
		// TODO: consider moving to Parser / Linker
		// TODO: use DoEditSectionLink hook (?)
		$this->bodytext = preg_replace(
			'#<span class="editsection">\[<a([^>]+)>[^>]+</a>\]</span>(.*)</h#',
			'$2<span class="editsection'.$extraClass.'"><a $1><img alt="'.wfMsg('oasis-section-edit-alt').'" src="' . $wgBlankImgUrl . '" class="sprite edit-pencil"></a> <a $1>'.wfMsg('oasis-section-edit').'</a></span></h',
			$this->bodytext);

		#print_pre(htmlspecialchars($this->bodytext));

		wfProfileOut(__METHOD__);
	}

}
