<?php
/**
 * Api module for querying MessageGroups.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Api module for querying MessageGroups.
 *
 * @ingroup API TranslateAPI
 */
class ApiQueryMessageGroups extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'mg' );
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function execute() {
		$groups = MessageGroups::getAllGroups();
		$result = $this->getResult();

		foreach ( $groups as $id => $g ) {
			$a = array();
			$a['id'] = $id;
			$a['label'] = $g->getLabel();
			$a['description'] = $g->getDescription();
			$a['class'] = get_class( $g );
			$a['exists'] = $g->exists();

			// TODO: Add a continue?
			$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $a );
			if ( !$fit ) {
				// Even if we're not going to give a continue, no point carrying on if the result is full
				break;
			}
		}

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'group' );
	}

	public function getDescription() {
		return 'Return information about message groups';
	}

	public function getExamples() {
		return array(
			'api.php?action=query&meta=messagegroups',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryMessageGroups.php 99095 2011-10-06 13:02:49Z reedy $';
	}
}
