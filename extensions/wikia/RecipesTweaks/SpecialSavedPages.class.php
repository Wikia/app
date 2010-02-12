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
				$out .= '<img class="recipes_saved_pages_delete" width="16" height="16" src="'.$wgStylePath.'/monobook/blank.gif" />';
			}

			$out .= '<cite>' . wfMsg('recipes-savedpages-by') . ' <a href="'.$item['userUrl'].'">'.$item['userTitle'].'</a></cite></li>';
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
