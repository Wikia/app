<?php

/**
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
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
		// Check basic permissions
		if ( !$wgUser->isAllowed( 'review' ) ) {
			$this->dieUsage( "You don't have the right to review revisions.",
				'permissiondenied' );
		} elseif ( $wgUser->isBlocked( false ) ) {
			$this->dieUsageMsg( array( 'blockedtext' ) );
		}

		// Get target rev and title
		$revid = (int)$params['revid'];
		$rev = Revision::newFromId( $revid );
		if ( !$rev ) {
			$this->dieUsage( "Cannot find a revision with the specified ID.", 'notarget' );
		}
		$title = $rev->getTitle();

		// Construct submit form...
		$form = new RevisionReviewForm( $wgUser );
		$form->setPage( $title );
		$form->setOldId( $revid );
		$form->setApprove( empty( $params['unapprove'] ) );
		$form->setUnapprove( !empty( $params['unapprove'] ) );
		if ( isset( $params['comment'] ) ) {
			$form->setComment( $params['comment'] );
		}
		// The flagging parameters have the form 'flag_$name'.
		// Extract them and put the values into $form->dims
		foreach ( FlaggedRevs::getTags() as $tag ) {
			$form->setDim( $tag, (int)$params['flag_' . $tag] );
		}
		if ( $form->getAction() === 'approve' ) {
			$article = new FlaggableWikiPage( $title );
			// Get the file version used for File: pages
			$file = $article->getFile();
			if ( $file ) {
				$fileVer = array( 'time' => $file->getTimestamp(), 'sha1' => $file->getSha1() );
			} else {
				$fileVer = null;
			}
			// Now get the template and image parameters needed
			list( $templateIds, $fileTimeKeys ) =
				FRInclusionCache::getRevIncludes( $article, $rev, $wgUser );
			// Get version parameters for review submission (flat strings)
			list( $templateParams, $imageParams, $fileParam ) =
				RevisionReviewForm::getIncludeParams( $templateIds, $fileTimeKeys, $fileVer );
			// Set the version parameters...
			$form->setTemplateParams( $templateParams );
			$form->setFileParams( $imageParams );
			$form->setFileVersion( $fileParam );
			$form->bypassValidationKey(); // always OK; uses current templates/files
		}
		$status = $form->ready(); // all params set

		# Try to do the actual review
		$status = $form->submit();
		# Approve/de-approve success
		if ( $status === true ) {
			$this->getResult()->addValue(
				null, $this->getModuleName(), array( 'result' => 'Success' ) );
		# Approve-specific failures
		} elseif ( $form->getAction() === 'approve' ) {
			if ( $status === 'review_denied' ) {
				$this->dieUsage( "You don't have the necessary rights to set the specified flags.",
					'permissiondenied' );
			} elseif ( $status === 'review_too_low' ) {
				$this->dieUsage( "Either all or none of the flags have to be set to zero.",
					'mixedapproval' );
			} elseif ( $status === 'review_bad_key' ) {
				$this->dieUsage( "You don't have the necessary rights to set the specified flags.",
					'permissiondenied' );
			} elseif ( $status === 'review_bad_tags' ) {
				$this->dieUsage( "The specified flags are not valid.", 'invalidtags' );
			} elseif ( $status === 'review_bad_oldid' ) {
				$this->dieUsage( "No revision with the specified ID.", 'notarget' );
			} else {
				// FIXME: review_param_missing? better msg?
				$this->dieUsageMsg( array( 'unknownerror', '' ) );
			}
		# De-approve specific failure
		} elseif ( $form->getAction() === 'unapprove' ) {
			if ( $status === 'review_denied' ) {
				$this->dieUsage( "You don't have the necessary rights to remove the flags.",
					'permissiondenied' );
			} elseif ( $status === 'review_not_flagged' ) {
				$this->dieUsage( "No flagged revision with the specified ID.", 'notarget' );
			} else {
				// FIXME: review_param_missing? better msg?
				$this->dieUsageMsg( array( 'unknownerror', '' ) );
			}
		# Generic failures
		} else {
			if ( $status === 'review_page_unreviewable' ) {
				$this->dieUsage( "Provided page is not reviewable.", 'notreviewable' );
			} elseif ( $status === 'review_page_notexists' ) {
				$this->dieUsage( "Provided page does not exist.", 'notarget' );
			}
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
			'revid'   	=> null,
			'token'   	=> null,
			'comment' 	=> null,
			'unapprove' => false
		);
		if ( !FlaggedRevs::binaryFlagging() ) {
			foreach ( FlaggedRevs::getDimensions() as $flagname => $levels ) {
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
			'revid'  	=> 'The revision ID for which to set the flags',
			'token'   	=> 'An edit token retrieved through prop=info',
			'comment' 	=> 'Comment for the review (optional)',
			'unapprove' => 'If set, revision will be unapproved rather than approved.'
		);
		if ( !FlaggedRevs::binaryFlagging() ) {
			foreach ( FlaggedRevs::getTags() as $flagname ) {
				$desc['flag_' . $flagname] = "Set the flag ''{$flagname}'' to the specified value";
			}
		}
		return $desc;
	}

	public function getDescription() {
		return 'Review a revision by approving or de-approving it';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'notarget',
				'info' => 'Provided revision or page can not be found.' ),
			array( 'code' => 'notreviewable',
				'info' => 'Provided page is not reviewable.' ),
			array( 'code' => 'mixedapproval',
				'info' => 'No flags can be set to zero when accepting a revision.' ),
			array( 'code' => 'invalidtags',
				'info' => 'The given tags have a value that is out of range.' ),
			array( 'code' => 'permissiondenied',
				'info' => 'Insufficient rights to set the specified flags or review/edit the page.' ),
		) );
	}

	public function needsToken() {
		return true;
	}

    public function getTokenSalt() {
		return '';
	}

	public function getExamples() {
		return 'api.php?action=review&revid=12345&token=123AB&flag_accuracy=1&comment=Ok';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiReview.php 106625 2011-12-19 04:19:38Z aaron $';
	}
}
