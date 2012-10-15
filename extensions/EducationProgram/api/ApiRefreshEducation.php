<?php

/**
 * API module to delete objects stored by the Education Program extension.
 *
 * @since 0.1
 *
 * @file ApiRefreshEducation.php
 * @ingroup EducationProgram
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiRefreshEducation extends ApiBase {

	/**
	 * Maps class names to values for the type parameter.
	 *
	 * @since 0.1
	 *
	 * @var array
	 */
	protected static $typeMap = array(
		'org' => 'EPOrg',
		'course' => 'EPCourse',
	);

	public function execute() {
		$params = $this->extractRequestParams();

		if ( $this->getUser()->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		$c = self::$typeMap[$params['type']];
		$c::updateSummaryFields( null, array( 'id' => $params['ids'] ) );

		$this->getResult()->addValue(
			null,
			'success',
			true
		);
	}

	/**
	 * Get the User being used for this instance.
	 * ApiBase extends ContextSource as of 1.19.
	 *
	 * @since 0.1
	 *
	 * @return User
	 */
	public function getUser() {
		return method_exists( 'ApiBase', 'getUser' ) ? parent::getUser() : $GLOBALS['wgUser'];
	}

	public function needsToken() {
		return true;
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
			'type' => array(
				ApiBase::PARAM_TYPE => array_keys( self::$typeMap ),
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'ids' => 'The IDs of the reviews to refresh',
			'token' => 'Edit token. You can get one of these through prop=info.',
			'type' => 'Type of object to delete.',
		);
	}

	public function getDescription() {
		return array(
			'API module for refreshing (rebuilding) summary data of objects parts of the Education Program extension.'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=refresheducation&ids=42&type=course',
			'api.php?action=refresheducation&ids=4|2&type=student',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiRefreshEducation.php 110272 2012-01-30 09:22:28Z jeroendedauw $';
	}

}
