<?php

class QuickToolsHooksHelper {

	/**
	 * Add the QuickTools link to Special:Contributions/USERNAME
	 * if the user has 'quicktools' permission and a Quick Adopt
	 * link for users with the 'quickadopt' permission
	 *
	 * @author grunny
	 * @param $id Integer user ID
	 * @param $nt Title user page title
	 * @param $links Array tool links
	 * @return true
	 */
	public static function onContributionsToolLinks( $id, $nt, &$links ) {
		$app = F::App();
		if ( $app->wg->User->isAllowed( 'quicktools' ) ) {
			$links[] = Xml::tags(
				'a',
				array( 'href' => '#', 'id' => 'quicktools-link', 'data-username' => $nt->getText() ),
				wfMessage( 'quicktools-contrib-link' )->escaped()
			);
			$app->wg->Out->addModules( 'ext.quickTools' );
		}
		if ( $app->wg->User->isAllowed( 'quickadopt' ) ) {
			$links[] = Xml::tags(
				'a',
				array( 'href' => '#', 'id' => 'quicktools-adopt-link', 'data-username' => $nt->getText() ),
				wfMessage( 'quicktools-adopt-contrib-link' )->escaped()
			);
			$app->wg->Out->addModules( 'ext.quickAdopt' );
		}
		return true;
	}

	/**
	 * Add a link to create user page automagically to the account navigation dropdown
	 * and add the create user page JS module
	 *
	 * @author grunny
	 * @param $possibleItems Array Allowed items that appear in the Oasis account navigation
	 * @param $personalUrls Array An array of items to go in the menu
	 * @return true
	 */
	public static function onAccountNavigationModuleAfterDropdownItems( &$possibleItems, &$personalUrls ) {
		$app = F::App();
		if ( $app->wg->User->isAllowed( 'quicktools' ) ) {
			$possibleItems[] = 'createuserpage';
			$personalUrls['createuserpage'] = array(
				'href' => '#',
				'text' => wfMessage( 'quicktools-createuserpage-link' )->escaped()
			);
			$app->wg->Out->addModules( 'ext.createUserPage' );
		}
		return true;
	}
}