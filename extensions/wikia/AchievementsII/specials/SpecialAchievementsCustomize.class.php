<?php

class SpecialAchievementsCustomize extends SpecialPage {

	function __construct() {
		parent::__construct('AchievementsCustomize', 'editinterface', false /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgOut, $wgExtensionsPath, $wgResourceBasePath, $wgSupressPageTitle, $wgRequest, $wgJsMimeType;

		// set basic headers
		$this->setHeaders();

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			$wgOut->readOnlyPage();
			return;
		}

		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $wgUser->mBlock );
		} elseif(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgSupressPageTitle = true;
		$errorMsg = null;
		$successMsg = null;

		if($wgRequest->wasPosted()) {

			$jsonObj = json_decode($wgRequest->getVal('json-data'));
			$dbw = null;

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

			$cond = array();
			$dbw = wfGetDB(DB_MASTER);

			if(count($jsonObj->statusFlags)) {
				foreach($jsonObj->statusFlags as $mKey => $mVal) {
					$tokens = explode('_', $mKey);
					$where = array_merge(array('id' => $tokens[1]), $cond);
					$dbw->update('ach_custom_badges', array('enabled' => (int)$mVal), $where);
				}
			}

			$successMsg = wfMsg('achievements-special-saved');

			if($wgRequest->getVal('add_edit_plus_category_track') == '1') {
				$catName = $wgRequest->getVal('edit_plus_category_name');
				$category = Category::newFromName($catName);

				if(!$category || !$category->getID())
					$errorMsg = wfMsg('achievements-non-existing-category');
				else {
					$safeCatName = $category->getTitle()->getText();

					if(
						strtolower($safeCatName) == 'stub' ||
						stripos($safeCatName, 'stub ') === 0 ||
						stripos($safeCatName, ' stub ') !== false ||
						strripos($safeCatName, ' stub') === (strlen($safeCatName) - 5)
					) {
						$errorMsg = wfMsg('achievements-no-stub-category');
					}
					else {
						$existingTrack = AchConfig::getInstance()->trackForCategoryExists($safeCatName);

						if($existingTrack !== false)
							$errorMsg = wfMsg('achievements-edit-plus-category-track-exists', $existingTrack);
						else {
							$cond = array( 'type' => BADGE_TYPE_INTRACKEDITPLUSCATEGORY, 'cat' => $safeCatName);

							$dbw->insert(
								'ach_custom_badges',
								$cond
							);

							$jsonObj->sectionId = $badge_type_id = $dbw->insertId();
						}
					}
				}
			}
		}

		AchConfig::getInstance()->refreshData(true);
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'config' => AchConfig::getInstance(),
			'scrollTo' => (isset($jsonObj->sectionId)) ? $jsonObj->sectionId : null,
			'successMsg' => $successMsg,
			'errorMsg' => $errorMsg
		));

		$wgOut->addHTML($template->render('SpecialCustomize'));
		$wgOut->addStyle("common/article_sidebar.css");
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/customize.css");

		// FIXME: create a module with all these JS files
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/scrollto/jquery.scrollTo-1.4.2.js\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/modules/aim.js\"></script>\n");

		wfProfileOut(__METHOD__);
	}
}
