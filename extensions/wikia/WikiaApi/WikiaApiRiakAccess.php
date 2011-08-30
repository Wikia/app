<?php

/*
 * Created on Jun 8, 2011
 *
 * API for MediaWiki 1.16+
 *
 * Copyright (C) 2011 Wladyslaw Bodzek
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if (!defined('MEDIAWIKI')) {
	require_once ('ApiBase.php');
}

/**
 * API interface for running Job from job queue
 * @ingroup API
 */
class WikiaApiRiakAccess extends ApiBase {

	/**
	 * @access public
	 */
	public function __construct( $main, $action ) {
		self::$messageMap[ "cantaccess" ] = array( "code" => "cantaccess", 'info' => "You don't have permission to access riak directly" );
		self::$messageMap[ "invalidarguments" ] = array( "code" => "invalidarguments", 'info' => "Invalid arguments" );
		parent :: __construct( $main, $action );
	}


	/**
	 * Main entry point
	 *
	 * @access public
	 */
	public function execute() {

		global $wgUser, $wgApiRunJobsPerRequest;

		ini_set( "memory_limit", -1 );
		ini_set( "max_execution_time", 0 );

		$params = $this->extractRequestParams();
		if( !$wgUser->isAllowed( "runjob" ) ) { // change to 'runjob' later
			$this->dieUsageMsg( array( "cantaccess" ) );
		}

		if ( empty($params['op']) ) {
			$this->dieUsageMsg( array( "invalidarguments" ) );
		}

		$result = array(
			'status' => 0,
		);
		switch ($params['op']) {
			case 'get':
				if ( empty( $params['bucket'] ) || empty( $params['key'] ) ) {
					$this->dieUsageMsg( array( "invalidarguments" ) );
				}

				$cache = wfGetSolidCacheStorage();
				$cache->setBucket($params['bucket']);
				$value = $cache->get($params['key']);
				$result['empty'] = (int)($value === false);
				$result['value'] = $value;
				$result['status'] = 1;
				break;
			case 'set':
				if ( empty( $params['bucket'] ) || empty( $params['key'] ) || empty( $params['value'] ) ) {
					$this->dieUsageMsg( array( "invalidarguments" ) );
				}
				$cache = wfGetSolidCacheStorage();
				$cache->setBucket($params['bucket']);
				$cache->set($params['key'],$params['value']);
				$result['status'] = 1;
				break;
			case 'delete':
				if ( empty( $params['bucket'] ) || empty( $params['key'] ) ) {
					$this->dieUsageMsg( array( "invalidarguments" ) );
				}
				$cache = wfGetSolidCacheStorage();
				$cache->setBucket($params['bucket']);
				$cache->delete($params['key']);
				$result['status'] = 1;
				break;
			default:
				$this->dieUsageMsg( array( "invalidarguments" ) );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );

		$result = array();
	}

	/**
	 * action must be posted, not getted (because it changes state of database)
	 *
	 * @access public
	 */
	public function mustBePosted() {
		return false;
		//return true;
	}

	/**
	 * application has to be in write mode (because it changes state of database)
	 *
	 * @access public
	 */
	public function isWriteMode() {
		return false;
	}

	public function getAllowedParams() {
		return array (
			'op' => array(
				ApiBase::PARAM_TYPE => "string",
			),
			'bucket' => array(
				ApiBase::PARAM_TYPE => "string",
			),
			'key' => array(
				ApiBase::PARAM_TYPE => "string",
			),
			'value' => array(
				ApiBase::PARAM_TYPE => "string",
			),
		);
	}

	public function getParamDescription() {
		return array (
			'op' => 'Riak operation (get, set or delete)',
			'bucket' => 'Riak bucket',
			'key' => 'Key',
			'value' => 'Value',
		);
	}

	public function getDescription() {
		return array (
			'Access Riak storage for testing purposes.'
		);
	}

	protected function getExamples() {
		return array(
			'api.php?action=riakaccess&op=get&bucket=x&key=asdasd',
			'api.php?action=riakaccess&op=set&bucket=x&key=zzz&value=nnn',
			'api.php?action=riakaccess&op=delete&bucket=x&key=asdasd',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Revision$';
	}
}
