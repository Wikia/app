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
			$helper = new FlagsHelper();
			$this->flagGroups = $helper->getFlagGroupsFullNames();
			$this->flagTargeting = $helper->getFlagTargetFullNames();
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

	public function addFlagType() {
		$data = $this->request->getParams();

		$params = $this->getFlagParamsFromTemplate( $data['flag_view'] );
		$flagParams = json_decode( $data['flag_params_names'], true );

		foreach ( $flagParams as $param => $description ) {
			$params[$param] = $description;
		}

		$data['flag_params_names'] = json_encode( $params, JSON_FORCE_OBJECT );



		$response = $this->sendRequest( 'FlagsApiController',
			'addFlagType',
			$data
		)->getData();

		$this->response->setValues( $response );
	}

	public function updateFlagType() {
		$data = $this->request->getParams();

		$response = $this->sendRequest( 'FlagsApiController',
			'updateFlagType',
			$data
		)->getData();

		$this->response->setValues( $response );
	}

	/**
	 * @param string name of template treated as view and source of params
	 * @return bool status
	 */

	private function getFlagParamsFromTemplate( $template ) {
		$params = [];

		$title = \Title::newFromText( $template, NS_TEMPLATE );
		if ( ! $title instanceof Title ) {
			return [];
		}

		$article = new \Article( $title );
		if ( !$article->exists() ) {
			return [];
		}

		$flagParams = ( new \Flags\FlagsParamsComparison() )->compareTemplateVariables(
			$article->mTitle,
			'',
			$article->getContent()
		);

		if ( !is_null( $flagParams ) && !empty( $flagParams['params'] ) ) {
			$params = $flagParams['params'];
		}

		return $params;
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
