<?php
class EmergencyBroadcastSystemController extends WikiaController {

	public function index() {
		$nonPortableCount = $this->countOfNonPortableInfoBoxes();
		if ( $this->isCorrectPage() && $this->isPowerUser() && $this->canOpenEBS() && ( $nonPortableCount > 0 ) ) {
			$this->response->setVal( 'nonPortableCount', $nonPortableCount ); // Temporary number for testing
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

	protected function countOfNonPortableInfoboxes() {
		$nonPortableInfoboxes = PortableInfoboxQueryService::getNonportableInfoboxes();
		return count($nonPortableInfoboxes);
	}
}
