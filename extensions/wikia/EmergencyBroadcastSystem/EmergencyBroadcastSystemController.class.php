<?php
class EmergencyBroadcastSystemController extends WikiaController {

	public function index() {
		if ( $this->isCorrectPage() && $this->isPowerUser() && $this->hasNonPortableInfoBoxes() && $this->canOpenEBS() ) {
			$this->response->setVal( 'nonPortableCount', '3' ); // Temporary number for testing
			$this->response->setVal( 'surveyUrl', $this->buildSurveyUrl() );
		} else {
			return false;
		}
	}

	public static function saveUserResponse( $val ) {
		global $wgUser;
		$option_name = 'ebs_response';
		if ($val === null) {
			// invalid call, do nothing
			wfErrorLog( 'Invalid call to EmergencyBroadcastSystemController::saveUserResponse()', $wgDebugLogFile );
		} elseif ($val === 0) { // no
			// if user clicks no, set ebs_response to 0
			$wgUser->setOption( $option_name, 0 );
		} else {
			// if user clicks yes, set ebs_response to the current time
			$timestamp = (new DateTime())->getTimestamp();
			$wgUser->setOption( $option_name, $timestamp );
		}
	}
	// PROTECTED

	protected function isCorrectPage() {
		$title = $this->getContext()->getTitle();
		$specialPageName = $title->isSpecialPage() ? Transaction::getAttribute(Transaction::PARAM_SPECIAL_PAGE_NAME) : '';

		return $title->isContentPage() || $specialPageName === 'WikiActivity' || $specialPageName === 'Recentchanges';
	}

	protected function isPowerUser() {
		$user = $this->getContext()->getUser();
		return $user->isPowerUser();
	}

	protected function canOpenEBS( ) {
		global $wgUser;
		$ebs_response = $wgUser->getOption( 'ebs_response' );
		if ($ebs_response === null) {
			// user has not seen/interacted with EBS yet, so display it
			return true;
		} elseif ($ebs_response === 0) {
			// user has clicked 'no', don't display it
			return false;
		} else {
			$curr_timestamp = (new DateTime())->getTimestamp();
			$cutoff_timestamp = $curr_timestamp - 24*60*60; // 24 hrs ago

			// if the timestamp is more than 24 hours ago, display it
			if ($ebs_response < $cutoff_timestamp) {
				return true;
			} else {
				return false;
			}
		}
	}

	protected function hasNonPortableInfoBoxes() {
		// TODO: Actually check for non portable infoboxes
		return true;
	}

	protected function buildSurveyUrl() {
		global $wgContLang;

		$context = $this->getContext();
		$userLanguage = $context->getLanguage();
		$userName = $context->getUser()->getName();

		$url = $this->googleFormUrl( $userLanguage->mCode, $userName );

		if ( $url === null ) {
			$url = $this->googleFormUrl( $wgContLang->mCode, $userName );
		}

		if ( $url === null ) {
			$url = $this->googleFormUrl( 'en', $userName );
		}

		return $url;
	}

	protected function googleFormUrl( $language, $userName ) {
		global $wgServer;

		$domain = parse_url( $wgServer, PHP_URL_HOST );
		$forms = [
			'de' => "https://docs.google.com/forms/d/1Ks_uhxdi5Cb9EiNDup4bc7O6kI3Dl6rjq7AjlfqtX9A/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'en' => "https://docs.google.com/forms/d/18qE5ub8qs8bkrubcN-00JxuLrfnfpJ88MyGhq1x3RpY/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'es' => "https://docs.google.com/forms/d/1MLwwR8t-uoIOBXjjlW7YnBLOOrbH8_19Q3N5Bttqp0Y/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'fr' => "https://docs.google.com/forms/d/1MUAxAhzIU5rQfaPeBAX3sDHCcxA87L74R04D2TftPx8/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'it' => "https://docs.google.com/forms/d/1R4CHKl620CGwPGcMwQMC3VCnQ2v1LCZKf8JanAoKxj8/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'ja' => "https://docs.google.com/forms/d/1Cn1MkdtNn3HF6eaUmqU2VTcvOm9D-KOl3EoIgMNX_Rs/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'pl' => "https://docs.google.com/forms/d/1fbsGFW01P6vJ_vqAH2yH-CM27K-a484k34Ne1Qc6r00/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'pt-br' => "https://docs.google.com/forms/d/1sYpFtiR-vewJegYXO2gfMtvv-wz2Aml4xuVXzSZtssU/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'ru' => "https://docs.google.com/forms/d/1yH_MiPY9GRj9yXYUjuUwu2Z_e2bulTZp5GXAd0NaB-8/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849",
			'zh' => "https://docs.google.com/forms/d/1vnLsNYhWPa4lghIMyC8Eyu6gK0dZ0N3j4_RP1K3HH28/viewform?entry.2019588325={$userName}&entry.1160019288={$domain}&entry.830663849"
		];

		return $forms[ $language ];
	}
}
