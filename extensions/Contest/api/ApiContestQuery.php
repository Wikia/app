<?php

/**
 * Base class for API query modules that return results using a
 * ContestDBObject deriving class.
 *
 * @since 0.1
 *
 * @file ApiContestQuery.php
 * @ingroup Contest
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ApiContestQuery extends ApiQueryBase {

	/**
	 * Returns the class specific info.
	 * * class: name of the ContestDBObject deriving class (ie Contest)
	 * * item: item name (ie contest)
	 * * set: item set name (ie contests)
	 *
	 * @since 0.1
	 *
	 * @return array of string
	 */
	protected abstract function getClassInfo();

	/**
	 * Returns an instance of the ContestDBObject deriving class.
	 * Once PHP 5.3 becomes an acceptable requirement, we
	 * can get rid of this silly hack and simply return the class
	 * name (since all methods we need ought to be static in PHP >= 5.3).
	 *
	 * @since 0.1
	 *
	 * @return ContestDBObject
	 */
	protected function getClass() {
		$className = $this->getClassInfo();
		$className = $className['class'];
		static $classes = array();
		if ( !isset( $classes[$className] ) ) {
			$classes[$className] = new $className( array() );
		}
		return $classes[$className];
	}

	/**
	 * Get the parameters, find out what the conditions for the query are,
	 * run it, and add the results.
	 *
	 * @since 0.1
	 */
	public function execute() {
		$params = $this->getParams();

		if ( count( $params['props'] ) > 0 ) {
			$results = $this->getResults( $params, $this->getConditions( $params ) );
			$this->addResults( $params, $results );
		}
	}

	/**
	 * Get the request parameters, handle the * value for the props param
	 * and remove all params set to null (ie those that are not actually provided).
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getParams() {
		// Get the requests parameters.
		$params = $this->extractRequestParams();

		$starPropPosition = array_search( '*', $params['props'] );

		if ( $starPropPosition !== false ) {
			unset( $params['props'][$starPropPosition] );
			$params['props'] = array_merge( $params['props'], $this->getClass()->getFieldNames() );
		}

		return array_filter( $params, create_function( '$p', 'return isset( $p );' ) );
	}

	/**
	 * Get the conditions for the query. These will be provided as
	 * regular parameters, together with limit, props, continue,
	 * and possibly others which we need to get rid off.
	 *
	 * @since 0.1
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	protected function getConditions( array $params ) {
		$conditions = array();

		foreach ( $params as $name => $value ) {
			if ( $this->getClass()->canHasField( $name ) ) {
				$conditions[$name] = $value;
			}
		}

		return $conditions;
	}

	/**
	 * Get the actual results.
	 *
	 * @since 0.1
	 *
	 * @param array $params
	 * @param array $conditions
	 *
	 * @return array of ContestDBClass
	 */
	protected function getResults( array $params, array $conditions ) {
		return $this->getClass()->select(
			$params['props'],
			$conditions,
			array(
				'LIMIT' => $params['limit'] + 1,
				'ORDER BY' => $this->getClass()->getPrefixedField( 'id' ) . ' ASC'
			)
		);
	}

	/**
	 * Serialize the results and add them to the result object.
	 *
	 * @since 0.1
	 *
	 * @param array $params
	 * @param array $results
	 */
	protected function addResults( array $params, array /* of ContestDBObject */ $results ) {
		$serializedResults = array();
		$count = 0;

		foreach ( $results as $result ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $result->getId() );
				break;
			}

			$serializedResults[] = $result->toArray( $params['props'] );
		}

		$this->setIndexedTagNames( $serializedResults );
		$this->addSerializedResults( $serializedResults );
	}

	/**
	 * Set the tag names for formats such as XML.
	 *
	 * @since 0.1
	 *
	 * @param array $serializedResults
	 */
	protected function setIndexedTagNames( array &$serializedResults ) {
		$classInfo = $this->getClassInfo();
		$this->getResult()->setIndexedTagName( $serializedResults, $classInfo['item'] );
	}

	/**
	 * Add the serialized results to the result object.
	 *
	 * @since 0.1
	 *
	 * @param array $serializedResults
	 */
	protected function addSerializedResults( array $serializedResults ) {
		$classInfo = $this->getClassInfo();

		$this->getResult()->addValue(
			null,
			$classInfo['set'],
			$serializedResults
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 * @return array
	 */
	public function getAllowedParams() {
		$params = array (
			'props' => array(
				ApiBase::PARAM_TYPE => array_merge( $this->getClass()->getFieldNames(), array( '*' ) ),
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => '*'
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 20,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'continue' => null,
		);

		return array_merge( $this->getClass()->getAPIParams(), $params );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getParamDescription()
	 */
	public function getParamDescription() {
		$descs = array (
			'props' => 'Fields to query',
			'continue' => 'Offset number from where to continue the query',
			'limit' => 'Max amount of rows to return',
		);

		return array_merge( $this->getClass()->getFieldDescriptions(), $descs );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getPossibleErrors()
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'badaccess-groups' ),
		) );
	}

}
