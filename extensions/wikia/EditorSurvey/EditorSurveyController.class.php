<?php

class EditorSurveyController extends WikiaController {
	public function index() {
		global $wgCityId;
		$type = $this->request->getVal('type');

		// WAM check
		$wamData = $this->app->sendRequest('WAMApiController', 'getWAMIndex', ['wiki_id' => $wgCityId])->getData();
		if ( count( $wamData['wam_index'] ) ) {
			$rank = $wamData['wam_index'][$wgCityId]['wam_rank'];

			if ( $rank <= 100 ) {
				$this->response->setFormat( 'json' );
				$this->response->setVal( 'wam', true );
				return true;
			}
		}

		// Template vars
		$this->heading = wfMsg('editorsurvey-heading');
		if ( $type == 've-success' ) {
			$this->body = wfMsg('editorsurvey-success');
			$this->surveyUrl = 'https://docs.google.com/forms/d/17PSLHGQopOrEYCNAm_v2ZqA90HCcMXDHmPJrZHh7IVI/viewform';
		} else if ( $type == 've-fail' ) {
			$this->body = wfMsg('editorsurvey-fail');
			$this->surveyUrl = 'https://docs.google.com/forms/d/1Dp_aW0B7-j7lE39qEpQxRwKH2QPOUAL4iW0wZH2Bq4E/viewform';
		} else if ( $type == 'ck-success' ) {
			$this->body = wfMsg('editorsurvey-success');
			$this->surveyUrl = 'https://docs.google.com/forms/d/12HQsoPoB-bXq5UMUsHxkdWIG0aLA3JAHxxcgqpZrM3M/viewform';
		} else if ( $type == 'ck-fail' ) {
			$this->body = wfMsg('editorsurvey-fail');
			$this->surveyUrl = 'https://docs.google.com/forms/d/1Mne6ZGeRVNAmmtVsPsOZL5SqGD093CxABXhaz8tVHRo/viewform';
		}
	}
};

