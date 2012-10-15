<?php

/**
 * Created on 6th June 2011
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

class ApiQueryCodePaths extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'cp' );
	}

	public function execute() {
		global $wgUser;
		// Before doing anything at all, let's check permissions
		if ( !$wgUser->isAllowed( 'codereview-use' ) ) {
			$this->dieUsage( 'You don\'t have permission to view code paths', 'permissiondenied' );
		}
		$params = $this->extractRequestParams();

		$repo = CodeRepository::newFromName( $params['repo'] );
		if ( !$repo instanceof CodeRepository  ) {
			$this->dieUsage( "Invalid repo ``{$params['repo']}''", 'invalidrepo' );
		}

		$this->addTables( 'code_paths' );
		$this->addFields( 'DISTINCT cp_path' );
		$this->addWhere( array( 'cp_repo_id' => $repo->getId() ) );
		$db = $this->getDB();

		$this->addWhere( 'cp_path ' . $db->buildLike( $params['path'], $db->anyString() ) );
		$this->addOption( 'USE INDEX', 'repo_path' );

		$this->addOption( 'LIMIT', 10 );

		$res = $this->select( __METHOD__ );

		$result = $this->getResult();

		$data = array();

		foreach ( $res as $row ) {
			$item = array();
			ApiResult::setContent( $item, $row->cp_path );
			$data[] = $item;
		}

		$result->setIndexedTagName( $data, 'paths' );
		$result->addValue( 'query', $this->getModuleName(), $data );
	}

	public function getAllowedParams() {
		return array(
			'repo' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'path' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'repo' => 'Name of the repository',
			'path' => 'Path prefix to filter on',
		);
	}

	public function getDescription() {
		return 'Get a list of 10 paths in a given repository, based on the input path prefix';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to view code paths' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=codepaths&cprepo=MediaWiki&cppath=/trunk/phase3',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryCodePaths.php 89645 2011-06-07 13:43:31Z reedy $';
	}
}
