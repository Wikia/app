<?php

class UserProfilePageRailHelper {

	/**
	 * @brief Hooks into GetRailModuleList
	 *
	 * @return boolean true
	 */
	public function onGetRailModuleList(&$modules) {
		$app = F::App();
		$app->wf->ProfileIn(__METHOD__);
		$title = $app->wg->Title;
		$namespaces = $app->getGlobal( 'UPPNamespaces', array() );

		if ( !in_array( $title->getNamespace(), $namespaces ) ) {
			$app->wf->ProfileOut(__METHOD__);
			return true;
		}

		$response = $app->sendRequest(
			'UserProfilePage',
			'getUserFromTitle',
			array(
				'title' => $title,
				'returnUser' => true
			)
		);

		/* @var $pageOwner User */
		$pageOwner = $response->getVal('user');
		if( !$pageOwner->getOption('hidefollowedpages') && !$title->isSpecial('Following') && !$title->isSpecial('Contributions') ) {
			$modules[1101] = array('FollowedPages', 'Index', array('showDeletedPages' => false));
		}

		$app->wf->ProfileOut(__METHOD__);
		return true;
	}

}
