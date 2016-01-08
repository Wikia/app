<?php

class EmergencyBroadcastSystemController extends WikiaController {

	const EBS_RESPONSE_KEY = 'ebs_response';

	public function index() {
		if ( $this->isQualifiedUser() && $this->isQualifiedPage() ) {
			$count = $this->getCountOfNonPortableInfoboxes();
			if ( $count > 0 ) {
				$this->response->setVal( 'nonPortableCount', $count );
				$this->response->setVal( 'surveyUrl', $this->buildSurveyUrl() );
				$this->response->setVal( 'specialPageUrl', SpecialPage::getTitleFor( 'Insights', 'nonportableinfoboxes' )->getLocalURL() );
				return true;
			}
		}
		return false;
	}

	public function saveUserResponse() {
		$this->checkWriteRequest();

		$user = $this->context->getUser();
		$val = $this->request->getInt( 'val', null );

		if ( $val === 0 ) { // no
			// if user clicks no, set ebs_response to 0
			$user->setOption( self::EBS_RESPONSE_KEY, 0 );
		} elseif ( $val === 1 ) { // yes
			// if user clicks yes, set ebs_response to the current time
			$user->setOption( self::EBS_RESPONSE_KEY, ( new DateTime() )->getTimestamp() );
		} else if ( $val === -1 ) { // for testing purposes
			$user->setOption( self::EBS_RESPONSE_KEY, null );
		} else {
			// invalid call, do nothing
			// TODO: Figure out proper way to log error
		}
		$user->saveSettings();
	}

	protected function isQualifiedUser() {
		$user = $this->context->getUser();

		if ( !$user->isPowerUser() ) {
			return false;
		}

		$ebsResponse = $user->getOption( self::EBS_RESPONSE_KEY );

		if ( $ebsResponse === null )  { // user has not seen/interacted with EBS yet
			return true;
		}

		$ebsResponse = intval( $ebsResponse );

		if ( $ebsResponse === 0 ) { // user has clicked 'no'
			return false;
		} else {
			$currentTimestamp = ( new DateTime() )->getTimestamp();
			$cutoffTimestamp = $currentTimestamp - 24 * 60 * 60; // 24 hrs ago
			return $ebsResponse < $cutoffTimestamp;
		}
	}

	protected function isQualifiedPage() {
		$title = $this->context->getTitle();
		$specialPageName = $title->isSpecialPage() ? Transaction::getAttribute( Transaction::PARAM_SPECIAL_PAGE_NAME ) : null;
		return $title->isContentPage() || $specialPageName === 'WikiActivity' || $specialPageName === 'Recentchanges';
	}

	protected function getCountOfNonPortableInfoboxes() {
		return count( PortableInfoboxQueryService::getNonportableInfoboxes() );
	}
	
	protected function buildSurveyUrl() {
		global $wgContLang, $wgServer;

		$formUrls = [
			'de' => 'https://docs.google.com/forms/d/1Ks_uhxdi5Cb9EiNDup4bc7O6kI3Dl6rjq7AjlfqtX9A/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'en' => 'https://docs.google.com/forms/d/18qE5ub8qs8bkrubcN-00JxuLrfnfpJ88MyGhq1x3RpY/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'es' => 'https://docs.google.com/forms/d/1MLwwR8t-uoIOBXjjlW7YnBLOOrbH8_19Q3N5Bttqp0Y/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'fr' => 'https://docs.google.com/forms/d/1MUAxAhzIU5rQfaPeBAX3sDHCcxA87L74R04D2TftPx8/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'it' => 'https://docs.google.com/forms/d/1R4CHKl620CGwPGcMwQMC3VCnQ2v1LCZKf8JanAoKxj8/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'ja' => 'https://docs.google.com/forms/d/1Cn1MkdtNn3HF6eaUmqU2VTcvOm9D-KOl3EoIgMNX_Rs/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'pl' => 'https://docs.google.com/forms/d/1fbsGFW01P6vJ_vqAH2yH-CM27K-a484k34Ne1Qc6r00/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'pt-br' => 'https://docs.google.com/forms/d/1sYpFtiR-vewJegYXO2gfMtvv-wz2Aml4xuVXzSZtssU/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'ru' => 'https://docs.google.com/forms/d/1yH_MiPY9GRj9yXYUjuUwu2Z_e2bulTZp5GXAd0NaB-8/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849',
			'zh' => 'https://docs.google.com/forms/d/1vnLsNYhWPa4lghIMyC8Eyu6gK0dZ0N3j4_RP1K3HH28/viewform?entry.2019588325=%s&entry.1160019288=%s&entry.830663849'
		];

		$context = $this->getContext();
		$language = $context->getLanguage()->getCode(); // user language
		if ( !isset( $formUrls[ $language ] ) ) {
			$language = $wgContLang->getCode(); // content language
			if ( !isset( $formUrls[ $language ] ) ) {
				$language = 'en';
			}
		}

		return sprintf( $formUrls[ $language ], $context->getUser()->getName(), parse_url( $wgServer, PHP_URL_HOST ) );
	}
}
