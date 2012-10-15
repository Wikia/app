<?php

/**
 * API module to delete upload wizard campaigns.
 *
 * @since 1.2
 *
 * @file ApiDeleteUploadCampaign.php
 * @ingroup Upload
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiDeleteUploadCampaign extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'upwizcampaigns' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		$params = $this->extractRequestParams();

		$everythingOk = true;

		foreach ( $params['ids'] as $id ) {
			$campaign = new UploadWizardCampaign( $id );
			$everythingOk = $campaign->deleteFromDB() && $everythingOk;
		}

		$this->getResult()->addValue(
			null,
			'success',
			$everythingOk
		);
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		$params = $this->extractRequestParams();
		return 'deletecampaign' . implode( '|', $params['ids'] );
	}

	public function mustBePosted() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'ids' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => true,
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'ids' => 'The IDs of the campaigns to delete',
			'token' => 'Edit token. You can get one of these through prop=info.',
		);
	}

	public function getDescription() {
		return array(
			'API module for deleting Upload Campaigns, associated with UploadWizard.',
			'Do not rely on this, it is an API method mostly for developer convenience.',
			'This does not mean an Upload Campaign editing API will ever be available.',
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'ids' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=deleteuploadcampaign&ids=42',
			'api.php?action=deleteuploadcampaign&ids=4|2',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiDeleteUploadCampaign.php 98821 2011-10-03 22:42:58Z reedy $';
	}

}
