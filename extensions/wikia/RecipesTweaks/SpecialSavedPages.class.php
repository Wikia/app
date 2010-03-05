<?php

class SpecialSavedPages extends SpecialPage {

	public function  __construct() {
		parent::__construct( 'SavedPages' );
		wfLoadExtensionMessages('RecipesTweaks');
	}

	public function execute( $subpage ) {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgOut, $wgUser, $wgStylePath;

		$this->setHeaders();

		// not available for skins different then monaco
		if(get_class($wgUser->getSkin()) != 'SkinMonaco') {
			$wgOut->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut(__METHOD__);
			return;
		}

		// get user ID
		if ($subpage != '') {
			$user = User::newFromName($subpage);
			$userId = !empty($user) ? $user->getId() : 0;
		}
		else {
			if($wgUser->isAnon()) {
				$this->displayRestrictionError();
				return;
			}
			$userId = $wgUser->getId();
		}

		// show delete icons on user's own saved pages list
		if ($userId == $wgUser->getId()) {
			$showDelete = true;
		}

		$data = RecipesTweaks::getSavedPages($userId);

		$out = '';

		foreach($data as $item) {
			$out .= '<li><a href="'.$item['url'].'" class="recipes_saved_pages_title">'.$item['title'].'</a>';

			if (!empty($showDelete)) {
				$out .= '<img class="sprite delete recipes_saved_pages_delete" src="'.$wgStylePath.'/common/blank.gif" />';
			}

			$userLink = Xml::element('a', array('href' => $item['userUrl']), $item['userTitle']);
			$out .= '<cite>' . wfMsg('recipes-savedpages-by', array( $userLink ) ) . '</cite></li>';
		}

		if($out == '') {
			$out = wfMsg('recipes-savedpages-empty');
		} else {
			$out = '<ul class="recipes_saved_pages">'.$out.'</ul>';
		}

		$wgOut->addHTML($out);
		wfProfileOut(__METHOD__);
	}

}
