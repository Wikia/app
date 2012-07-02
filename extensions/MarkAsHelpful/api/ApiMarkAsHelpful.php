<?php

class ApiMarkAsHelpful extends ApiBase {

	public function execute() {
		global $wgUser;

		if ( $wgUser->isBlocked( false ) ) {
			$this->dieUsageMsg( array( 'blockedtext' ) );
		}

		// Disallow anonymous user to mark/unmark an 'Mark As Helpful' item
		if ( $wgUser->isAnon() ) {
			$this->noPermissionError();
		}

		$params = $this->extractRequestParams();

		$page = Title::newFromText( $params['page'] );

		if ( !$page ) {
			throw new MWApiMarkAsHelpfulInvalidPageException( 'Invalid page!' );
		}
		
		// check if current user has permission to mark the item,
		$isAbleToMark = false; 
		// check if the page has permission to request the item
		$isAbleToShow = false;

		// Gives other extension the last chance to specify mark as helpful permission rules
		wfRunHooks( 'onMarkItemAsHelpful', array( $params['type'], $params['item'], $wgUser, &$isAbleToMark, $page, &$isAbleToShow ) );

		if ( !$isAbleToShow || !$isAbleToMark ) {
			$this->noPermissionError();
		}

		$error = false;

		switch ( $params['mahaction'] ) {
			case 'mark':
				$item = new MarkAsHelpfulItem();
				$item->loadFromRequest( $params );
				$item->mark();
				break;

			case 'unmark':
				$item = new MarkAsHelpfulItem();

				$conds = array( 'mah_type' => $params['type'],
						'mah_item' => $params['item'],
						'mah_user_id' => $wgUser->getId() );

				$status = $item->loadFromDatabase( $conds );

				if ( $status ) {
					$item->unmark( $wgUser );
				} else {
					$error = true;
				}
				break;

			default:
				throw new MWApiMarkAsHelpfulInvalidActionException( "Action {$params['mbaction']} not implemented" );
		}

		if ( $error === false ) {
			$result = array( 'result' => 'success' );
		} else {
			$result = array( 'result' => 'error', 'error' => 'mah-action-error' );
		}
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	private function noPermissionError() {
		$this->dieUsage( "You don't have permission to do that", 'permission-denied' );
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		global $wgMarkAsHelpfulType;

		return array(
			'mahaction' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array( 'mark', 'unmark' ),
			),
			'page' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'type' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => $wgMarkAsHelpfulType,
			),
			'item' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'integer'
			),
			'useragent' => null,
			'system' => null,
			'locale' => null,
			'token' => null,
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiMarkAsHelpful.php 107587 2011-12-29 19:08:57Z bsitu $';
	}

	public function getParamDescription() {
		return array(
			'mahaction' => 'the mark or unmark an item as helpful',
			'page' => 'The page which the item to be marked is on',
			'type' => 'The object type that is being marked as helpful',
			'item' => 'The object item that is being marked as helpful',
			'useragent' => 'The User-Agent header of the browser',
			'system' => 'The operating system being used',
			'locale' => 'The locale in use',
			'token' => 'An edit token',
		);
	}

	public function getDescription() {
		return 'Allows users to mark/unmark an object item in the site as helpful';
	}

}

class MWApiMarkAsHelpfulInvalidActionException extends MWException {}
class MWApiMarkAsHelpfulInvalidPageException extends MWException {}