<?php

class EditorSurveyController extends WikiaController {
	public static $surveyIds = [
		'ck-fail' => '1Mne6ZGeRVNAmmtVsPsOZL5SqGD093CxABXhaz8tVHRo',
		'ck-success' => '12HQsoPoB-bXq5UMUsHxkdWIG0aLA3JAHxxcgqpZrM3M',
		've-fail' => '1Dp_aW0B7-j7lE39qEpQxRwKH2QPOUAL4iW0wZH2Bq4E',
		've-success' => '17PSLHGQopOrEYCNAm_v2ZqA90HCcMXDHmPJrZHh7IVI'
	];

	public function index() {
		global $wgCityId;

		$response = [ 'html' => '' ];

		// WAM check
		$wamData = $this->app->sendRequest( 'WAMApiController', 'getWAMIndex', [
			'wiki_id' => $wgCityId
		])->getData();

		if ( count( $wamData['wam_index'] ) ) {
			$response['wam_rank'] = $wamData['wam_index'][$wgCityId]['wam_rank'];
		}

		if ( !isset( $response['wam_rank'] ) || $response['wam_rank'] > 100 ) {
			$type = $this->request->getVal( 'type' );
			$bodyMsgKey = 'editorsurvey-' . ( endsWith( $type, 'success' ) ? 'success' : 'fail' );
			$surveyUrl = 'https://docs.google.com/forms/d/' . static::$surveyIds[$type] . '/viewform';
			$response['html'] = $this->app->renderPartial( 'EditorSurveyController', 'modal', [
				'body' => wfMsg( $bodyMsgKey ),
				'heading' => wfMsg( 'editorsurvey-heading' ),
				'cancelButton' => wfMsg( 'editorsurvey-cancelButton' ),
				'takeSurveyButton' => wfMsg( 'editorsurvey-takeSurveyButton' ),
				'surveyUrl' => $surveyUrl
			]);
		}

		$this->response->setData( $response );
		$this->response->setFormat( 'json' );
	}
};

