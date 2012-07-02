<?php

/**
 * API extension for Distribution that provides information about MediaWiki releases.
 * 
 * @file ApiMWReleases.php
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Chad Horohoe
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


/**
 * Provides information about MediaWiki releases.
 * 
 * @since 0.1
 *
 * @ingroup Distribution
 * @ingroup API
 * 
 * @author Chad Horohoe
 */
class ApiMWReleases extends ApiBase {
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$results = array();
		$params = $this->extractRequestParams();
		$releases = $params['allreleases'] ?
			ReleaseRepo::singleton()->getAllReleases() :
			ReleaseRepo::singleton()->getSupportedReleases();

		foreach( $releases as $release ) {
			$r = array();
			if( ReleaseRepo::singleton()->getLatestStableRelease()->getId()
				== $release->getId() )
			{
				$r['latest'] = '';
			}
			foreach( $params['prop'] as $prop ) {
				switch( $prop ) {
					case 'name':
						$r['name'] = $release->getName();
						break;
					case 'number':
						$r['number'] = $release->getNumber();
						break;
					case  'reldate':
						$r['reldate'] = $release->getReldate();
						break;
					case 'eoldate':
						$r['eoldate'] = $release->getEoldate();
						break;
					case 'tagurl':
						$r['tagurl'] = $release->getTagUrl();
						break;
					case 'branchurl':
						$r['branchurl'] = $release->getBranchUrl();
						break;
					case 'announceurl':
						$r['announceturl'] = $release->getAnnounceUrl();
						break;
					case 'supported':
						if( $release->isSupported() ) {
							$r['supported'] = '';
						}
						break;
				}
			}
			$results[] = $r;
		}
		$this->getResult()->setIndexedTagName( $results, 'release' );
		$this->getResult()->addValue( null, $this->getModuleName(), $results );
	}

	public function getAllowedParams() {
		return array(
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'name',
					'number',
					'reldate',
					'eoldate',
					'tagurl',
					'branchurl',
					'announceurl',
					'supported',
				),
				ApiBase::PARAM_DFLT => 'number',
			),
			'allreleases' => false,
		);
	}

	public function getParamDescription() {
		return array(
			'prop' => 'Properties about the release',
			'allreleases' => 'Show all releases, not just currently supported ones',
		);
	}

	public function getDescription() {
		return array(
			'Get the list of current MediaWiki releases'
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=mwreleases&prop=tagurl|branchurl',
			'api.php?action=mwreleases&&allreleases=1&prop=name|reldate|eoldate'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiMWReleases.php 71103 2010-08-15 08:49:35Z jeroendedauw $ ';
	}
	
}