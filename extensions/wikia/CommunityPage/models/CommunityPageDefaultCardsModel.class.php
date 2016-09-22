<?php

class CommunityPageDefaultCardsModel {

	/**
	 * Will return default modules array
	 * @param int $modulesLimit limits default modules number
	 * @return array
	 */
	public function getData( $modulesLimit ) {
		// limit number of modules returned
		return array_slice( [
			[
				'type' => 'createpage',
				'title' => wfMessage( 'communitypage-cards-create-page' )->text(),
				'description' => wfMessage( 'communitypage-cards-create-page-description' )->text(),
				'icon' => 'create-page',
				'actionlink' => LinkHelper::forceLoginLink( SpecialPage::getTitleFor( 'CreatePage' ), LinkHelper::WITHOUT_EDIT_MODE ),
				'actiontext' => wfMessage( 'communitypage-cards-create-page' )->text()
			]
		], 0, $modulesLimit );
	}
}
