<?php

/**
 * Created on Nov 18, 2010
 *
 * Copyright © 2010 Sam Reed
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

class ApiRevisionUpdate extends ApiBase {

	public function execute() {
		global $wgUser;
		// Before doing anything at all, let's check permissions
		if ( !$wgUser->isAllowed( 'codereview-use' ) ) {
			$this->dieUsage( 'You don\'t have permission to update code', 'permissiondenied' );
		}

		$params = $this->extractRequestParams();

		if( $params['comment']
			&& !$wgUser->isAllowed( 'codereview-post-comment' ) ) {
			$this->dieUsage( 'You do not have permission to post comment', 'permissiondenied' );
		}

		global $wgCodeReviewInlineComments;
		if(
			!$wgCodeReviewInlineComments
			&& isset( $params['patchline'] )
		) {
			$this->dieUsageMsg( "Can not attach a comment to a diff when inline commenting is disabled (\$wgCodeReviewInlineComments is false)." );
		}

		$repo = CodeRepository::newFromName( $params['repo'] );
		if ( !$repo ) {
			$this->dieUsage( "Invalid repo ``{$params['repo']}''", 'invalidrepo' );
		}

		$rev = $repo->getRevision( $params['rev'] );

		if ( !$rev ) {
			$this->dieUsage( "There is no revision with ID {$params['rev']}", 'nosuchrev' );
		}

		$revisionCommitter = new CodeRevisionCommitterApi( $repo, $rev );

		$commentID = $revisionCommitter->revisionUpdate(
			$params['status'],
			$params['addtags'],
			$params['removetags'],
			$params['addflags'],
			$params['removeflags'],
			$params['addreferences'],
			$params['removereferences'],
			$params['comment'],
			$params['addreferenced'],
			$params['removereferenced']
		);

		// Forge a response object
		$r = array( 'result' => 'Success' );

		if ( $commentID !== 0 ) {
			// id inserted
			$r['commentid'] = intval($commentID);
			// HTML Formatted comment
			$view = new CodeRevisionView( $repo, $rev);
			$comment = CodeComment::newFromID( $commentID, $rev );
			$r['HTML'] = $view->formatComment( $comment );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $r );
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		$flags = CodeRevision::getPossibleFlags();
		return array(
			'repo' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'rev' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_REQUIRED => true,
			),
			'comment' => null,
			'status' => array(
				ApiBase::PARAM_TYPE => CodeRevision::getPossibleStates()
			),
			'addtags' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
			),
			'removetags' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
			),
			'addflags' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => $flags
			),
			'removeflags' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => $flags
			),
			'addreferences' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_ISMULTI => true,
			),
			'removereferences' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_ISMULTI => true,
			),
			'addreferenced' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_ISMULTI => true,
			),
			'removereferenced' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_ISMULTI => true,
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'repo' => 'Name of repository',
			'rev' => 'Revision ID number',
			'comment' => 'Comment to add to the revision',
			'status' => 'Status to set the revision to',
			'addtags' => 'Tags to be added to the revision',
			'removetags' => 'Tags to be removed from the revision',
			'addflags' => 'Code Signoff flags to assign to the revision by the current user',
			'removeflags' => 'Code Signoff flags to strike from the revision by the current user',
			'addreferences' => 'Add references to this revision',
			'removereferences' => 'Remove references from this revision',
			'addreferenced' => 'Add referenced revisions from this revision',
			'removereferenced' => 'Remove referenced revisions from this revision',
			'token' => 'Edit token. You can get one of these through prop=info.' ,
		);
	}

	public function getDescription() {
		return array(
			'Submit comments, new status and tags to a revision'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to update code' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
			array( 'code' => 'nosuchrev', 'info' => 'There is no revision with ID \'rev\'' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=coderevisionupdate&repo=MediaWiki&rev=1&status=fixme',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiRevisionUpdate.php 110573 2012-02-02 15:06:34Z reedy $';
	}
}
