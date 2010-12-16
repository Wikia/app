<?php

/**
 * Created on Jan 30, 2010
 *
 * CentralAuth extension
 *
 * Copyright (C) 2010 Roan Kattouw roan DOT kattouw AT gmail DOT com
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

/**
 * Query module to list global user info and attachments
 *
 * @ingroup API
 * @ingroup Extensions
 */
class ApiQueryGlobalUserInfo extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'gui' );
	}

	public function execute() {
		global $wgUser;
		$params = $this->extractRequestParams();
		$prop = array_flip( (array)$params['prop'] );
		if ( is_null( $params['user'] ) ) {
			$params['user'] = $wgUser->getName();
		}
		$user = new CentralAuthUser( $params['user'] );
		if ( !$user->exists() ) {
			$this->dieUsageMsg( array( 'nosuchuser', $params['user'] ) );
		}
		
		// Add basic info
		$result = $this->getResult();
		$data = array(
			'id' => $user->getId(),
			'registration' => wfTimestamp( TS_ISO_8601, $user->getRegistration() )
		);
		if ( $user->isLocked() ) {
			$data['locked'] = '';
		}
		if ( $user->isHidden() ) {
			$data['hidden'] = '';
		}
		$result->addValue( 'query', $this->getModuleName(), $data );
		
		// Add requested info
		if ( isset( $prop['groups'] ) ) {
			$groups = $user->getGlobalGroups();
			$result->setIndexedTagName( $groups, 'g' );
			$result->addValue( array( 'query', $this->getModuleName() ), 'groups', $groups );
		}
		if ( isset( $prop['rights'] ) ) {
			$rights = $user->getGlobalRights();
			$result->setIndexedTagName( $rights, 'r' );
			$result->addValue( array( 'query', $this->getModuleName() ), 'rights', $rights );
		}
		if ( isset( $prop['merged'] ) ) {
			$accounts = $user->queryAttached();
			foreach ( $accounts as $account ) {
				$a = array(
					'wiki' => $account['wiki'],
					'timestamp' => wfTimestamp( TS_ISO_8601, $account['attachedTimestamp'] ),
					'method' => $account['attachedMethod'],
					'editcount' => $account['editCount']
				);
				if ( $account['blocked'] ) {
					$a['blocked'] = array(
						'expiry' => Block::decodeExpiry( $account['block-expiry'], TS_ISO_8601 ),
						'reason' => $account['block-reason']
					);
				}
				$result->addValue( array( 'query', $this->getModuleName(), 'merged' ), null, $a );
			}
			$result->setIndexedTagName_internal( array( 'query', $this->getModuleName(), 'merged' ), 'account' );
		}
		if ( isset ($prop['unattached'] ) ) {
			$accounts = $user->queryUnattached();
			foreach ( $accounts as $account ) {
				$a = array(
					'wiki' => $account['wiki'],
					'editcount' => $account['editCount']
				);
				if ( $account['blocked'] ) {
					$a['blocked'] = array(
						'expiry' => Block::decodeExpiry( $account['block-expiry'], TS_ISO_8601 ),
						'reason' => $account['block-reason']
					);
				}
				$result->addValue( array( 'query', $this->getModuleName(), 'unattached' ), null, $a );
			}
			$result->setIndexedTagName_internal( array( 'query', $this->getModuleName(), 'unattached' ), 'account' );
		}
	}

	public function getCacheMode( $params ) {
		if ( !is_null( $params['user'] ) ) {
			// URL determines user, public caching is fine
			return 'public';
		} else {
			// Code will fall back to $wgUser, don't cache
			return 'private';
		}
	}

	public function getAllowedParams() {
		return array(
			'user' => null,
			'prop' => array(
				ApiBase::PARAM_TYPE => array(
					'groups',
					'rights',
					'merged',
					'unattached'
				),
				ApiBase::PARAM_ISMULTI => true
			)
		);
	}

	public function getParamDescription() {
		return array(
			'user' => 'User to get information about. Defaults to the current user',
			'prop' => array( 'Which properties to get:',
				'  groups     - Get a list of global groups this user belongs to',
				'  merged     - Get a list of merged accounts',
				'  unattached - Get a list of unattached accounts'
			),
		);
	}

	public function getDescription() {
		return 'Show information about a global user.';
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'nosuchuser', 'user' ),
		) );
	}

	protected function getExamples() {
		return array(
			'api.php?action=query&meta=globaluserinfo',
			'api.php?action=query&meta=globaluserinfo&guiuser=Catrope&guiprop=groups|merged|unattached'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryGlobalUserInfo.php 69932 2010-07-26 08:03:21Z tstarling $';
	}
}
