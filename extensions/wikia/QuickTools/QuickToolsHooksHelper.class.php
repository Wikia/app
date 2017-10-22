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

}
