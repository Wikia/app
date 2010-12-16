<?php

/*
 * Created on Dec 20, 2008
 *
 * API module for MediaWiki's FlaggedRevs extension
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
 * API module to review revisions
 *
 * @ingroup FlaggedRevs
 */
class ApiReview extends ApiBase {

	/**
	 * This function does essentially the same as RevisionReview::AjaxReview,
	 * except that it generates the template and image parameters itself.
	 */
	public function execute() {
		global $wgUser;
		$params = $this->extractRequestParams();

		// Check permissions
		if( !$wgUser->isAllowed( 'review' ) )
			$this->dieUsageMsg( array( 'badaccess-group0' ) );
		if( $wgUser->isBlocked() )
			$this->dieUsageMsg( array( 'blockedtext' ) );

		// Construct submit form
		$form = new RevisionReview();
		$revid = intval( $params['revid'] );
		$rev = Revision::newFromId( $revid );
		if( !$rev )
			$this->dieUsage( "Cannot find a revision with the specified ID.", 'notarget' );
		$form->oldid = $revid;
		$title = $rev->getTitle();
		$form->page = $title;
		if( !FlaggedRevs::inReviewNamespace( $title ) )
			$this->dieUsage( "Provided revision or page can not be reviewed.", 'notreviewable' );

		if( isset( $params['unapprove'] ) ) 
			$form->approve = !$params['unapprove'];
		if( isset( $params['comment'] ) )
			$form->comment = $params['comment'];
		if( isset( $params['notes'] ) )
			$form->notes = $wgUser->isAllowed( 'validate' ) ? $params['notes'] : '';

		// The flagging parameters have the form 'flag_$name'.
		// Extract them and put the values into $form->dims
		$flags = FlaggedRevs::getDimensions();
		foreach( $flags as $name => $levels ) {
			if( !( $form->dims[$name] = intval( $params['flag_' . $name] ) ) )
				$form->unapprovedTags++;
		}

		// Check if this is a valid approval/unapproval of the revision
		if( $form->unapprovedTags && $form->unapprovedTags < count( $flags ) )
			$this->dieUsage( "Either all or none of the flags have to be set to zero.", 'mixedapproval' );

		// Check if user is even allowed to set the flags
		$form->oflags = FlaggedRevs::getRevisionTags( $title, $form->oldid );
		$fa = FlaggedArticle::getTitleInstance( $form->page );
		$form->config = $fa->getVisibilitySettings();
		if( !$title->quickUserCan('edit') || !RevisionReview::userCanSetFlags($form->dims,$form->oflags,$form->config) )
			$this->dieUsage( "You don't have the necessary rights to set the specified flags.", 'permissiondenied' );

		if( $form->isApproval() ) {
			// Now get the template and image parameters needed
			// If it is the current revision, try the parser cache first
			$article = new Article( $title, $revid );
			if( $rev->isCurrent() ) {
				$parserCache = ParserCache::singleton();
				$parserOutput = $parserCache->get( $article, $wgUser );
			}
			if( empty( $parserOutput ) ) {
				// Miss, we have to reparse the page
				global $wgParser;
				$text = $article->getContent();
				$options = FlaggedRevs::makeParserOptions();
				$parserOutput = $wgParser->parse( $text, $title, $options );
			}
			// Set version parameters for review submission
			list( $form->templateParams, $form->imageParams, $form->fileVersion ) =
				FlaggedRevs::getIncludeParams( $article, $parserOutput->mTemplateIds, $parserOutput->fr_ImageSHA1Keys );
		}
		
		// Do the actual review
		list( $approved, $status ) = $form->submit();
		if( $status === true ) {
			$this->getResult()->addValue( null, $this->getModuleName(), array( 'result' => 'Success' ) );
		} elseif( $approved && is_array( $status ) ) {
			$this->dieUsage( "A sync failure has occured while reviewing. Please try again.", 'syncfailure' );
		} elseif( $approved ) {
			$this->dieUsage( "Cannot find a revision with the specified ID.", 'notarget' );
		} else {
			$this->dieUsageMsg( array( 'unknownerror' ) );
		}
	}

	public function mustBePosted() {
		return true;
	}
	
	public function isWriteMode() { 
 		return true; 
 	}

	public function getAllowedParams() {
		$pars = array(
			'revid' => null,
			'token' => null,
			'comment' => null,
		);
		if( FlaggedRevs::allowComments() )
			$pars['notes'] = null;
		if( FlaggedRevs::dimensionsEmpty() ) {
			$pars['unapprove'] = false;
		} else {
			foreach( FlaggedRevs::getDimensions() as $flagname => $levels ) {
				$pars['flag_' . $flagname] = array(
					ApiBase::PARAM_DFLT => 1, // default
					ApiBase::PARAM_TYPE => array_keys( $levels ) // array of allowed values
				);
			}
		}
		return $pars;
	}

	public function getParamDescription() {
		$desc = array(
			'revid' => 'The revision ID for which to set the flags',
			'token' => 'An edit token retrieved through prop=info',
			'comment' => 'Comment for the review (optional)',
			//Only if FlaggedRevs::allowComments() is true:
			'notes' => "Additional notes for the review. The ``validate'' right is needed to set this parameter.",
			//Will only show if FlaggedRevs::dimensionsEmpty() is true:
			'unapprove' => "If set, revision will be unapproved"
		);
		foreach( FlaggedRevs::getDimensions() as $flagname => $levels )
			$desc['flag_' . $flagname] = "Set the flag ''{$flagname}'' to the specified value";		
		return $desc;
	}

	public function getDescription() {
		return 'Review a revision via FlaggedRevs.';
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'badaccess-group0' ),
			array( 'blockedtext' ),
			array( 'code' => 'notarget', 'info' => 'Provided revision or page can not be reviewed.' ),
			array( 'code' => 'notreviewable', 'info' => 'Provided revision or page can not be reviewed.' ),
			array( 'code' => 'mixedapproval', 'info' => 'Either all or none of the flags have to be set to zero.' ),
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have the necessary rights to set the specified flags.' ),
			array( 'code' => 'syncfailure', 'info' => 'A sync failure has occured while reviewing. Please try again.' ),
		) );
	}
	
	public function getTokenSalt() {
		return '';
	}

	protected function getExamples() {
		return 'api.php?action=review&revid=12345&token=123AB&flag_accuracy=1&comment=Ok';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiReview.php 62624 2010-02-17 00:05:38Z reedy $';
	}
}
