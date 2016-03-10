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
	 * @throws MissingParameterApiException
	 */
	public function saveUserFeedback() {
		$this->checkWriteRequest();
		$request = $this->getRequest();

		$requestParams = $this->getRequestData( $request );

		$db = $this->getDatabaseForWrite();
		$status = $db->insert( self::FEEDBACK_TABLE_NAME, $requestParams );

		if ($status) {
			$db->commit();
		}

		$this->response->setVal( 'status', $status );
	}

	/**
	 * @param IRequest $request
	 * @return array
	 * @throws MissingParameterApiException
	 */
	private function getRequestData( IRequest $request ) {
		$requestData = [];
		$positiveIntRequired = [
			'experimentId' => 'experiment_id',
			'variationId' => 'variation_id',
			'wikiId' => 'wiki_id',
			'pageId' => 'page_id',
		];

		foreach ( $positiveIntRequired as $paramName => $dbFieldName ) {
			$paramValue = $request->getInt( $paramName );

			if ( $paramValue === 0 ) {
				throw new MissingParameterApiException( $paramName );
			} else {
				$requestData[$dbFieldName] = $paramValue;
			}
		}

		$requestData = $requestData + [
			'user_id' => $request->getInt( 'userId' ),
			'feedback' => $request->getVal( 'feedback', '' ),
			'feedback_impressions_count' => $request->getInt( 'feedbackImpressionsCount' ),
			'feedback_previous_count' => $request->getInt( 'feedbackPreviousCount' ),
		];

		return $requestData;
	}

	/**
	 * @return DatabaseMysqli
	 */
	private function getDatabaseForWrite() {
		global $wgFlagsDB;

		return wfGetDB( DB_MASTER, [], $wgFlagsDB );
	}
}
