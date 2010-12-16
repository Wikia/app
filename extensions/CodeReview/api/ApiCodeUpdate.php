<?php

class ApiCodeUpdate extends ApiBase {

	public function execute() {
		global $wgUser;
		// Before doing anything at all, let's check permissions
		if( !$wgUser->isAllowed('codereview-use') ) {
			$this->dieUsage('You don\'t have permission update code','permissiondenied');
		}
		$params = $this->extractRequestParams();

		if ( !isset( $params['repo'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'repo' ) );
		}
		if ( !isset( $params['rev'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'rev' ) );
		}

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
			ApiBase::dieDebug( __METHOD__, "Something awry..." );
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
			'repo' => null,
			'rev' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1
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
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission update code' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
			array( 'missingparam', 'repo' ),
			array( 'missingparam', 'rev' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=codeupdate&repo=MediaWiki&rev=42080',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiCodeUpdate.php 48928 2009-03-27 18:41:20Z catrope $';
	}
}
