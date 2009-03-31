<?php

class ApiCodeUpdate extends ApiBase {

	public function execute() {
		$params = $this->extractRequestParams();
		
		if( !isset( $params['repo'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'repo' ) );
		}
		if( !isset( $params['rev'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'rev' ) );
		}
		
		$repo = CodeRepository::newFromName( $params['repo'] );
		if( !$repo ){
			$this->dieUsage("Invalid repo ``{$params['repo']}''", 'invalidrepo');
		}
		
		$svn = SubversionAdaptor::newFromRepo( $repo->getPath() );
		$lastStoredRev = $repo->getLastStoredRev();
		
		if( $lastStoredRev >= $params['rev'] ) {
			// Nothing to do, we're up to date.
			// Return an empty result
			$this->getResult()->addValue(null, $this->getModuleName(), array());
			return;
		}
		
		// FIXME: this could be a lot?
		$log = $svn->getLog( '', $lastStoredRev + 1, $params['rev'] );
		if( !$log ) {
			// FIXME: When and how often does this happen?
			// Should we use dieUsage() here instead?
			ApiBase::dieDebug( __METHOD__, "Something awry..." );
		}		
		
		$result = array();
		foreach( $log as $data ) {
			$codeRev = CodeRevision::newFromSvn( $repo, $data );
			$codeRev->save();
			$result[] = array(
				'id' => $codeRev->getId(),
				'author' => $codeRev->getAuthor(),
				'timestamp' => wfTimestamp( TS_ISO_8601, $codeRev->getTimestamp() ),
				'message' => $codeRev->getMessage()
			);
		}
		// Cache the diffs if there are a only a few.
		// Mainly for WMF post-commit ping hook...
		if( count($result) <= 2 ) {
			foreach( $result as $revData ) {
				$rev = $repo->getRevision( $revData['id'] );
				$diff = $repo->getDiff( $revData['id'] ); // trigger caching
			}
		}
		$this->getResult()->setIndexedTagName($result, 'rev');
		$this->getResult()->addValue(null, $this->getModuleName(), $result);
	}
	
	public function mustBePosted() {
		// Discourage casual browsing :)
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
	
	public function getExamples() {
		return array(
			'api.php?action=codeupdate&repo=MediaWiki&rev=42080',
		);
	}
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiCodeUpdate.php 45086 2008-12-27 12:35:57Z aaron $';
	}
}
