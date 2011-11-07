<?php

class ContributeMenuModule extends Module {

	var $dropdownItems = array();
	var $content_actions;

	public function executeIndex() {
		// add "edit this page" item
		if (isset($this->content_actions['edit'])) {
			$this->dropdownItems['edit'] = array(
				'text' => wfMsg('oasis-navigation-v2-edit-page'),
				'href' => $this->content_actions['edit']['href']
			);
		}

		// menu items linking to special pages
		$specialPagesLinks = array(
			'Upload' => array(
				'label' => 'oasis-navigation-v2-add-photo'
			),
			'CreatePage' => array(
				'label' => 'oasis-navigation-v2-create-page'
			),
			'WikiActivity' => array(
				'label' => 'oasis-button-wiki-activity',
				'accesskey' => 'g',
			)
		);

		foreach ($specialPagesLinks as $specialPageName => $link) {
			$specialPageTitle = SpecialPage::getTitleFor( $specialPageName );
			if (!$specialPageTitle instanceof Title) {
				continue;
			}

			$attrs = array(
				'text' => wfMsg($link['label']),
				'href' =>  $specialPageTitle->getLocalURL(),
			);

			if (isset($link['accesskey'])) {
				$attrs['accesskey'] = $link['accesskey'];
			}

			$this->dropdownItems[strtolower($specialPageName)] = $attrs;
		}

		// show menu edit links
		$wgUser = F::app()->wg->User;

		if($wgUser->isAllowed('editinterface')) {
			$this->dropdownItems['wikinavedit'] = array(
				'text' => wfMsg('oasis-navigation-v2-edit-this-menu'),
				'href' => Title::newFromText(WikiNavigationModule::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI)->getLocalURL('action=edit'),
			);
		}
	}
}