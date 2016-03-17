<?php

use Wikia\Interfaces\IRequest;

class UserFeedbackStorageApiController extends WikiaApiController {
	const FEEDBACK_TABLE_NAME = 'experiments_user_feedback';

	/**
	 * Saves user feedback to a temporary table in the portable_flags db
	 *
	 * @requestParam int wikiId (required)
	 * @requestParam string pageTitle (required)
	 * @requestParam string experimentId (required)
	 * @requestParam string variationId (required)
	 * @requestParam int userId
	 * @requestParam string feedback
	 * @requestParam int feedback_impression_count
	 * @requestParam int feedback_previous_count
	 * @responseParam bool status
	 * @throws MissingParameterApiException
	 */
	public function saveUserFeedback() {
		$this->checkWriteRequest();
		$request = $this->getRequest();

		$requestParams = $this->getRequestParams( $request );

		$db = $this->getDatabaseForWrite();
		$status = $db->insert( self::FEEDBACK_TABLE_NAME, $requestParams, __METHOD__ );

		if ( $status ) {
			$db->commit();
		}

		$this->response->setVal( 'status', $status );
	}

	/**
	 * @responseParam string editToken
	 */
	public function getEditToken() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'token', $this->getContext()->getUser()->getEditToken() );
	}

	/**
	 * @param IRequest $request
	 * @return array
	 * @throws MissingParameterApiException
	 */
	private function getRequestParams( IRequest $request ) {
		$requestParams = [];
		$requiredParams = [
			'experimentId' => 'experiment_id',
			'pageTitle' => 'page_title',
			'variationId' => 'variation_id',
		];

		foreach ( $requiredParams as $paramName => $dbFieldName ) {
			$paramValue = $request->getVal( $paramName );

			if ( empty( $paramValue ) ) {
				throw new MissingParameterApiException( $paramName );
			} else {
				$requestParams[$dbFieldName] = $paramValue;
			}
		}

		$wikiId = $request->getInt( 'wikiId' );
		if ( $wikiId === 0 ) {
			throw new MissingParameterApiException( 'wikiId' );
		}

		$requestParams = $requestParams + [
				'wiki_id' => $wikiId,
				'user_id' => $this->getContext()->getUser()->getId(),
				'feedback' => $request->getVal( 'feedback', '' ),
				'feedback_impressions_count' => $request->getInt( 'feedbackImpressionsCount' ),
				'feedback_previous_count' => $request->getInt( 'feedbackPreviousCount' ),
			];

		return $requestParams;
	}

	/**
	 * @return DatabaseMysqli
	 */
	private function getDatabaseForWrite() {
		global $wgFlagsDB;

		return wfGetDB( DB_MASTER, [], $wgFlagsDB );
	}
}
