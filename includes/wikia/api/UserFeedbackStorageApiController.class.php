<?php

use Wikia\Interfaces\IRequest;

class UserFeedbackStorageApiController extends WikiaApiController {
	const FEEDBACK_TABLE_NAME = 'experiments_user_feedback';

	/**
	 * Saves user feedback to a temporary table in the portable_flags db
	 *
	 * @requestParam int wikiId
	 * @requestParam int pageId
	 * @requestParam int experimentId
	 * @requestParam int variationId
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
		$positiveIntRequired = [
			'experimentId' => 'experiment_id',
			'wikiId' => 'wiki_id',
			'pageId' => 'page_id',
		];

		foreach ( $positiveIntRequired as $paramName => $dbFieldName ) {
			$paramValue = $request->getInt( $paramName );

			if ( $paramValue === 0 ) {
				throw new MissingParameterApiException( $paramName );
			} else {
				$requestParams[$dbFieldName] = $paramValue;
			}
		}

		$requestParams = $requestParams + [
				'user_id' => $this->getContext()->getUser()->getId(),
				'variation_id' => $request->getInt( 'variationId' ),
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
