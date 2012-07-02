<?php
/**
 * Api module for querying message group stats.
 *
 * @file
 * @author Tim Gerundt
 * @copyright Copyright © 2012, Tim Gerundt
 * @copyright Copyright © 2012, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Api module for querying message group stats.
 *
 * @ingroup API TranslateAPI
 */
class ApiQueryMessageGroupStats extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'mgs' );
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$group = MessageGroups::getGroup( $params['group'] );
		if ( !$group ) {
			$this->dieUsageMsg( array( 'missingparam', 'mcgroup' ) );
		}

		MessageGroupStats::setTimeLimit( $params['timelimit'] );
		$cache = MessageGroupStats::forGroup( $group->getId() );
		$result = $this->getResult();

		foreach ( $cache as $code => $stats ) {
			if ( $code < $params['offset'] ) {
				continue;
			}

			list( $total, $translated, $fuzzy ) = $stats;

			if ( $total === null ) {
				$this->setContinueEnumParameter( 'offset', $code );
				break;
			}

			$data = array(
				'code' => $code,
				'total' => $total,
				'translated' => $translated,
				'fuzzy' => $fuzzy,
			);

			$result->addValue( array( 'query', $this->getModuleName() ), null, $data );
		}

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'messagegroupstats' );
	}

	public function getAllowedParams() {
		return array(
			'group' => array(
				ApiBase::PARAM_TYPE => array_keys( MessageGroups::getAllGroups() ),
				ApiBase::PARAM_REQUIRED => true,
			),
			'offset' => array(
				ApiBase::PARAM_DFLT => 0,
				ApiBase::PARAM_TYPE => 'string',
			),
			'timelimit' => array(
				ApiBase::PARAM_DFLT => 8,
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MAX => 10,
				ApiBase::PARAM_MIN => 0,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'group' => 'Message group id.',
			'offset' => 'If not all stats are calculated, you will get a query-continue parameter for offset you can use to get more.',
			'timelimit' => 'Maximum time to spend calculating missing statistics. If zero, only the cached results from the beginning are returned.',
		);
	}

	public function getDescription() {
		return 'Query message group stats';
	}

	public function getExamples() {
		$groups = MessageGroups::getAllGroups();
		$group = key( $groups );

		return array(
			"api.php?action=query&meta=messagegroupstats&mgsgroup=$group List of translation completion statistics for group $group",
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryMessageGroupStats.php 110782 2012-02-06 21:17:30Z nikerabbit $';
	}
}
