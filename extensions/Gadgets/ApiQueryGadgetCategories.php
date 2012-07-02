<?php
/**
 * Created on 16 April 2011
 * API for Gadgets extension
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class ApiQueryGadgetCategories extends ApiQueryBase {
	private $props,
		$neededNames;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'gc' );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$this->props = array_flip( $params['prop'] );
		$this->neededNames = isset( $params['names'] )
			? array_flip( $params['names'] )
			: false;

		$this->getMain()->setCacheMode( 'public' );

		$this->getList();
	}

	private function getList() {
		$data = array();
		$result = $this->getResult();
		$gadgets = Gadget::loadStructuredList();

		foreach ( $gadgets as $category => $list ) {
			if ( !$this->neededNames || isset( $this->neededNames[$category] ) ) {
				$row = array();
				if ( isset( $this->props['name'] ) ) {
					$row['name'] = $category;
				}

				if ( $category !== "" ) {
					if ( isset( $this->props['title'] ) ) {
						$row['desc'] = wfMessage( "gadget-section-$category" )->parse();
					}
				}

				if ( isset( $this->props['members'] ) ) {
					$row['members'] = count( $list );
				}

				$data[] = $row;
			}
		}
		$result->setIndexedTagName( $data, 'category' );
		$result->addValue( 'query', $this->getModuleName(), $data );
	}

	public function getAllowedParams() {
		return array(
			'prop' => array(
				ApiBase::PARAM_DFLT => 'name',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'name',
					'title',
					'members',
				),
			),
			'names' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
			),
		);
	}

	public function getDescription() {
		return 'Returns a list of gadget categories';
	}

	public function getParamDescription() {
		return array(
			'prop' => array(
				'What gadget category information to get:',
				' name     - Internal category name',
				' title    - Category title',
				' members  - Number of gadgets in category',
			),
			'names' => 'Name(s) of categories to retrieve',
		);
	}

	public function getExamples() {
		$params = $this->getAllowedParams();
		$allProps = implode( '|', $params['prop'][ApiBase::PARAM_TYPE] );

		return array(
			'Get a list of existing gadget categories:',
			'    api.php?action=query&list=gadgetcategories',
			'Get all information about categories named "foo" and "bar":',
			"    api.php?action=query&list=gadgetcategories&gcnames=foo|bar&gcprop=$allProps",
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
