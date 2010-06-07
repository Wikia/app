<?php

class SpecialAchievementsCustomize extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('AchievementsII');
		parent::__construct('AchievementsCustomize', 'editinterface' /* no restriction */, false /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle, $wgRequest, $wgJsMimeType, $wgCityId, $wgExternalSharedDB;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		$wgSupressPageTitle = true;
		$errorMsg = null;
		
		if($wgRequest->wasPosted()) {

			$jsonObj = Wikia::json_decode($wgRequest->getVal('json-data'));
			$dbw = null;

			$wgOut->wrapWikiMsg( '<div class="successbox"><strong>$1</strong></div>', 'achievements-special-saved' );

			foreach($jsonObj->messages as $mKey => $mVal) {
				$tokens = explode('_', $mKey);

				if(!isset($tokens[2]))
					$tokens[2] = null;

				list(, $badgeTypeId, $lap) = $tokens;

				$badge = new AchBadge($badgeTypeId, $lap);

				if($badge->getName() != $mVal) {
					$article = new Article(Title::newFromText(AchConfig::getInstance()->getBadgeNameKey($badgeTypeId, $lap), NS_MEDIAWIKI));
					$article->doEdit($mVal, '');
				}
			}

			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

			if(count($jsonObj->statusFlags)) {
				foreach($jsonObj->statusFlags as $mKey => $mVal) {
					$tokens = explode('_', $mKey);
					$dbw->update('ach_custom_badges', array('enabled' => (int)$mVal), array('wiki_id' => $wgCityId, 'id' => $tokens[1]));
				}
			}

			if($wgRequest->getVal('add_edit_plus_category_track') == '1') {
				$catName = $wgRequest->getVal('edit_plus_category_name');
				$category = Category::newFromName($catName);
				
				if(!$category || !$category->getID())
					$errorMsg = wfMsg('achievements-non-existing-category');
				else {
					$safeCatName = $category->getName();
					$existingTrack = AchConfig::getInstance()->trackForCategoryExists($safeCatName);
					
					if($existingTrack !== false)
						$errorMsg = wfMsg('achievements-edit-plus-category-track-exists', $existingTrack);
					else {
						$dbw->insert(
							'ach_custom_badges',
							array('wiki_id' => $wgCityId, 'type' => BADGE_TYPE_INTRACKEDITPLUSCATEGORY, 'cat' => $safeCatName)
						);

						$jsonObj->sectionId = $badge_type_id = $dbw->insertId();
					}
				}
			}
		}

		$this->setHeaders();
		AchConfig::getInstance()->refreshData(true);
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'config' => AchConfig::getInstance(),
			'scrollTo' => (isset($jsonObj->sectionId)) ? $jsonObj->sectionId : null,
			'errorMsg' => $errorMsg
		));

		$wgOut->addHTML($template->render('SpecialCustomize'));
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/customize.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/jquery.aim.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/jquery.scrollTo-1.4.2.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js?{$wgStyleVersion}\"></script>\n");

		wfProfileOut(__METHOD__);
	}

}
