<?php

class EmergencyBroadcastSystemController extends WikiaController {

	const EBS_RESPONSE_KEY = 'ebs_response';

	public function index() {
		if ( $this->isQualifiedUser() && $this->isQualifiedPage() ) {
			$count = $this->getCountOfNonPortableInfoboxes();
			if ( $count > 0 ) {
				$this->response->setVal( 'nonPortableCount', $count );
				return true;
			}
		}
		return false;
	}

	public function saveUserResponse( $val ) {
		$user = $this->context->getUser();
		$data = $this->request->getParams();

		if ( $data[ 'val']  === '0' ) { // no
			// if user clicks no, set ebs_response to 0
			$user->setOption( self::EBS_RESPONSE_KEY, 0 );
		} elseif ( $data[ 'val' ] === '1' ) { // yes
			// if user clicks yes, set ebs_response to the current time
			$user->setOption( self::EBS_RESPONSE_KEY, ( new DateTime() )->getTimestamp() );
		} else if ( $data[ 'val']  === '-1' ) { // for testing purposes
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

		$ebs_response = $user->getOption( self::EBS_RESPONSE_KEY );
		if ( $ebs_response === null )  { // user has not seen/interacted with EBS yet
                        return true;
		} elseif ( $ebs_response === 0 ) { // user has clicked 'no'
			return false;
		} else {
			$current_timestamp = ( new DateTime() )->getTimestamp();
                        $cutoff_timestamp = $current_timestamp - 24 * 60 * 60; // 24 hrs ago
			return $ebs_response < $cutoff_timestamp;
		}
	}

	protected function isQualifiedPage() {
		$title = $this->context->getTitle();
		$specialPageName = $title->isSpecialPage() ? Transaction::getAttribute( Transaction::PARAM_SPECIAL_PAGE_NAME ) : null;
		return $title->isContentPage() || $specialPageName === 'WikiActivity' || $specialPageName === 'Recentchanges';
	}

	protected function getCountOfNonPortableInfoboxes() {
		return 5;
	}

}
