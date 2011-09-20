<?php

class ContributionMenuModule extends Module {

	var $dropdownItems = array();
	var $content_actions;

	public function executeIndex() {
		// add "edit this page" item
		if (isset($this->content_actions['edit'])) {
			$this->dropdownItems['edit'] = $this->content_actions['edit'];
		}

		// menu items linking to special pages
		$specialPagesLinks = array(
			'Upload' => 'oasis-button-add-photo',
			'WikiaVideoAdd' => 'oasis-button-add-video',
			'CreatePage' => 'oasis-button-create-page',
			'WikiActivity' => 'oasis-button-wiki-activity',
		);

		foreach ($specialPagesLinks as $specialPageName => $linkMessage) {
			$specialPageTitle = SpecialPage::getTitleFor( $specialPageName );
			if (!$specialPageTitle instanceof Title) {
				continue;
			}

			$this->dropdownItems[strtolower($specialPageName)] = array(
				'text' => wfMsg($linkMessage),
				'href' =>  $specialPageTitle->getLocalURL(),
			);
		}

		// show menu edit links
		$wgUser = F::app()->wg->User;

		if($wgUser->isAllowed('editinterface')) {
			$this->dropdownItems['wikinavedit'] = array(
				'text' => wfMsg('monaco-edit-this-menu'),
				'href' => Title::newFromText(WikiNavigationModule::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI)->getLocalURL('action=edit'),
			);
		}

		if($wgUser->isAllowed('wikianavglobal')) {
			$this->dropdownItems['wikinavglobaledit'] = array(
				'text' => wfMsg('oasis-button-edit-wikia-global-menu'),
				'href' => GlobalTitle::newFromText(WikiNavigationModule::WIKIA_GLOBAL_MESSAGE, NS_MEDIAWIKI, WikiNavigationModule::MESSAGING_WIKI_ID)->getFullURL('action=edit'),
			);
		}

		if($wgUser->isAllowed('wikianavlocal')) {
			$this->dropdownItems['wikinavlocaledit'] = array(
				'text' => wfMsg('oasis-button-edit-wikia-local-menu'),
				'href' => Title::newFromText(WikiNavigationModule::WIKIA_LOCAL_MESSAGE, NS_MEDIAWIKI)->getLocalURL('action=edit'),
			);
		}
	}
}