<?php

/**
 * API module to delete objects stored by the Education Program extension.
 *
 * @since 0.1
 *
 * @file ApiDeleteEducation.php
 * @ingroup EducationProgram
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiDeleteEducation extends ApiBase {

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

	/**
	 * Returns the type param value for a class name.
	 *
	 * @since 0.1
	 *
	 * @param string $className
	 *
	 * @return string
	 */
	public static function getTypeForClassName( $className ) {
		static $map = null;

		if ( is_null( $map ) ) {
			$map = array_flip( self::$typeMap );
		}

		return $map[$className];
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( !$this->userIsAllowed( $params['type'], $params ) || $this->getUser()->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		$everythingOk = true;

//		foreach ( $params['ids'] as $id ) {
//			// $instance->remove is used instead of Class::delete,
//			// so that linked data also gets deleted.
//			$c = self::$typeMap[$params['type']];
//			$object = new $c( array( 'id' => $id ) );
//			$everythingOk = $object->remove() && $everythingOk;
//		}

		$class = self::$typeMap[$params['type']];
		
		if ( count( $params['ids'] ) > 0 ) {
			$revAction = new EPRevisionAction();
			
			$revAction->setUser( $this->getUser() );
			$revAction->setComment( $params['comment'] );
			
			$class::deleteAndLog( $revAction, array( 'id' =>  $params['ids'] ) );
		}

		$this->getResult()->addValue(
			null,
			'success',
			$everythingOk
		);
	}

	/**
	 * Returns if the user is allowed to delete the specified object(s).
	 *
	 * @since 0.1
	 *
	 * @param string $type
	 * @param array $params
	 *
	 * @return boolean
	 */
	protected function userIsAllowed( $type, array $params ) {
		return $this->getUser()->isAllowed( 'ep-' . $type );
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
			'comment' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false,
				ApiBase::PARAM_DFLT => '',
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'ids' => 'The IDs of the reviews to delete',
			'token' => 'Edit token. You can get one of these through prop=info.',
			'type' => 'Type of object to delete.',
			'comment' => 'Message with the reason for this change for the log',
		);
	}

	public function getDescription() {
		return array(
			'API module for deleting objects parts of the Education Program extension.'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=deleteeducation&ids=42&type=course',
			'api.php?action=deleteeducation&ids=4|2&type=student',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiDeleteEducation.php 110945 2012-02-08 17:51:13Z jeroendedauw $';
	}

}
