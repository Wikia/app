<?php

class CommunityPageDefaultCardsModel {

	/**
	 * Will return default modules array
	 * @param int $modulesLimit limits default modules number
	 * @return array
	 */
	public function getData( $modulesLimit ) {
		$result = [
			[
				'type' => 'createpage',
				'title' => wfMessage( 'communitypage-cards-create-page' )->text(),
				'description' => wfMessage( 'communitypage-cards-create-page-description' )->text(),
				'icon' => 'create-page',
				'actionlink' => SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL(),
				'actiontext' => wfMessage( 'communitypage-cards-create-page' )->text()
			]
		];
		// limit number of modules returned
		return [
			'modules' => array_slice( $result, 0, $modulesLimit )
		];
	}
}
