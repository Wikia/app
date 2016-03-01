<?php

class QuickToolsHooksHelper {

	/**
	 * Add the QuickTools link to Special:Contributions/USERNAME
	 * if the user has 'quicktools' permission and a Quick Adopt
	 * link for users with the 'quickadopt' permission
	 *
	 * @author grunny
	 * @param  integer $id User ID
	 * @param  Title $title User page title
	 * @param  Array $links Tool links
	 * @return boolean
	 */
	public static function onContributionsToolLinks( $id, $title, &$links ) {
		$app = F::app();
		if ( $app->wg->User->isAllowed( 'quicktools' ) ) {
			$links[] = Xml::tags(
				'a',
				[ 'href' => '#', 'id' => 'quicktools-link', 'data-username' => $title->getText() ],
				wfMessage( 'quicktools-contrib-link' )->escaped()
			);
			$app->wg->Out->addModules( 'ext.quickTools' );
		}
		if ( $app->wg->User->isAllowed( 'quickadopt' ) ) {
			$links[] = Xml::tags(
				'a',
				[ 'href' => '#', 'id' => 'quicktools-adopt-link', 'data-username' => $title->getText() ],
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
	 * @param  Array $possibleItems Allowed items that appear in the Oasis account navigation
	 * @param  Array $personalUrls An array of items to go in the menu
	 * @return boolean
	 */
	public static function onAccountNavigationModuleAfterDropdownItems( &$possibleItems, &$personalUrls ) {
		$app = F::app();
		if ( $app->wg->User->isAllowed( 'quicktools' ) ) {
			$possibleItems[] = 'createuserpage';
			$personalUrls['createuserpage'] = [
				'href' => '#',
				'text' => wfMessage( 'quicktools-createuserpage-link' )->escaped()
			];
			$app->wg->Out->addModules( 'ext.createUserPage' );
		}
		return true;
	}
}
