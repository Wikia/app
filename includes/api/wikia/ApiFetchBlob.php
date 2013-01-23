<?php

/*
 * Created on Jan 18, 2013, based on previous class WikiaApiQueryBlob
 *
 * API for MediaWiki 1.14+
 *
 * Copyright (C) 2010 Krzysztof Krzyżaniak (eloy)
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
class ApiFetchBlob extends ApiBase {

	/**
	 * @access public
	 */
	public function __construct( $main, $action ) {
		self::$messageMap[ "cantrunjobs" ] = array( "code" => "cantrunjobs", 'info' => "You don't have permission to fetch blob from store" );
		parent :: __construct( $main, $action );
	}


	/**
	 * Main entry point, tak job from queue and run it
	 *
	 * @access public
	 */
	public function execute() {
		global $wgUser, $wgTheSchwartzSecretToken, $wgLBFactoryConf;

		wfProfileIn( __METHOD__ );

		ini_set( "memory_limit", -1 );
		ini_set( "max_execution_time", 0 );

		$params = $this->extractRequestParams();
		$result = array();
		#
		# check token first
		#
		if( !( isset( $params[ "token" ] ) && $params[ "token" ] == $wgTheSchwartzSecretToken ) ) {
			#
			# then check for permissions
			#
			if( !$wgUser->isAllowed( "runjob" ) ) {
				$this->dieUsageMsg( array( "cantrunjobs" ) );
			}
		}

		$blob = null;
		$hash = null;
		#
		# check for store and id parameters
		#
		if( isset( $params[ "store"] ) && isset( $params[ "id" ] ) ) {
			$store = $params[ "store" ];
			$id = $params[ "id" ];
			#
			# check if store defined in loadbalancer file
			#
			if( isset( $wgLBFactoryConf[ "externalLoads" ][ $store ] ) ) {
				wfDebug( __METHOD__ . ": getting $id from $store\n" );

				$url = sprintf( "DB://%s/%d", $store, $id );
				$blob = ExternalStore::fetchFromURL( $url );
				if ( $blob === false ) {
					wfProfileOut( __METHOD__ );
					$this->dieUsage( 'Text not found', 3, 404 );
				}
				$hash = md5( $blob );
				$blob = unpack( "H*", $blob)[1];
			}
			else {
				wfDebug( __METHOD__ . ": store $store is not defined in wgLBFactoryConf\n" );
				wfProfileOut( __METHOD__ );
				$this->dieUsage( 'Text not found', 3, 404 );
			}
		}
		$result[ "blob" ] = $blob;
		$result[ "hash" ] = $hash;
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * action doesn't have to be posted
	 *
	 * @access public
	 */
	public function mustBePosted() {
		return false;
	}

	/**
	 * application hasn't to be in write mode (because it doesn't change state of database)
	 *
	 * @access public
	 */
	public function isWriteMode() {
		return false;
	}

	public function getAllowedParams() {
		return array (
			'store' => array(
				ApiBase :: PARAM_TYPE => "string"
			),
			'token' => array(
				ApiBase :: PARAM_TYPE => "string"
			),
			'id' => array(
				ApiBase :: PARAM_TYPE => "integer"
			)
		);
	}

	public function getParamDescription() {
		return array (
			'token' => 'secret token',
			'store' => 'blob store',
			'id'    => 'identifier for blob'
		);
	}

	public function getDescription() {
		return array (
			'Fetch blob from blob store.'
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=fetchblob&store=archive1&id=34&token=secret-token'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': 2013-01-17 15:45:00';
	}
}
