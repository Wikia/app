<?php

class ContributeMenuController extends WikiaController {

	public function executeIndex() {
		// add "edit this page" item
		$dropdownItems = array();
		$content_actions = $this->app->getSkinTemplateObj()->data['content_actions'];
		if (isset($content_actions['edit'])) {
			$dropdownItems['edit'] = array(
				'text' => wfMsg('oasis-navigation-v2-edit-page'),
				'href' => $content_actions['edit']['href'],
				// don't use MenuButton module magic to get accesskey for this item (BugId:15698)
				'accesskey' => false,
			);
		}

		// menu items linking to special pages
		$specialPagesLinks = array(
			'Upload' => array(
				'label' => 'oasis-navigation-v2-add-photo'
			),
			'CreatePage' => array(
				'label' => 'oasis-navigation-v2-create-page',
				'class' => 'createpage',
			),
			'WikiActivity' => array(
				'label' => 'oasis-button-wiki-activity',
				'accesskey' => 'g',
			)
		);
		
		// check if Special:Videos is enabled before showing 'add video' link
		// add video button
		if( !empty( $this->wg->EnableSpecialVideosExt) && $this->wg->User->isAllowed('videoupload' ) ) {
			$addVideoLink = array(
				'WikiaVideoAdd' => array(
					'label' => 'oasis-navigation-v2-add-video'			
				)
			);

			$specialPagesLinks = array_merge($addVideoLink, $specialPagesLinks);
		}

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

			if (isset($link['class'])) {
				$attrs['class'] = $link['class'];
			}

			$dropdownItems[strtolower($specialPageName)] = $attrs;
		}

		// show menu edit links
		$wgUser = F::app()->wg->User;

		if($wgUser->isAllowed('editinterface')) {
			$dropdownItems['wikinavedit'] = array(
				'text' => wfMsg('oasis-navigation-v2-edit-this-menu'),
				'href' => Title::newFromText(NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI)->getLocalURL('action=edit'),
			);
		}
		$this->response->setVal('dropdownItems', $dropdownItems);
	}
}
