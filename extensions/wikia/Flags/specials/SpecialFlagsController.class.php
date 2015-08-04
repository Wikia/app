<?php

/**
 * This is a controller for the Flags special page a.k.a. Flags HQ.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

use Flags\FlagsHelper;

class SpecialFlagsController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'Flags', 'flags', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'flags-special-title' )->escaped() );

		$this->flagTypes = [];

		$responseData = $this->requestGetFlagTypesForWikia( $this->wg->CityId )->getData();
		if ( $responseData['status'] ) {
			$this->flagGroups = FlagsHelper::getFlagGroupsFullNames();
			$this->flagTargeting = FlagsHelper::getFlagTargetFullNames();
			$this->flagTypes = $responseData['data'];

			if ( SpecialPage::exists( 'Insights' ) ) {
				// @TODO change link to use InsightsFlagsModel::INSIGHT_TYPE
				$this->insightsTitle = Title::newFromText( 'Insights/flags', NS_SPECIAL );
			} else {
				$this->insightsTitle = null;
			}
		}

		// permissions check
		$this->hasAdminPermissions = $this->wg->User->isAllowed( 'flags-administration' );
	}

	private function requestGetFlagTypesForWikia( $wikiId ) {
		return $this->sendRequest( 'FlagsApiController',
			'getFlagTypes',
			[
				'wiki_id' => $wikiId,
			]
		);
	}
}
