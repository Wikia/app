<?php

/**
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

class ApiCodeUpdate extends ApiBase {

	public function execute() {
		global $wgUser;
		// Before doing anything at all, let's check permissions
		if ( !$wgUser->isAllowed( 'codereview-use' ) ) {
			$this->dieUsage( 'You don\'t have permission to update code', 'permissiondenied' );
		}
		$params = $this->extractRequestParams();

		$repo = CodeRepository::newFromName( $params['repo'] );
		if ( !$repo ) {
			$this->dieUsage( "Invalid repo ``{$params['repo']}''", 'invalidrepo' );
		}

		$svn = SubversionAdaptor::newFromRepo( $repo->getPath() );
		$lastStoredRev = $repo->getLastStoredRev();

		if ( $lastStoredRev >= $params['rev'] ) {
			// Nothing to do, we're up to date.
			// Return an empty result
			$this->getResult()->addValue( null, $this->getModuleName(), array() );
			return;
		}

		// FIXME: this could be a lot?
		$log = $svn->getLog( '', $lastStoredRev + 1, $params['rev'] );
		if ( !$log ) {
			// FIXME: When and how often does this happen?
			// Should we use dieUsage() here instead?
			ApiBase::dieDebug( __METHOD__, 'Something awry...' );
		}

		$result = array();
		$revs = array();
		foreach ( $log as $data ) {
			$codeRev = CodeRevision::newFromSvn( $repo, $data );
			$codeRev->save();
			$result[] = array(
				'id' => $codeRev->getId(),
				'author' => $codeRev->getAuthor(),
				'timestamp' => wfTimestamp( TS_ISO_8601, $codeRev->getTimestamp() ),
				'message' => $codeRev->getMessage()
			);
			$revs[] = $codeRev;
		}
		// Cache the diffs if there are a only a few.
		// Mainly for WMF post-commit ping hook...
		if ( count( $revs ) <= 2 ) {
			foreach ( $revs as $codeRev ) {
				$repo->setDiffCache( $codeRev ); // trigger caching
			}
		}
		$this->getResult()->setIndexedTagName( $result, 'rev' );
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function mustBePosted() {
		// Discourage casual browsing :)
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'repo' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'rev' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_REQUIRED => true,
			)
		);
	}

	public function getParamDescription() {
		return array(
			'repo' => 'Name of repository to update',
			'rev' => 'Revision ID number to update to' );
	}

	public function getDescription() {
		return array(
			'Update CodeReview repository data from master revision control system.' );
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to update code' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=codeupdate&repo=MediaWiki&rev=42080',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiCodeUpdate.php 79344 2010-12-31 16:13:58Z reedy $';
	}
}
