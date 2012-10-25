<?php

/**
 * API module to modify semantic watchlist groups.
 *
 * @since 0.1
 *
 * @file ApiEditWatchlistGroup.php
 * @ingroup SemanticWatchlist
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiEditWatchlistGroup extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'semanticwatchgroups' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		$params = $this->extractRequestParams();

		$group = new SWLGroup(
			$params['id'],
			$params['name'],
			$params['categories'],
			$params['namespaces'],
			$params['properties'],
			$params['concepts']
		);

		$this->getResult()->addValue(
			null,
			'success',
			$group->writeToDB()
		);
	}

	public function getAllowedParams() {
		return array(
			'id' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
			),
			'name' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'properties' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => true,
			),
			'categories' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => '',
			),
			'namespaces' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => '',
			),
			'concepts' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => '',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'id' => 'The ID of the watchlist group to edit',
			'name' => 'The name of the group, used for display in the user preferences',
			'properties' => 'The properties this watchlist group covers',
			'categories' => 'The categories this watchlist group covers',
			'namespaces' => 'The namespaces this watchlist group covers',
			'concepts' => 'The concepts this watchlist group covers',
		);
	}

	public function getDescription() {
		return array(
			'API module to modify semantic watchlist groups.'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=editswlgroup&id=42&name=My group of awesome&properties=Has awesomeness|Has epicness&categories=Awesome stuff',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiEditWatchlistGroup.php 88433 2011-05-19 22:00:17Z jeroendedauw $';
	}

}
