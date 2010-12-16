<?php

class ApiCodeDiff extends ApiBase {

	public function execute() {
		global $wgUser, $wgCodeReviewMaxDiffSize;
		// Before doing anything at all, let's check permissions
		if( !$wgUser->isAllowed('codereview-use') ) {
			$this->dieUsage('You don\'t have permission to view code diffs','permissiondenied');
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

		if ( $params['rev'] > $lastStoredRev ) {
			$this->dieUsage( "There is no revision with ID {$params['rev']}", 'nosuchrev' );
		}

		$diff = $repo->getDiff( $params['rev'] );

		if ( strval( $diff ) === '' ) {
			// FIXME: Are we sure we don't want to throw an error here?
			$html = 'Failed to load diff.';
		} elseif ( strlen( $diff ) > $wgCodeReviewMaxDiffSize ) {
			$html = 'Diff too large.';
		} else {
			$hilite = new CodeDiffHighlighter();
			$html = $hilite->render( $diff );
		}

		$data = array(
			'repo' => $params['repo'],
			'id' => $params['rev'],
			'diff' => $html
		);
		$this->getResult()->addValue( 'code', 'rev', $data );
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
			'repo' => 'Name of repository to look at',
			'rev' => 'Revision ID to fetch diff of' );
	}

	public function getDescription() {
		return array(
			'Fetch formatted diff from CodeReview\'s backing revision control system.' );
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to view code diffs' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
			array( 'code' => 'nosuchrev', 'info' => 'There is no revision with ID \'rev\'' ),
			array( 'missingparam', 'repo' ),
			array( 'missingparam', 'rev' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=codediff&repo=MediaWiki&rev=42080',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiCodeDiff.php 48777 2009-03-25 01:26:54Z aaron $';
	}
}
