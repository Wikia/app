<?php
/**
 * API module for marking translations as reviewed
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2011, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * API module for marking translations as reviewed
 *
 * @ingroup API TranslateAPI
 */
class ApiTranslationReview extends ApiBase {
	protected static $right = 'translate-messagereview';
	protected static $salt = 'translate-messagereview';

	public function execute() {
		global $wgUser;
		if ( !$wgUser->isallowed( self::$right ) ) {
			$this->dieUsage( 'Permission denied', 'permissiondenied' );
		}

		$params = $this->extractRequestParams();

		$revision = Revision::newFromId( $params['revision'] );
		if ( !$revision ) {
			$this->dieUsage( 'Invalid revision', 'invalidrevision' );
		}

		$title = $revision->getTitle();
		$handle = new MessageHandle( $title );
		if ( !$handle->isValid() ) {
			$this->dieUsage( 'Unknown message', 'unknownmessage' );
		}

		if ( $handle->isFuzzy() ) {
			$this->dieUsage( 'Cannot review fuzzy translations', 'fuzzymessage' );
		}

		if ( $revision->getUser() == $wgUser->getId() ) {
			$this->dieUsage( 'Cannot review own translations', 'owntranslation' );
		}

		$dbw = wfGetDB( DB_MASTER );
		$table = 'translate_reviews';
		$row = array(
			'trr_user' => $wgUser->getId(),
			'trr_page' => $revision->getPage(),
			'trr_revision' => $revision->getId(),
		);
		$options = array( 'IGNORE' );
		$res = $dbw->insert( $table, $row, __METHOD__, $options );
		if ( !$dbw->affectedRows() ) {
			$this->setWarning( 'Already marked as reviewed by you' );
		} else {
			$logger = new LogPage( 'translationreview' );
			$params = array( $revision->getId() );
			$logger->addEntry( 'message', $title, null, $params, $wgUser );
		}

		$output = array( 'review' => array(
			'title' => $title->getPrefixedText(),
			'pageid' => $revision->getPage(),
			'revision' => $revision->getId()
		) );

		$this->getResult()->addValue( null, $this->getModuleName(), $output );
	}

	public function isWriteMode() {
		return true;
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return self::$salt;
	}

	public function getAllowedParams() {
		return array(
			'revision' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
			),
			'token' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'revision' => 'The revision number to review',
			'token' => 'A token previously acquired with action=query&prop=info&intoken=translationreview',
		);
	}

	public function getDescription() {
		return 'Mark translations reviewed';
	}

	public function getPossibleErrors() {
		$right = self::$right;
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => "You must have $right right" ),
			array( 'code' => 'unknownmessage', 'info' => 'Title $1 does not belong to a message group' ),
			array( 'code' => 'fuzzymessage', 'info' => 'Cannot review fuzzy translations' ),
			array( 'code' => 'owntranslation', 'info' => 'Cannot review own translations' ),
			array( 'code' => 'invalidrevision', 'info' => 'Revision $1 is invalid' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=translationreview&revision=1&token=foo',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiTranslationReview.php 101622 2011-11-02 13:15:39Z nikerabbit $';
	}

	public static function getToken( $pageid, $title ) {
		global $wgUser;
		if ( !$wgUser->isAllowed( self::$right ) ) {
			return false;
		}

		static $cachedToken = null;
		if ( !is_null( $cachedToken ) ) {
			return $cachedToken;
		}

		$cachedToken = $wgUser->editToken( self::$salt );
		return $cachedToken;
	}

	public static function injectTokenFunction( &$list ) {
		$list['translationreview'] = array( __CLASS__, 'getToken' );
		return true; // Hooks must return bool
	}

}
